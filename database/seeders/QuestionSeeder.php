<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExamQuestion;
use App\Models\ExamObjective;
use App\Models\LabEnvironment;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $objectives = ExamObjective::all();
        $labEnvIds = LabEnvironment::pluck('id')->toArray();

        $difficultyLevels = ['Beginner', 'Intermediate', 'Advanced'];
        $evaluationTypes = ['Auto', 'Manual', 'Mixed'];
        $questionTypes = ['MCQ', 'Written'];

        foreach ($objectives as $objective) {
            for ($i = 1; $i <= 10; $i++) {
                ExamQuestion::create([
                    'exam_objective_id' => $objective->id,
                    'question_text' => "Question {$i} for objective {$objective->id}: Describe how to handle user authentication in Laravel.",
                    'difficulty_level' => $difficultyLevels[array_rand($difficultyLevels)],
                    'expected_action' => 'Explain the use of guards, middleware, and session handling.',
                    'sample_input' => 'POST /login with email and password',
                    'expected_output' => '{"status":"authenticated"}',
                    'lab_env_id' => $labEnvIds[array_rand($labEnvIds)] ?? null,
                    'evaluation_type' => $evaluationTypes[array_rand($evaluationTypes)],
                    'question_type' => $questionTypes[array_rand($questionTypes)],
                ]);
            }
        }
    }
}