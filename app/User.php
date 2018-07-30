<?php

namespace Linet;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    protected $fillable = [
        'name', 'username' ,'phone', 'email', 'template', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    
    public function install($app){
    	return false;
    }

    public function uninstall($app){
    	return false;
    }

    public function installStatus($app){
    	return false;
    }
}
