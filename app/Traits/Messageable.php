<?php

namespace Linet\Traits;

use Linet\Friendship;
use Linet\User;
use Linet\Message;

trait Messageable 
{
	public function messages(){

		$retVal = array();

		$sent = Message::where('sender',$this->id)->get();

		foreach($sent as $message)
		{
			array_push($retVal, $message);
		}

		$received = Message::where('target',$this->id)->get();

		foreach($received as $message)
		{
			array_push($retVal, $message);
		}

		return $retVal;
	}

}






