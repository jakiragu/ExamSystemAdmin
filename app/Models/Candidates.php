<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Candidates extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'CertificationID',
        'FullName',
        'Email',
        'Organization',
        'Occupation',
        'MobileNo',
        'password',
        'ResultsReleased',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function answers()
    {
        return $this->hasMany(Answers::class, 'candidate_id');
    }

    public function bookings()
    {
        return $this->hasMany(CandidateExamBooking::class);
    }
}
