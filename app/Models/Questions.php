<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
   protected $guarded=[];
   public function Answers(){
       return $this->hasOne(Answers::class,'QuestionID','QuestionID');
   }
}
