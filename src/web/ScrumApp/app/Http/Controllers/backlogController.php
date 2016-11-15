<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class backlogController extends Controller
{
    //

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
    }
    public function index($id){
        return view('project/backlog',['id' => $id]);
    }
}
