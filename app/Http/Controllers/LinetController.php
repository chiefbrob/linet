<?php

namespace Linet\Http\Controllers;

use Illuminate\Http\Request;

class LinetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('lughayetu.home');
    }
    
}
