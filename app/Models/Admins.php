<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admins extends Authenticatable
{
    protected $primaryKey = 'AdminName';
    public $incrementing = false; 
    protected $keyType = 'string';
    
    protected $guarded=[];
}
