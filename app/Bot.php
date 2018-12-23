<?php

namespace Linet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Bot extends Model
{
    public static function getFileLocation($name)
    {

    	/*
		os+win10.js //template script
		os+win10.css //template style
		os+win10-launcher.css //template component style
		os+win10-launcher.html //template component html
		ujumbe.js //application script
		ujumbe.css //application style
		ujumbe.html //application html
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
    				return "$fileName[0]/$fileName[0]".".html";
    			if($extension == "js")
    				return "$fileName[0]/js/$fileName[0]".".js";
    			if($extension == "css")
    				return "$fileName[0]/css/$fileName[0]".".css";
    		}
    		else
    		{
    			//getting a template's component file
    			$fileName = explode(".", $newName[1]);
    			$folderName = explode("-", $fileName[0]);

                //dd($fileName);


    			if($extension == "html")
    				return "$folderName[0]/$fileName[0]".".html";
    			if($extension == "css")
    				return "$folderName[0]/css/$fileName[0]".".css";
    		}
    		return false;
    	}
    	else
    	{
    		//getting an application file
    		$fileName = explode(".", $name);
    		return "apps/$fileName[0]/$name";
    	}
    }

    public static function getFileContents($name)
    {

    	$location = Bot::getFileLocation($name);
        return file_get_contents($location);
    }

    public static function putFileContents($name,$contents)
    {
        $location = Bot::getFileLocation($name);
        return Bot::saveToFile($location,$contents);
        //return Storage::disk('local')->put($location, $contents);
    }

    public static function saveToFile($path,$contents){
        return file_put_contents($location, $contents);
        return Storage::disk('local')->put($path, $contents);
    }

    public static function makeDirectory($path)
    {
        return mkdir($path);
        Storage::makeDirectory($path);
    }


}
