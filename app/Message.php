<?php

namespace Linet;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender', 'receiver' ,'contents', 'status'
    ];
}
