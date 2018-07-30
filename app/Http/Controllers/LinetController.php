<?php

namespace Linet\Http\Controllers;
use Illuminate\Http\Request;
use Auth;

class LinetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home(Request $request)
    {
    	$app = (isset($request->app) ? $request->app : 'none');
        return view('lughayetu.home',['user' => Auth::user()])
        		->with('user',Auth::user())
        		->with('app',$app);
    }
    
}
