<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeControler extends Controller
{
    public function index()
    {
        return view('welcome');
    }
        //
}
