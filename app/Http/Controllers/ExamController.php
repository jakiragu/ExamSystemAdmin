<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidates;
use App\Models\Questions;
use App\Models\Answers;
use App\Models\Choices;
use App\Models\ExamCatalog;

class ExamController extends Controller
{
    // -------------------- STUDENT MANAGEMENT --------------------

    public function showAllStudents()
    {
        $candidates = Candidates::all();
        return view('studentInfo', compact('candidates'));
    }

    public function showSubmittedStudents()
    {
        $candidates = Candidates::has('answers')->withCount('answers')->get();
        return view('ViewSubmissions', compact('candidates'));
    }

    public function deleteStudent($id)
    {
        $student = Candidates::where('CertificationID', $id)->firstOrFail();
        $student->delete();

        return back()->with('success', 'Student deleted successfully!');
    }

    public function registerStudent(Request $request)
    {
        $validated = $request->validate([
            'FullName' => 'required',
            'Email' => 'required|email',
            'CertificationID' => 'required',
            'Organization' => 'required',
            'Occupation' => 'required',
            'MobileNo' => 'required'
        ]);

        Candidates::create($validated);
    }

    // -------------------- STUDENT EXAM FLOW --------------------

    public function showExamQuestions($id = null)
    {
        $question = $id 
            ? Questions::where('QuestionID', $id)->first() 
            : Questions::orderBy('QuestionID')->first();

        $choices = Choices::where('QuestionID', $question->QuestionID)->get() ?? [];
        $answer = session($question->QuestionID, "");

        return view('Questions', compact('question', 'choices', 'answer'));
    }

    public function submitStudentExam(Request $request)
    {
        $answers = json_decode($request->answers);
        $certificationID = session('candidate');

        foreach ($answers as $questionID => $answer) {
            Answers::create([
                'CertificationID' => $certificationID,
                'QuestionID' => $questionID,
                'text' => strtolower($answer)
            ]);
        }

        session()->flush();
        return redirect()->route('register.create');
    }

    public function viewStudentAnswers($certificationID)
    {
        $answers = Answers::where('CertificationID', $certificationID)->get();

        $questions = $answers->mapWithKeys(function ($answer) {
            return [$answer->QuestionID => Questions::where('QuestionID', $answer->QuestionID)->first()];
        });

        $student = Candidates::where('CertificationID', $certificationID)->first();

        return view('ViewAnswers', compact('answers', 'questions', 'student'));
    }

    public function examOverview()
    {
        $questions = Questions::select('QuestionID', 'title')->get();
        return view('ExamOverview', compact('questions'));
    }

    // -------------------- ADMIN CONTROLS --------------------

    public function updateExamStatus($id, $status)
    {
        $exam = ExamCatalog::findOrFail($id);

        switch ($status) {
            case 'start':
                $exam->update([
                    'status' => 'active',
                    'start_time' => now(),
                    'is_visible_to_students' => true
                ]);
                break;

            case 'pause':
                $exam->update([
                    'status' => 'paused',
                    'is_visible_to_students' => false
                ]);
                break;

            case 'stop':
                $exam->update([
                    'status' => 'stopped',
                    'end_time' => now(),
                    'is_visible_to_students' => false
                ]);
                break;

            case 'reset':
                $exam->update([
                    'status' => 'draft',
                    'start_time' => null,
                    'end_time' => null,
                    'is_visible_to_students' => false
                ]);
                break;
        }

        return redirect()->route('adminDashboard')
                         ->with('success', "Exam $status-ed successfully.");
    }
}