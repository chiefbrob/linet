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
    				return "linet/$fileName[0]/$fileName[0]".".html";
    			if($extension == "js")
    				return "linet/$fileName[0]/js/$fileName[0]".".js";
    			if($extension == "css")
    				return "linet/$fileName[0]/css/$fileName[0]".".css";
    		}
    		else
    		{
    			//getting a template's component file
    			$fileName = explode(".", $newName[1]);
    			$folderName = explode("-", $fileName[0]);

                //dd($fileName);


    			if($extension == "html")
    				return "linet/$folderName[0]/$fileName[0]".".html";
    			if($extension == "css")
    				return "linet/$folderName[0]/css/$fileName[0]".".css";
    		}
    		return false;
    	}
    	else
    	{
    		//getting an application file
    		$fileName = explode(".", $name);
    		return "apps/mtengenezi/files/$fileName[0]/$name";
    	}
    }

    public static function getFileContents($name)
    {
    	$location = Bot::getFileLocation($name);
    	return Storage::disk('local')->get($location);
    }

}
