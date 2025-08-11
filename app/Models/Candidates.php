<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Candidates extends Authenticatable
{
    use HasApiTokens;
    // Use 'id' as primary key for consistency
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
        'ResultsReleased',
    ];

    public function Answers()
    {
        return $this->hasMany(Answers::class, 'candidate_id');
    }
}
