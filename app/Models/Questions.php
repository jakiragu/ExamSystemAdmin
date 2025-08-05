<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $primaryKey = 'QuestionID';

    protected $fillable = [
        'title', 'text', 'type', 'ImagePath'
    ];

    public function examVersions()
    {
        return $this->hasMany(ExamQuestion::class, 'question_id');
    }
}
