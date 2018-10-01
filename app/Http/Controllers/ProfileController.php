<?php

namespace Linet\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Image;

class ProfileController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request){
    	return view('lughayetu.profile',['user' => Auth::user()]);
    }

    public function update_avatar(Request $request){
        // Logic for user upload of avatar
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(140, 140)->save( public_path('/uploads/avatars/' . $filename ) );
            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
        }
        return view('lughayetu.profile', ['user' => Auth::user()] );
    }
}
