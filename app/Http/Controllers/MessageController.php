<?php

namespace Linet\Http\Controllers;
use Linet\Message;
use Linet\User;
use Illuminate\Http\Request;
use Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //returns all the users messages

        return Auth::user()->messages();
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //saves a message

        $message = Message::create([
            'sender' => Auth::user()->id,
            'target' => User::where('username',$request->username)->first()->id,
            'contents' => $request->contents,
        ]);

        if($message)
            return "LINET000";
        else
            return "LINET001";
    }

    
    public function show($id)
    {
        //returns a single message, if its within logged in user's jurisdiction

        $message = Message::findOrFail($id);
        if(Auth::user()->canSeeMessageContents($message->id))
            return $message;
        return "LINET001";
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //updates the status of a message
        if(Auth::user()->canSeeMessageContents($id))
        {
            $message = Message::findOrFail($id);
            $message->status = $request->status;
            $message->save();
            return "LINET000";
        }
        return "LINET001";
    }

    
    public function destroy($id)
    {
        //
    }

    public function chats($username){
        $user = User::where('username',$username)->first();
        return Auth::user()->chatsMessages($user);
    }
}
