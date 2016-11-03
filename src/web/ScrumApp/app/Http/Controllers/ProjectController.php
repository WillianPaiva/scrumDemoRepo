<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Config;
use App\Project;
use App\User;

class ProjectController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProject()
    {
        $projects = Auth::user()->owns()->get();
        return view('/project/list',compact('projects'));
    }

    public function createProject(Request $request)
    {
        Project::create([
            'name' => Input::get("name"),
            'user_id' => Auth::user()->id,
            'description' => Input::get("description"),
            'language' => Input::get("language"),
            'version' => Input::get("version"),
        ]);
        return ProjectController::getProject();
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAddProjectForm()
    {
        return view('/project/add');
    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showProject($id)
    {
        $project = Project::find($id);
        return view('/project/project',['project' => $project]);
    }


    public function showModifyProject($id)
    {
        $project = Project::find($id);
        return view('/project/modify',['project' => $project]);
    }

    public function modifyProject(Request $request)
    {
        $project = Project::find(Input::get("id"));
        $project->name = Input::get("name");
        $project->description = Input::get("description");
        $project->language = Input::get("language");
        $project->version = Input::get("version");
        $project->save();
        
        return ProjectController::getProject();
    }

}