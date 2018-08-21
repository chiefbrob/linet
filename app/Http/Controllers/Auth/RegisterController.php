<?php

namespace Linet\Http\Controllers\Auth;

use Linet\User;
use Linet\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Linet\Installation;

class RegisterController extends Controller
{

    use RegistersUsers;

    
    protected $redirectTo = '/home';

    
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:50',
            'username' => 'required|string|max:20|unique:users',
            'phone' => 'required|string|max:10|unique:users',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    protected function create(array $data)
    {
        
        $user =  User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $i = new Installation();
        $i->application = 4;
        $i->user = $user->id;
        $i->save();
        //check if user was created
        return $user;
    }
}
