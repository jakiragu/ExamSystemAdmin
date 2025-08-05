<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentExamAttempt extends Model
{
    protected $fillable = [
        'candidate_id',
        'exam_id',
        'started_at',
        'completed_at',
        'status',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidates::class, 'candidate_id');
    }

    public function exam()
    {
        return $this->belongsTo(ExamCatalog::class, 'exam_id');
    }
}
