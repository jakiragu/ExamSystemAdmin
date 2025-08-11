<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['user_id', 'exam_id', 'amount', 'status'];

    public function exam()
    {
        return $this->belongsTo(ExamCatalog::class, 'exam_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}