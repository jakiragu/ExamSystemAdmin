<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $guarded = [];

    protected $primaryKey = 'QuestionID';
    public $incrementing = true;
    protected $keyType = 'int';

    public function Answers()
    {
        return $this->hasOne(Answers::class, 'QuestionID', 'QuestionID');
    }
}
