<?php

namespace Linet;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Linet\Notification;
use Linet\Application;
use Linet\Installation;
use Linet\Traits\Friendable;
use Linet\Traits\Messageable;

class User extends Authenticatable
{
    use Notifiable;
    use Friendable;
    use Messageable;

    protected $fillable = [
        'name', 'username' ,'phone', 'email', 'template', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function installApp($app){
        //dd($this->installStatus($app));
        $status = $this->installStatus($app);

        if($status == 'uninstalled')
        {
            $i = new Installation;
            $i->application = $app->id;
            $i->user = $this->id;
            $i->save();
            return true;
        }
        else if($status == 'removed')
        {
            $installation = Installation::where('application',$app->id)->where('user',$this->id)->first();
            $installation->status = 'installed';
            $installation->save();
            return true;
        } 	

        return false;
    }

    public function uninstallApp($app){

        if($this->installStatus($app) == 'installed')
        {
            $installation = Installation::where('application',$app->id)->where('user',$this->id)->first();
            $installation->status = 'removed';
            $installation->save();
            return true;
        }
    	return false;
    }

    public function installStatus($app){

        $installation = Installation::where('application',$app->id)->where('user',$this->id)->first();
        if($installation)
        {
            return $installation->status;
        }
        return 'uninstalled';
    }

    public function getAppsAttribute(){
        $apps = Installation::where('user',$this->id)->where('status','installed')->get();
        $retVal = array();
        //$retVal[0] = Application::findOrFail(4);

        foreach($apps as $app)
        {
            $retVal[count($retVal)] = Application::findOrFail($app->application);
        }
        return $retVal;
    }

    public function getNotificationsAttribute(){
        return Notification::where('user',$this->id)->where('status','received')->get();
    }
}
