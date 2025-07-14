<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Answers;
use App\Models\Candidates;
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
        $markingScheme = $this->correctAnswers();
        $submittedAnswers = Answers::all();

        foreach ($submittedAnswers as $submittedAnswer) {
            $question = Questions::find($submittedAnswer->QuestionID);
            if (!$question) continue;

            $correctAnswer = strtolower($markingScheme[$submittedAnswer->QuestionID] ?? '');
            $studentAnswer = strtolower($submittedAnswer->text);
            $status = 'incorrect';

            switch ($question->type) {
                case 'MCQ':
                    if ($studentAnswer === $correctAnswer) $status = 'correct';
                    break;
                case 'MRQ':
                    if ($this->isJson($correctAnswer) && $this->isJson($studentAnswer)) {
                        $correctArray = json_decode($correctAnswer, true);
                        $studentArray = json_decode($studentAnswer, true);
                        if (is_array($correctArray) && is_array($studentArray) && $this->compareArrays($correctArray, $studentArray)) {
                            $status = 'correct';
                        }
                    }
                    break;
                case 'Text':
                case 'Practical':
                    $status = 'pending_review';
                    break;
                default:
                    $status = 'incorrect';
                    break;
            }

            $submittedAnswer->Status = $status;
            $submittedAnswer->save();
        }

        return redirect()->back()->with('success', 'Answers have been graded successfully!');
    }

    public function correctAnswers()
    {
        $markingScheme = [];
        $answers = CorrectAnswers::all();
        foreach ($answers as $answer) {
            $markingScheme[$answer->QuestionID] = $answer->AnswerText;
        }
        return $markingScheme;
    }

    private function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    private function compareArrays($array1, $array2)
    {
        sort($array1);
        sort($array2);
        return $array1 == $array2;
    }

    public function releaseResults()
    {
        $candidates = Candidates::all();

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
        $Validate = $request->validate([
            'QuestionTitle' => 'required',
            'QuestionText' => 'required',
            'Type' => 'required',
            'QuestionImage' => 'image',
            'Choices' => 'nullable|array',
            'CorrectAnswer' => 'required'
        ]);

        $question = Questions::create([
            'title' => $Validate['QuestionTitle'],
            'text' => $Validate['QuestionText'],
            'type' => $Validate['Type'],
        ]);

        if ($request->hasFile('QuestionImage')) {
            $path = $request->file('QuestionImage')->storeAs('images', "Question_" . $question->QuestionID . '.' . $request->file('QuestionImage')->extension(), 'public');
            $question->ImagePath = "storage/" . $path;
            $question->save();
        }

        if (!empty($Validate['Choices'])) {
            foreach (array_filter($Validate['Choices']) as $choice) {
                Choices::create([
                    'QuestionID' => $question->QuestionID,
                    'ChoiceText' => $choice
                ]);
            }
        }

        if (is_array($Validate['CorrectAnswer'])) {
            $Validate['CorrectAnswer'] = json_encode($Validate['CorrectAnswer']);
        }

        CorrectAnswers::create([
            'QuestionID' => $question->QuestionID,
            'AnswerText' => $Validate['CorrectAnswer']
        ]);

        return redirect()->back()->with('success', 'Question created successfully!');
    }

    public function viewQuestions()
    {
        $questions = \DB::table('questions')->get();
        return view('ViewQuestions', compact('questions'));
    }

    public function deleteQuestion($id)
    {
        \DB::table('questions')->where('QuestionID', $id)->delete();
        return redirect()->route('ViewQuestions')->with('success', 'Question deleted successfully!');
    }

    public function manageResults()
    {
        $candidates = Candidates::all();
        return view('ManageResults', compact('candidates'));
    }

    public function viewCandidateAnswers($id)
    {
        $candidate = Candidates::findOrFail($id);
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
