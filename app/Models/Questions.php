<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $table = 'exam_questions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'text',
        'type',
        'ImagePath',
        'expected_action',
        'sample_input',
        'expected_output',
        'exam_objective_id',
        'lab_env_id',
        'evaluation_type',
        'difficulty_level',
        'cognitive_level'
    ];

    public function examVersions()
    {
        return $this->hasMany(ExamQuestion::class, 'question_id');
    }

    public function objective()
    {
        return $this->belongsTo(ExamObjective::class, 'exam_objective_id');
    }

    public function labEnv()
    {
        return $this->belongsTo(LabEnvironment::class, 'lab_env_id', 'id');
    }
}