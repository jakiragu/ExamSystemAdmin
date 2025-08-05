<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admins extends Authenticatable
{
       use Notifiable;
       
     protected $guard = 'admin';

    protected $table = 'admins';

    protected $fillable = [
        'AdminName',
        'Email',
        'password',
        'is_super',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
