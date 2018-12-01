<?php

namespace Linet\Traits;

use Linet\Application;
use Linet\Installation;

trait LinetApps 
{
	
	public function installApp($app){
        
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

        foreach($apps as $app)
        {
            $retVal[count($retVal)] = Application::findOrFail($app->application);
        }
        return $retVal;
    }


}






