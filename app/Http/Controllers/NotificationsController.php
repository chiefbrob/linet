<?php

namespace Linet\Http\Controllers;

use Illuminate\Http\Request;
use Linet\Notification;
use Linet\user;
use Auth;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return Notification::where('user',Auth::user()->id)->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //'category', 'contents' ,'sender', 'user', 'status'
        $n = new Notification;
        $n->category = $request->category;
        $n->contents = $request->contents;
        $n->sender = $request->sender;
        $n->user = Auth::user()->id;
        $n->save();

        return $n;
    }

    public function show($id)
    {
        return Notification::findOrFail($id);
    }

    public function edit($id)
    {
        return Notification::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $n = Notification::findOrFail($id);

        $n->category = $request->category;
        $n->contents = $request->contents;
        $n->sender = $request->sender;
        $n->user = Auth::user()->id;
        $n->save();

        return $n;
    }

    public function destroy($id)
    {
        //
    }
}
