<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamObjective extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'objective_title',
        'description',
        'subject_area_id',
        'exam_catalog_id',
    ];

    public function subjectArea()
    {
        return $this->belongsTo(SubjectArea::class);
    }

    public function examCatalog()
    {
        return $this->belongsTo(ExamCatalog::class, 'exam_catalog_id', 'id');
    }
}
