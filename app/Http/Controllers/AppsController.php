<?php

namespace Linet\Http\Controllers;

use Illuminate\Http\Request;
use Linet\Application;

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
        $application->owner = Auth::user()->id;
        $application->save();
    }

    public function show($username)
    {
        return Application::where('username',$username);
    }

    public function edit($id)
    {
        
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
                # code...
                break;
        }

        
    }

    public function update(Request $request, $username)
    {
        $application = Application::where('username',$username);
        $application->name = $request->name;
        $application->username = $request->username;
        $application->owner = $request->owner;
        $application->save();
    }

    public function destroy($id)
    {
        //
    }
}
