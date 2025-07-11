<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    protected $guarded = [];

    protected $primaryKey = 'AnswerID'; // ✅ Tell Laravel your PK
    public $incrementing = true;        // ✅ Auto-incrementing integer PK
    protected $keyType = 'int';         // ✅ PK is integer

    public function Candidates()
    {
        return $this->belongsTo(Candidates::class, 'CertificationID', 'CertificationID');
    }

    public function Questions()
    {
        return $this->belongsTo(Questions::class, 'QuestionID', 'QuestionID');
    }
}
