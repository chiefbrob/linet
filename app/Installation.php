<?php

namespace Linet;

use Illuminate\Database\Eloquent\Model;

class Installation extends Model
{
    protected $fillable = [
        'application', 'user' ,'status',
    ];

}
