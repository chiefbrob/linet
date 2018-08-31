<?php

namespace Linet\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Linet\User;

class FriendsController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function api($api, Request $request)
    {
    	$user = Auth::user();
    	
    	switch($api){

    		case "myFriends":
    			$friend = User::where('username',$request->username)->first();
    			return $friend->friends();
    			break;

    		case "addFriend":
    			$friend = User::where('username',$request->username)->first();
    			if($user->addFriend($friend))
    				return "LINET000";
    			else
    				return "LINET001";
    			break;

    		case "acceptFriend":
    			$friend = User::where('username',$request->username)->first();
    			if($user->acceptFriend($friend))
    				return "LINET000";
    			else
    				return "LINET001";
    			break;

    		case "rejectFriend":
    			$friend = User::where('username',$request->username)->first();
    			if($user->rejectFriend($friend))
    				return "LINET000";
    			else
    				return "LINET001";
    			break;

    		case "others":
    			return $user->others();
    			break;

    		case "hasFriends":
    			$friend = User::where('username',$request->username)->first();
    			if($friend->hasFriends())
    				return "LINET000";
    			else
    				return "LINET001";
    			break;

    		case "isFriendsWith":
    			$friend = User::where('username',$request->username)->first();
    			if($user->isFriendsWith($friend))
    				return "LINET000";
    			else
    				return "LINET001";
    			break;

    		case "hasSentFriendRequestTo":
    			$friend = User::where('username',$request->username)->first();
    			if($user->hasSentFriendRequestTo($friend))
    				return "LINET000";
    			else
    				return "LINET001";
    			break;

    		case "hasSentFriendRequestFrom":
    			$friend = User::where('username',$request->username)->first();
    			if($user->hasSentFriendRequestFrom($friend))
    				return "LINET000";
    			else
    				return "LINET001";
    			break;

    		case "sentFriendRequests":
    			$friend = User::where('username',$request->username)->first();
    			return $friend->sentFriendRequests();
    			break;

    		case "pendingFriendRequests":
    			$friend = User::where('username',$request->username)->first();
    			return $friend->pendingFriendRequests();
    			break;

    		case "insight":
    			$friend = User::where('username',$request->username)->first();
    			return $friend->insight();
    			break;

    		default:
    			return "LINET001";
    			break;
    	}
    }
}
