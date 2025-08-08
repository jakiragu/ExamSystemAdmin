<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamCatalog;
use App\Models\LabEnvironment;
use App\Models\StudentExamAttempt;


class StudentExamController extends Controller
{
    /**
     * Show general exam instructions and a list of available exams.
     * Used in: Page 1 (Dropdown + instructions)
     */
    public function listAvailableExams()
    {
        $exams = ExamCatalog::select('exam_id', 'exam_code', 'exam_title')->get();

        return response()->json([
            'status' => 'success',
            'instructions' => 'Welcome to the examination portal. Please select your exam from the dropdown and click "Proceed". Read all rules carefully before starting.',
            'available_exams' => $exams
        ]);
    }

    /**
     * Show specific exam details including time and lab environment.
     * Used in: Page 2 (after exam is selected)
     */
    public function getExamDetails($id)
    {
        $exam = ExamCatalog::with('labEnvironment')->find($id);

        if (!$exam) {
            return response()->json([
                'status' => 'error',
                'message' => 'Exam not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'exam' => [
                'exam_title' => $exam->exam_title,
                'exam_code' => $exam->exam_code,
                'duration_minutes' => $exam->duration_minutes,
                'specific_instructions' => $exam->instructions,
                'lab_environment' => $exam->labEnvironment ? [
                    'schema_name' => $exam->labEnvironment->schema_name,
                    'setup_script' => $exam->labEnvironment->setup_script,
                    'teardown_script' => $exam->labEnvironment->teardown_script,
                    'comments' => $exam->labEnvironment->comments,
                ] : null
            ]
        ]);
    }
    

public function getAvailableExams()
{
    $exams = ExamCatalog::with('labEnvironment')
        ->where('is_visible_to_students', true)
        ->where('status', 'active')
        ->get();

    return response()->json([
        'status' => 'success',
        'exams' => $exams
    ]);
}
public function showExam($id)
{
    $exam = ExamCatalog::with('labEnvironment')->find($id);

    if (!$exam || !$exam->is_visible_to_students || $exam->status !== 'active') {
    return response()->json(['error' => 'Exam not found'], 404);
        }

        return response()->json([
            'id' => $exam->exam_id,
            'exam_code' => $exam->exam_code,
            'exam_title' => $exam->exam_title,
            'duration_minutes' => $exam->duration_minutes,
            'description' => $exam->description,
            'lab_environment' => $exam->labEnvironment ? [
                'schema_name' => $exam->labEnvironment->schema_name,
                'setup_script' => $exam->labEnvironment->setup_script,
                'teardown_script' => $exam->labEnvironment->teardown_script,
                'comments' => $exam->labEnvironment->comments,
            ] : null,
        ]);
    }
public function startExam(Request $request, $exam_id)
{
    $student_id = $request->input('student_id');

    $exam = ExamCatalog::with('questions')->find($exam_id);

    if (!$exam) {
        return response()->json([
            'status' => 'error',
            'message' => 'Exam not found'
        ], 404);
    }

    if ($exam->status !== 'active') {
        return response()->json([
            'status' => 'error',
            'message' => 'This exam has not been started by the admin yet.'
        ], 403);
    }

    // Create or resume the student's attempt
    $attempt = StudentExamAttempt::firstOrCreate([
        'candidate_id' => $student_id,
        'exam_id' => $exam_id,
    ], [
        'started_at' => now(),
        'status' => 'in_progress',
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Exam started',
        'attempt_id' => $attempt->id,
        'duration_minutes' => $exam->duration_minutes,
        'questions' => $exam->questions
    ]);
}
public function getNextQuestion($attempt_id)
{
    $attempt = StudentExamAttempt::with('exam.questions')->find($attempt_id);

    if (!$attempt || $attempt->status !== 'in_progress') {
        return response()->json(['status' => 'error', 'message' => 'Invalid or inactive attempt'], 403);
    }

    $answeredQuestionIds = $attempt->answers()->pluck('question_id')->toArray();

    $nextQuestion = $attempt->exam->questions()
        ->whereNotIn('question_id', $answeredQuestionIds)
        ->first();

    if (!$nextQuestion) {
        return response()->json(['status' => 'complete', 'message' => 'All questions answered']);
    }

    return response()->json([
        'status' => 'success',
        'question' => $nextQuestion
    ]);
}
public function submitAnswer(Request $request, $attempt_id)
{
    $request->validate([
        'question_id' => 'required|exists:exam_questions,question_id',
        'answer_text' => 'required|string',
    ]);

    $attempt = StudentExamAttempt::find($attempt_id);

    if (!$attempt || $attempt->status !== 'in_progress') {
        return response()->json(['status' => 'error', 'message' => 'Invalid or inactive attempt'], 403);
    }

    $answer = $attempt->answers()->updateOrCreate(
        ['question_id' => $request->question_id],
        ['answer_text' => $request->answer_text]
    );

    return response()->json([
        'status' => 'success',
        'message' => 'Answer submitted',
        'answer' => $answer
    ]);
}public function finishExam($attempt_id)
{
    $attempt = StudentExamAttempt::find($attempt_id);

    if (!$attempt || $attempt->status !== 'in_progress') {
        return response()->json(['status' => 'error', 'message' => 'Attempt not in progress'], 403);
    }

    $attempt->status = 'completed';
    $attempt->completed_at = now();
    $attempt->save();

    // Optional: auto-evaluation logic will be plugged in here later

    return response()->json([
        'status' => 'success',
        'message' => 'Exam completed successfully.'
    ]);
}


}
