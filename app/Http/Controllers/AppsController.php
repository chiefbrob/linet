<?php

namespace Linet\Http\Controllers;

use Illuminate\Http\Request;
use Linet\Application;
use Auth;

class AppsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {
        return Application::all();
    }


    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $application = new Application;
        $application->name = $request->name;
        $application->username = $request->username;
        $application->icon = 'app';
        $application->owner = Auth::user()->id;
        $application->description = $request->description;
        $application->save();

        Application::mtengeneziRegister($application->username);
        
        return $application;
    }

    public function show($username)
    {
        return Application::where('username',$username)->get();
    }

    public function edit($username)
    {
        return Application::where('username',$username)->get();
    }

    public function tasks(Request $request, $username)
    {
        $application = Application::where('username',$username);
        $user = Auth::user();

        if(!isset($request->task))
            return "LINET006";
        $task = $request->task;

        switch ($request->task) {
            case 'install':
                return $user->install($application);
                break;
            case 'uninstall':
                return $user->uninstall($application);
                break;
            case 'installStatus':
                return $user->installStatus($application);
                break;
            
            default:
                return "LINET006";
                break;
        }

        
    }

    public function update(Request $request, $username)
    {
        $application = Application::where('username',$username)->first();
        $application->name = $request->name;
        $application->username = $request->username;
        $application->save();
        return $application;
    }

    public function destroy($id)
    {
        //
    }
}
