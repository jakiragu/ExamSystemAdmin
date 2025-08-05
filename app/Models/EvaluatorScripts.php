<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ExamQuestion;

class EvaluatorScript extends Model
{
    use HasFactory;

    protected $table = 'evaluator_scripts';

    protected $primaryKey = 'script_id'; // Since you set a custom PK in your migration

    protected $fillable = [
        'question_id',
        'script_body',
        'script_language',
        'expected_output',
    ];

    /**
     * Link to the question this script evaluates.
     */
    public function question()
    {
        return $this->belongsTo(ExamQuestion::class, 'question_id');
    }
}