<?php

namespace Linet\Traits;
use Illuminate\Support\Facades\DB;
use Linet\Friendship;
use Linet\User;
use Linet\Message;

trait Messageable 
{
	public function messages(){

		$messages = DB::select("SELECT * FROM messages WHERE sender = ".$this->id." OR target = ".$this->id." ORDER BY created_at desc");

		$retVal = array();

		foreach($messages as $message)
		{
			array_push($retVal, Message::find($message->id));
		}

		return $retVal;
	}

	public function sentMessages(){
		$messages = DB::select("SELECT * FROM messages WHERE sender = ".$this->id." ORDER BY created_at desc");

		$retVal = array();

		foreach($messages as $message)
		{
			array_push($retVal, Message::find($message->id));
		}

		return $retVal;
	}

	public function receivedMessages(){
		$messages = DB::select("SELECT * FROM messages WHERE target = ".$this->id." ORDER BY created_at desc");

		$retVal = array();

		foreach($messages as $message)
		{
			array_push($retVal, Message::find($message->id));
		}

		return $retVal;
	}

	public function chatsMessages($user){
		$sql = "SELECT * FROM messages WHERE sender = ".$user->id." and target = ".$this->id." or sender = ".$this->id." and target = ".$user->id." ORDER BY created_at desc";
		
		$messages = DB::select($sql);

		$retVal = array();

		foreach($messages as $message)
		{
			array_push($retVal, Message::find($message->id));
		}

		return $retVal;
	}

	public function canSeeMessageContents($messageId){
		$message = Message::findOrFail($id);
        $user = Auth::user();
        if($message->sender == $user->id || $message->target == $user->id)
        	return true;
        else
        	return false;
	}

	public function conversations(){
		$results = DB::select("SELECT sender, target FROM messages WHERE sender = ".$this->id." OR target = ".$this->id." ORDER BY created_at DESC");

		$users = array();

		foreach ($results as $result) {
			$k = false;
			$focus = ($result->sender == $this->id ? $result->target : $result->sender);
			foreach($users as $user)
			{
				if($user->id == $focus)
					$k = true;
			}

			if(!$k)
				array_push($users, User::findOrFail($focus));
		}

		return $users;
	}


}






