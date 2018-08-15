<?php

namespace Linet;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'category', 'contents' ,'sender', 'user', 'status'
    ];
}
