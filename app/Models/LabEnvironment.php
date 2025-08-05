<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabEnvironment extends Model
{
    use HasFactory;

    protected $primaryKey = 'lab_env_id';

    protected $fillable = [
        'schema_name',
        'setup_script',
        'teardown_script',
        'comments',
    ];

    public function examQuestions()
    {
        return $this->hasMany(ExamQuestion::class, 'lab_env_id');
    }
}
