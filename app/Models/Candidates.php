<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidates extends Model
{   
    protected $primaryKey = 'CertificationID';
    public $incrementing = false; 
    protected $keyType = 'string';
    protected $guarded=[];
    
    public function Answers(){
        return $this->hasMany(Answers::class,'CertificationID','CertificationID');
    }
}
