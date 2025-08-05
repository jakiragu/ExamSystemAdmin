<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamCatalog extends Model
{
    use HasFactory;

    // Specify the primary key column name
    protected $primaryKey = 'id';

    // If exam_id is auto-incrementing and integer, leave these as-is
    public $incrementing = true;
    protected $keyType = 'int';

    // Fillable fields
    protected $fillable = [
        'exam_code',
        'exam_title',
        'duration_minutes',
        'status',
        'start_time',
        'end_time',
        'is_visible_to_students',
        'lab_env_id', 
    ];

    public function subjectAreas()
{
    return $this->hasMany(SubjectArea::class, 'exam_catalog_id','id' );
}

public function labEnvironment()
{
    return $this->belongsTo(LabEnvironment::class, 'lab_env_id', 'id');
}
public function objectives()
{
    return $this->hasMany(ExamObjective::class, 'exam_id');
}


}
