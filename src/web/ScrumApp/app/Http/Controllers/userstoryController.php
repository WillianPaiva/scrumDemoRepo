<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class userstoryController extends Controller
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
    public function index($id, $nb){
        return view('project/userstory',['id' => $id, 'nb' => $nb]);
    }
}
