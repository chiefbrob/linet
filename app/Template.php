<?php

namespace Linet;

use Illuminate\Database\Eloquent\Model;

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
