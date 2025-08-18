<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateExamBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'exam_catalog_id',
        'scheduled_at',
        'status',
        'payment_status',
        'reschedule_count',
    ];

    // Relationships
    public function candidate()
    {
        return $this->belongsTo(Candidates::class);
    }

    public function examCatalog()
    {
        return $this->belongsTo(ExamCatalog::class);
    }
}