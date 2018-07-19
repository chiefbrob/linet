<?php

namespace Linet;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    protected $fillable = [
        'name', 'username' ,'phone', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
