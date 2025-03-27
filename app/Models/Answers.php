<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
   protected $guarded = [];
   
   public function Candidates()
   {
      return $this->belongsTo(Candidates::class, 'CertificationID', 'CertificationID');
   }
   public function Questions(){
      return $this->belongsTo(Questions::class, 'QuestionID', 'QuestionID');
   }
}
