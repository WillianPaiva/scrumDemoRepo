<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

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

        $project = Project::find($id);
        session()->put('backlogActiv',$id);
        session()->put('titleProject',$project->name);
        return view('project/backlog',['id' => $id]);
    }
}
