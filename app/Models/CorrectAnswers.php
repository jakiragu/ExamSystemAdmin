<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorrectAnswers extends Model
{
   protected $guarded = [];

   public function question()
   {
       return $this->belongsTo(ExamQuestion::class, 'question_id');
   }
}
