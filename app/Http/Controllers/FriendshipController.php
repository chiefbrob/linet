<?php

namespace Linet\Http\Controllers;

use Illuminate\Http\Request;
use Linet\User;
use Auth;
use Linet\Friendship;

class FriendshipController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Auth::user()->friends();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $requested = User::where('username',$request->username)->first();

        $f = new Friendship;
        $f->requester = $user->id;
        $f->requested = $requested->id;
        $f->save();

        return $f;
    }

    public function show($id)
    {
        return Friendship::FindOrFail($id);
    }

    public function edit($id)
    {
        return Friendship::FindOrFail($id);
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        //
    }
}
