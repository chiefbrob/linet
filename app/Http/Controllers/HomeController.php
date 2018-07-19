<?php

namespace Linet\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        return view('home');
    }

    public function terms()
    {
        return view('lughayetu.terms');
    }
}
