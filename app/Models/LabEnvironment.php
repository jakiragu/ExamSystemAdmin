<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabEnvironment extends Model
{
    use HasFactory;
    protected $table = 'lab_environments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'schema_name',
        'setup_script',
        'teardown_script',
        'comments',
    ];

    
    public function questions()
{
    return $this->hasMany(Questions::class, 'lab_env_id', 'id');
}
}
