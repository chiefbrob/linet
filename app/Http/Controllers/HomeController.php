<?php

namespace Linet\Http\Controllers;

use Illuminate\Http\Request;
use Linet\Bot;
use Linet\Application;
use Auth;

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
        $app = Application::find(3);
        dd(Auth::user()->uninstallApp($app));
        return view('test');
    }

    public function testing(Request $request)
    {
        Bot::putFileContents($request->username,$request->contents);
        return Bot::getFileContents($request->username);
    }
}
