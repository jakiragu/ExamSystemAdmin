<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\EvaluatorScript;
use App\Models\Questions;
use App\Models\CorrectAnswers;
use App\Models\Choices;
use App\Models\Answers;
use App\Models\ExamObjective;
use App\Models\LabEnvironment;

class ExamQuestion extends Model
{
    use HasFactory;

    protected $table = 'exam_questions';

    protected $fillable = [
        'question_id',
        'exam_objective_id',
        'question_text',
        'difficulty_level',
        'expected_action',
        'sample_input',
        'expected_output',
        'lab_env_id',
        'question_type',
        'evaluation_type',
    ];

    /**
     * The original base question this exam question was cloned from.
     */
    public function baseQuestion(): BelongsTo
    {
        return $this->belongsTo(Questions::class, 'question_id');
    }

    /**
     * The exam objective this question is linked to.
     */
    public function examObjective(): BelongsTo
    {
        return $this->belongsTo(ExamObjective::class, 'exam_objective_id');
    }

    /**
     * The lab environment setup required for this question.
     */
    public function labEnvironment(): BelongsTo
    {
        return $this->belongsTo(LabEnvironment::class, 'lab_env_id');
    }

    /**
     * Evaluator scripts linked to this question.
     */
    public function scripts(): HasMany
    {
        return $this->hasMany(EvaluatorScript::class, 'question_id');
    }

    /**
     * Correct answers associated with this question.
     */
    public function correctAnswers(): HasMany
    {
        return $this->hasMany(CorrectAnswers::class, 'question_id');
    }

    /**
     * Choices for multiple-choice questions.
     */
    public function choices(): HasMany
    {
        return $this->hasMany(Choices::class, 'question_id');
    }

    /**
     * All submitted answers for this question.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answers::class, 'question_id');
    }

    /**
     * Optional evaluator script (if only one is assigned).
     */
    public function evaluatorScript(): HasOne
    {
        return $this->hasOne(EvaluatorScript::class, 'question_id');
    }
}