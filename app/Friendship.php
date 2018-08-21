<?php

namespace Linet;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    protected $fillable = [
        'requester','requested', 'status',
    ];
}
