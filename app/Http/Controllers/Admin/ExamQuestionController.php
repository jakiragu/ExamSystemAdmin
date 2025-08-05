<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamQuestion;
use App\Models\ExamObjective;
use App\Models\LabEnvironment;

class ExamQuestionController extends Controller
{
    // Display all questions
    public function index()
    {
        $questions = ExamQuestion::with('objective', 'labEnv')->get();
        return view('admin.exam_questions.index', compact('questions'));
    }

    // Show the form to create a new question
    public function create()
    {
        $objectives = ExamObjective::all();
        $labEnvs = LabEnvironment::all();
        return view('admin.exam_questions.create', compact('objectives', 'labEnvs'));
    }

    // Store the submitted question
   public function store(Request $request)
{
    $request->validate([
        'question_text' => 'required|string',
        'question_type' => 'required|string',
        'difficulty_level' => 'required|string',
        'exam_objective_id' => 'required|exists:exam_objectives,id',
        'lab_env_id' => 'nullable|exists:lab_environments,id',
        'evaluation_type' => 'nullable|string',
    ]);

    $question = ExamQuestion::create([
        'question_text' => $request->question_text,
        'question_type' => $request->question_type,
        'difficulty_level' => $request->difficulty_level,
        'exam_objective_id' => $request->exam_objective_id,
        'lab_env_id' => $request->lab_env_id,
        'evaluation_type' => $request->evaluation_type,
        'expected_action' => $request->expected_action,
        'sample_input' => $request->sample_input,
        'expected_output' => $request->expected_output,
        'cognitive_level' => $request->cognitive_level,
    ]);

    if ($request->has('choices')) {
        foreach ($request->input('choices') as $choiceData) {
            $question->choices()->create([
                'choice_text' => $choiceData['choice_text'],
                'is_correct' => isset($choiceData['is_correct']) ? 1 : 0,
            ]);
        }
    }

    return redirect()->route('admin.exam-questions.index')->with('success', 'Question created successfully!');
}
    

}