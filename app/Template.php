<?php

namespace Linet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Template extends Model
{
    
    protected $fillable = [
        'username', 'name' ,'developer',
    ];

    public function getComponentsAttribute()
    {
    	return array('launcher','notifications','taskbar');
    }

}
