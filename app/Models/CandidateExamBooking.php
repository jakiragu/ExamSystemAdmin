<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Candidate;



class CandidateExamBooking extends Model
{
    use HasFactory;

    protected $table = 'candidate_exam_bookings';

    protected $fillable = [
        'candidate_id',
        'exam_catalog_id',
        'scheduled_at',
        'status',
        'payment_status',
        'reschedule_count',
    ];

    // Automatically eager load relationships for API responses
    protected $with = ['candidate', 'examCatalog'];

    // Relationships
    public function candidate()
    {
        // Use User if that's your canonical candidate model
        return $this->belongsTo(Candidate::class, 'candidate_id', 'id');
    }

    public function examCatalog()
    {
        return $this->belongsTo(ExamCatalog::class, 'exam_catalog_id');
    }

    // Optional alias for frontend clarity
    public function exam()
    {
        return $this->examCatalog();
    }
}