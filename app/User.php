<?php

namespace Linet;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Linet\Traits\Friendable;
use Linet\Traits\Messageable;
use Linet\Traits\LinetApps;
use Linet\Traits\LinetNotify;

class User extends Authenticatable
{
    use Notifiable;
    use Friendable;
    use Messageable;
    use LinetApps;
    use LinetNotify;

    protected $fillable = [
        'name', 'username' ,'phone', 'email', 'template', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    

    
}
