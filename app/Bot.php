<?php

namespace Linet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Bot extends Model
{
    public static function getFileLocation($name)
    {

    	/*
		os+win10.js
		os+win10.css
		os+win10-launcher.css
		os+win10-launcher.html
		ujumbe.js
		ujumbe.css
		ujumbe.html
		*/



    	$extension = explode(".", $name);
    	$extension = $extension[1];

        //dd(strpos($name, "+"));

    	if(strpos($name, "+"))
    	{
    		//getting a template file

    		$newName = explode("+", $name);

    		if(!strpos($newName[1], "-"))
    		{
    			//getting a template's main file

    			$fileName = explode(".", $newName[1]);
    			if($extension == "html")
    				return "public/$fileName[0]/$fileName[0]".".html";
    			if($extension == "js")
    				return "public/$fileName[0]/js/$fileName[0]".".js";
    			if($extension == "css")
    				return "public/$fileName[0]/css/$fileName[0]".".css";
    		}
    		else
    		{
    			//getting a template's component file
    			$fileName = explode(".", $newName[1]);
    			$folderName = explode("-", $fileName[0]);

                //dd($fileName);


    			if($extension == "html")
    				return "public/$folderName[0]/$fileName[0]".".html";
    			if($extension == "css")
    				return "public/$folderName[0]/css/$fileName[0]".".css";
    		}
    		return false;
    	}
    	else
    	{
    		//getting an application file
    		$fileName = explode(".", $name);
    		return "public/apps/$fileName[0]/$name";
    	}
    }

    public static function getFileContents($name)
    {
    	$location = Bot::getFileLocation($name);
    	return Storage::disk('local')->get($location);
    }

    public static function putFileContents($name,$contents)
    {
        $location = Bot::getFileLocation($name);
        return Bot::saveToFile($location,$contents);
        //return Storage::disk('local')->put($location, $contents);
    }

    public static function saveToFile($name,$contents){
        return Storage::disk('local')->put($name, $contents);
    }

    public static function makeDirectory($path)
    {
        Storage::makeDirectory($path);
    }


}
