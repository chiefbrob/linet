<?php

namespace Linet\Http\Controllers;

use Illuminate\Http\Request;
use Linet\Bot;

class HomeController extends Controller
{

    public function terms()
    {
        return view('lughayetu.terms');
    }

    public function getstyle($name){
    	$css = Bot::getFileContents($name);
    	return response($css,200)->header('Content-Type','text/css');
    }

    public function getscript($name)
    {
    	return Bot::getFileContents($name);
    }
}
