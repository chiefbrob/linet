<?php

namespace Linet;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{

	protected $fillable = [
        'name', 'username' ,'owner',
    ];

    

}
