<?php

namespace Linet\Http\Controllers;

use Illuminate\Http\Request;
use Linet\Bot;

class HomeController extends Controller
{

    public function index()
    {
        return view('home');
    }

    public function terms()
    {
        return view('lughayetu.terms');
    }

    public function test(Request $request)
    {
    	//return Bot::getFileContents('os+win10-launcher.html');
        return view('test');
    }
}
