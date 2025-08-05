<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectArea extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'exam_catalog_id'];

    // Relationship to the ExamCatalog
    public function examCatalog()
    {
        return $this->belongsTo(ExamCatalog::class);
    }
}


