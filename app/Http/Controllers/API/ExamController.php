<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamCatalog;
use App\Models\Questions;
use App\Models\Answers;
use Illuminate\Support\Facades\Auth;




class ExamController extends Controller
{
    // GET /api/exam/{id}/questions
    public function getQuestions($id)
    {
        $exam = ExamCatalog::findOrFail($id);

        $questions = Questions::where('exam_catalog_id', $exam->id)->get();

        return response()->json($questions);
    }

    // POST /api/exam/{id}/submit
    public function submitAnswers(Request $request, $id)
    {
        $user = Auth::user();
        $exam = ExamCatalog::findOrFail($id);
        $answers = $request->input('answers');

        foreach ($answers as $questionId => $response) {
            Answers::updateOrCreate(
                [
                    'student_id' => $user->id,
                    'exam_catalog_id' => $exam->id,
                    'question_id' => $questionId,
                ],
                [
                    'response' => $response,
                ]
            );
        }

        return response()->json(['message' => 'Answers submitted successfully']);
    }

    // Optional: GET /api/exam/{id}/status
    public function checkStatus($id)
    {
        $user = Auth::user();

        $submitted = Answers::where('student_id', $user->id)
            ->where('exam_catalog_id', $id)
            ->exists();

        return response()->json(['submitted' => $submitted]);
    }
}