<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Answers;
use App\Models\Candidate;
use App\Models\Questions;
use App\Models\CorrectAnswers;
use App\Models\Choices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GradingController extends Controller
{
    public function markAnswers()
    {
        $markingScheme = $this->loadCorrectAnswers();
        $submittedAnswers = Answers::all();

        foreach ($submittedAnswers as $answer) {
            $question = Questions::find($answer->QuestionID);
            if (!$question) continue;

            $correctAnswer = strtolower($markingScheme[$answer->QuestionID] ?? '');
            $studentAnswer = strtolower($answer->text);
            $status = 'incorrect';
            $score = 0;

            switch (strtolower($question->type)) {
                case 'mcq':
                    $status = ($studentAnswer === $correctAnswer) ? 'correct' : 'incorrect';
                    $score = ($status === 'correct') ? ($question->weight ?? 1) : 0;
                    break;

                case 'mrq':
                    if ($this->isJson($correctAnswer) && $this->isJson($studentAnswer)) {
                        $correctArray = json_decode($correctAnswer, true);
                        $studentArray = json_decode($studentAnswer, true);
                        if (is_array($correctArray) && is_array($studentArray)) {
                            $intersect = array_intersect($studentArray, $correctArray);
                            $score = round((count($intersect) / count($correctArray)) * ($question->weight ?? 1), 2);
                            $status = ($score > 0) ? 'partially_correct' : 'incorrect';
                            if ($this->compareArrays($correctArray, $studentArray)) $status = 'correct';
                        }
                    }
                    break;

                case 'practical':
                    $grading = $this->gradePracticalAnswerViaDocker($answer, $question);
                    $status = $grading['status'];
                    $score = $grading['score'];
                    break;

                case 'text':
                    // You can use NLP or manual review later
                    $status = 'pending_review';
                    break;

                default:
                    $status = 'incorrect';
                    break;
            }

            $answer->Status = $status;
            $answer->Score = $score;
            $answer->save();
        }

        return redirect()->back()->with('success', 'Answers have been graded successfully!');
    }

    private function loadCorrectAnswers()
    {
        return CorrectAnswers::pluck('AnswerText', 'QuestionID')->map(fn($val) => strtolower($val))->toArray();
    }

    private function isJson($string)
    {
        json_decode($string);
        return (json_last_error() === JSON_ERROR_NONE);
    }

    private function compareArrays($a, $b)
    {
        sort($a);
        sort($b);
        return $a == $b;
    }

    private function gradePracticalAnswerViaDocker($answer, $question)
    {
        $status = 'error';
        $score = 0;

        try {
            // Assuming you have lab info stored with each question
            $dockerImage = $question->docker_image ?? 'python:3.10';
            $extension = $question->language_ext ?? 'py';
            $interpreter = $question->interpreter ?? 'python';

            $code = $answer->text;
            $expected = trim($question->expected_output);
            $input = $question->sample_input ?? '';

            $filename = storage_path("app/code_" . uniqid() . ".{$extension}");
            file_put_contents($filename, $code);

            $command = "docker run --rm -v {$filename}:/code.{$extension} {$dockerImage} {$interpreter} /code.{$extension} {$input}";
            $result = shell_exec($command);
            unlink($filename);

            if (trim($result) === $expected) {
                $score = $question->weight ?? 1;
                $status = 'correct';
            } else {
                $status = 'incorrect';
            }
        } catch (\Exception $e) {
            Log::error("Docker grading failed: " . $e->getMessage());
        }

        return compact('status', 'score');
    }

    public function releaseResults()
    {
        $candidates = Candidate::all();

        foreach ($candidates as $candidate) {
            Mail::raw("Dear {$candidate->FullName}, your results have been released. Please check your portal.", function ($message) use ($candidate) {
                $message->to($candidate->Email)
                        ->subject('Your Exam Results are Available');
            });

            $candidate->ResultsReleased = true;
            $candidate->save();
        }

        return redirect()->back()->with('success', 'Results have been released and emails sent to all candidates!');
    }

    public function makeQuestions(Request $request)
    {
        $validate = $request->validate([
            'QuestionTitle' => 'required',
            'QuestionText' => 'required',
            'Type' => 'required',
            'QuestionImage' => 'image|nullable',
            'Choices' => 'nullable|array',
            'CorrectAnswer' => 'required'
        ]);

        $question = Questions::create([
            'title' => $validate['QuestionTitle'],
            'text' => $validate['QuestionText'],
            'type' => $validate['Type'],
        ]);

        if ($request->hasFile('QuestionImage')) {
            $path = $request->file('QuestionImage')->storeAs('images', "Question_" . $question->QuestionID . '.' . $request->file('QuestionImage')->extension(), 'public');
            $question->ImagePath = "storage/" . $path;
            $question->save();
        }

        if (!empty($validate['Choices'])) {
            foreach (array_filter($validate['Choices']) as $choice) {
                Choices::create([
                    'QuestionID' => $question->QuestionID,
                    'ChoiceText' => $choice
                ]);
            }
        }

        if (is_array($validate['CorrectAnswer'])) {
            $validate['CorrectAnswer'] = json_encode($validate['CorrectAnswer']);
        }

        CorrectAnswers::create([
            'QuestionID' => $question->QuestionID,
            'AnswerText' => $validate['CorrectAnswer']
        ]);

        return redirect()->back()->with('success', 'Question created successfully!');
    }

    public function viewQuestions()
    {
        $questions = Questions::all();
        return view('ViewQuestions', compact('questions'));
    }

    public function deleteQuestion($id)
    {
        Questions::where('QuestionID', $id)->delete();
        return redirect()->route('ViewQuestions')->with('success', 'Question deleted successfully!');
    }

    public function manageResults()
    {
        $candidates = Candidate::all();
        return view('ManageResults', compact('candidates'));
    }

    public function viewCandidateAnswers($id)
    {
        $candidate = Candidate::findOrFail($id);
        $answers = Answers::where('CertificationID', $candidate->CertificationID)->get();
        $questions = Questions::whereIn('QuestionID', $answers->pluck('QuestionID'))->get()->keyBy('QuestionID');

        return view('ViewCandidateAnswers', compact('candidate', 'answers', 'questions'));
    }

    public function updateAnswerStatus(Request $request, $answerId)
    {
        $answer = Answers::findOrFail($answerId);
        $answer->Status = $request->input('Status');
        $answer->save();

        return back()->with('success', 'Answer status updated successfully!');
    }
}