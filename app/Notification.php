<?php

namespace Linet;

use Illuminate\Database\Eloquent\Model;
use Linet\Application;

class Notification extends Model
{
    protected $fillable = [
        'category', 'contents' ,'sender', 'user', 'status'
    ];

    public function getOriginAttribute(){
    	return Application::find($this->sender)->username;
    }
}
