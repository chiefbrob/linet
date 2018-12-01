<?php

namespace Linet\Traits;
use Linet\User;
use Linet\Notification;

trait LinetNotify 
{
	
	public function getNotificationsAttribute(){
        return Notification::where('user',$this->id)->where('status','received')->get();
    }

}






