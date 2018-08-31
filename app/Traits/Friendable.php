<?php

namespace Linet\Traits;

use Linet\Friendship;
use Linet\User;

trait Friendable 
{
	public function addFriend($friend){

		if($this->hasSentFriendRequestTo($friend))
			return false;
		if($this->id == $friend->id)
			return false;

		$friendship = Friendship::create([
			'requester' => $this->id,
			'requested' => $friend->id,
		]);

		if($friendship)
			return true;
		return false;
	}

	public function acceptFriend($friend){
		
		$friendship = Friendship::where('status','sent')
								->where('requester',$friend->id)
								->where('requested',$this->id)
								->first();

		if($friendship)
		{
			$friendship->update(['status' => 'friends']);
			return true;
		}
		return false;
	}

	public function rejectFriend($friend){
		
		$friendship = Friendship::where('status','sent')
								->where('requester',$friend->id)
								->where('requested',$this->id)
								->first();
		if($friendship)
		{
			$friendship->update(['status' => 'rejected']);
			return true;
		}
		return false;
	}

	public function friends(){
		$friends = array();

		$f1 = Friendship::where('status','friends')
							->where('requester', $this->id)
							->get();

		foreach ($f1 as $friendship) {
			$friend = User::find($friendship->requested);
			array_push($friends, $friend);
		}

		$f2 = Friendship::where('status','friends')
							->where('requested', $this->id)
							->get();

		foreach ($f2 as $friendship) {
			$friend = User::find($friendship->requester);
			array_push($friends, $friend);
		}

		return $friends;
	}

	public function others(){
		$others = array();
		$users = User::all();
		foreach($users as $user)
		{
			if($user == $this)
				continue;
			array_push($others, $user);
		}
		return $others;
	}

	public function hasFriends(){
		if(count($this->friends())>0)
			return true;
		return false;
	}

	public function isFriendsWith($friend){

		$f0 = Friendship::where('status','friends')
								->where('requester',$friend->id)
								->where('requested',$this->id)
								->first();
		if($f0[0])
			return true;

		$f1 = Friendship::where('status','friends')
								->where('requested',$friend->id)
								->where('requester',$this->id)
								->first();
		if(!$f1[0])
			return false;
	}

	public function hasSentFriendRequestTo($friend){
		$friendship = Friendship::where('status','sent')
								->where('requester',$this->id)
								->where('requested',$friend->id)
								->first();
		if($friendship)
			return true;
		return false;
	}

	public function hasSentFriendRequestFrom($friend)
	{
		$friendship = Friendship::where('status','sent')
								->where('requester',$friend->id)
								->where('requested',$this->id)
								->first();
		if($friendship)
			return true;
		return false;
	}

	public function sentFriendRequests(){

		$friends = array();

		$friendships = Friendship::where('status','sent')
							->where('requester', $this->id)
							->get();

		foreach($friendships as $friendship)
		{
			$friend = User::find($friendship->requested);
			array_push($friends, $friend);
		}

		return $friends;
	}

	public function pendingFriendRequests(){
		$friends = array();

		$friendships = Friendship::where('status','sent')
							->where('requested', $this->id)
							->get();

		foreach($friendships as $friendship)
		{
			$friend = User::find($friendship->requester);
			array_push($friends, $friend);
		}

		return $friends;
	}

	public function insight(){

        $friends = $this->friends();
        $pending = $this->pendingFriendRequests();
        $sent = $this->sentFriendRequests();
        return array(
        	'me' => $this,
        	'friends' => $friends,
        	'pending' => $pending,
        	'sent' => $sent);
    }
}






