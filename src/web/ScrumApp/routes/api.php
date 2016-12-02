<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
*/


// route groupe makes sure that the user is authenticated
Route::group(['middleware' => 'api'], function() {

    ////////////////////////////////////////////////////////////////////
    // project section those routes a routes used by the project view //
    ////////////////////////////////////////////////////////////////////

    //route to return all members of a project selected by id
    Route::get('members/{id}', function($id) {

        $project = App\Project::find($id);
        return Response::json($project->members()->get());
    });


    //route used to add a user to a project takes a user id and a project id
    Route::post('adduser/{userid}/{projectid}', function($userid, $projectid) {
        $project = App\Project::find($projectid);
        $project->members()->attach($userid);
    });

    //route used to remove a user from a project takes the user id and a project id
    Route::post('members/delete/{projectid}/{userid}', function($projectid, $userid) {
        $project = App\Project::find($projectid);
        $project->members()->detach($userid);
    });

    //route used to delet a project takec a project id
    Route::post('project/delete/{projectid}', function($projectid) {
        App\Project::find($projectid)->delete();
    });

    //route used to create a new project takes a request with a map of the
    //project details
    Route::post('project/add', function(Request $request) {
        $project = App\Project::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'description' => $request->description,
            'language' => $request->language,
            'version' => $request->version,
        ]);
        return $project;
    });

    //route that returns a list of projects owned by the user id and it takes an
    //optional parameter search that filters the results 
    Route::get('getownproject/{id}/{search?}', function($id, $search = null) {
        $user = App\User::find($id);
        $result = array();

        if($search == null){
            $queries = $user->owns()->get();
        }else{
            $queries = $user->owns()->where('name', 'LIKE', '%'.$search.'%')->get();
        }

        foreach ($queries as $query)
        {
            $result[] = [ 'id' => $query->id,
                          'name' => $query->name,
                          'description' => $query->description,
                          'language' => $query->language,
                          'user_id' => $query->user_id,
                          'version' => $query->version,
                          'username' => $user->name
            ];
        }
        return Response::json($result);

    });


    //route that returns a list of projects where the user is a membe and it takes an
    //optional parameter search that filters the results 

    Route::get('getmemberproject/{id}/{search?}', function($id, $search = null) {
        $user = App\User::find($id);
        $result = array();
        if($search == null){
            $queries = $user->memberof()->get();
        }else{
            $queries = $user->memberof() ->where('name', 'LIKE', '%'.$search.'%') ->get();
        }

        foreach ($queries as $query)
        {
            $result[] = [ 'id' => $query->id,
                          'name' => $query->name,
                          'description' => $query->description,
                          'language' => $query->language,
                          'user_id' => $query->user_id,
                          'version' => $query->version,
                          'username' => $user->name
            ];
        }
        return Response::json($result);

    });



    //save modifications done to a project 
    Route::post('project/edit', function(Request $request) {
        $project = App\Project::find($request->id);
        $project->name = $request->name;
        $project->description = $request->description;
        $project->language = $request->language;
        $project->version = $request->version;
        $project->save();

    });


    // gets a project by id 
    Route::get('project/{id}', function($id) {
        return Response::json(App\Project::find($id));
    });

    /////////////////////////////////////////////////////////////
    // sprint section those routes are used by the sprint view //
    /////////////////////////////////////////////////////////////

    //TODO totatly a duplibated code get a sprint by id
    Route::get('sprintEdit/{id}',function($id) {
        return Response::json(App\Sprint::find($id));
    });

    //save changes made to a sprint 
    Route::post('sprint/edit/', function (Request $request){
        $Sprint=App\Sprint::find($request->id);
        $Sprint->name=$request->name;
        $Sprint->date_begin=$request->date_begin;
        $Sprint->date_estimated=$request->date_estimated;
        $Sprint->project_id=$request->project_id;
        $Sprint->save();

    });

    //get a sprint by id
    Route::get('sprint/{id}', function($id) {
        $project = App\Project::find($id);
        return Response::json($project->Sprints()->get());
    });

    //route used to delete a sprint takes the sprint id as a parameter
    Route::post('sprint/delete/{id}', function($id) {
        App\Sprint::find($id)->delete();
    });

    //route used to create a new sprint it takea a request with a map of a
    //sprint object and also creates the base layout of the sprint kanbam
    Route::post('sprint/add', function(Request $request) {
        $sprint = App\Sprint::create([
            'id' => null,
            'name' => $request->name,
            'date_begin' => $request->date_begin,
            'date_estimated' => $request->date_estimated,
            'project_id' => $request->project_id,
        ]);
        App\Layout::create([
            'name' => 'TODO',
            'position' => 0,
            'sprint_id' => $sprint->id,
        ]);
        App\Layout::create([
            'name' => 'DOING',
            'position' => 1,
            'sprint_id' => $sprint->id,
        ]);
        App\Layout::create([
            'name' => 'DONE',
            'position' => 2,
            'sprint_id' => $sprint->id,
        ]);
        return $sprint;
    });

    ///////////////////////////////////////////////////////////////////
    // userstory section those routes are used by the userstory view //
    ///////////////////////////////////////////////////////////////////

    //get a userstory from an id 
    Route::get('us/{id}',function($id) {
        return Response::json(App\UserStory::find($id));
    });

    //route used to set the sprint on the used hitory takes the userstory id (id)
    //and the sprint id (sp) as parameters
    Route::post('userstory/setsprint/{id}/{sp}', function($id, $sp) {

        $sprint=App\Sprint::find($sp);
        $us=App\UserStory::find($id);
        $us->sprint_id=$sp;
        $us->date_begin=$sprint->date_begin;
        $us->date_estimated=$sprint->date_estimated;
        $us->save();
    });


    //save a change to the userstory takes a request with a map of a userstory object
    Route::post('us/edit/',function(Request $request){
        $US=App\UserStory::find($request->id);
        $US->description=$request->description;
        $US->status=$request->status;
        $US->commit=$request->commit;
        $US->date_begin=$request->date_begin;
        $US->date_estimated=$request->date_estimated;
        $US->date_finished=$request->date_finished;
        $US->effort=$request->effort;
        $US->priority=$request->priority;
        $US->project_id=$request->project_id;
        $US->sprint_id=$request->sprint_id;
        $US->save();
    });


    //route used to delete a userstory take the usertstory id as a parameter 
    Route::post('us/delete/{id}', function($id) {
        App\UserStory::find($id)->delete();
    });

    //change the status of a us
    Route::post('updateus/{id}', function($id){
        $sprint = App\Sprint::find($id);
        foreach ($sprint->UserStorys()->get() as $us) {
            foreach($us->Tasks()->get() as $task){
                if($task->status!="DONE"){
                    $us->status = "ON GOING";
                    $us->save();
                    return true;
                }
            }
        }
        $us->status = "DONE";
        $us->date_finished = date("m/d/Y");
        $us->save();
        return true;
    });

    //route used to create a userstory takes a request with a map of an
    //userstory object as a parameter 
    Route::post('us/add', function(Request $request) {
        $us = App\UserStory::create([
            'description' => $request->description,
            'status' => null,
            'commit' => null,
            'date_begin' => null,
            'date_estimated' => null,
            'date_finished' => null,
            'effort' => $request->effort,
            'priority' => $request->priority,
            'project_id' => $request->project_id,
            'sprint_id' => null,
        ]);
        return $us;
    });

    //route to get a number fot the sprint based on the id 
    Route::get('sprintnb/{id}', function($id){
        $sprint = App\Sprint::find($id);
        $project = App\Project::find($sprint->project);
        $list = $project->Sprints()->orderBy('created_at')->get()->pluck('id');
        $nb = array_search($id,$list);
        return $nb;
    });

    //route used to get a list of userstory from a project ordered by parameter 
    // takes the project id (id) and the colunm to order by (order)
    Route::get('backlog/{id}/{order}', function($id, $order) {
        $project = App\Project::find($id);
        return Response::json($project->UserStorys()->orderBy($order)->get());
    });

    //route used to get a list of userstory by a sprint id
    Route::get('kanban/getus/{id}', function($id) {
        $project = App\Project::find(App\Sprint::find($id)->project_id);
        return Response::json($project->UserStorys()->orderBy("created_at")->get());
    });

    ////////////////////////////////////////////////////////////////
    // kanbam section those routes are used by the kanban section //
    ////////////////////////////////////////////////////////////////

    //change a position of a colunm int the layout takes a layout id and the
    //posdintion number
    Route::post('layout_pos/{id}/{pos}',function($id, $pos) {
        $layout = App\Layout::find($id);
        $layout->position = $pos;
        $layout->save();
    });

    // a get based on the Sprint
    Route::get('layout/{id}', function($id) {
        $sprint = App\Sprint::find($id);
        $cols = $sprint->Collunms()->orderBy('position')->get();
        return Response::json($cols);
    });

    // a get based on the colunmns
    Route::get('layoutcol/{id}',function($id){
        $cols=App\Layout::find($id);
        return Response::json($cols->get());
    });

    //TODO delete a colunm on the kanban by sprint id and colunm name 
    //should be fixed to use the layout id direct 
    Route::post('layout/delete/{id}/{name}',function ($id,$name){
        App\Sprint::find($id)->Collunms()->where('name',$name)->delete();

    });

    //route used to create a new colun on kanban it takes a request with the
    //layout object 
    Route::post('layout/add', function(Request $request) {
        App\Layout::create([
            'name' => $request->name,
            'position' => $request->position,
            'sprint_id' => $request->sprint_id,
        ]);
    });


    /////////////////////////////////////////////////////////
    // task section those routes are used by the task view //
    /////////////////////////////////////////////////////////

    //route used to add a new task  it takes a request with a map of the task
    //object 
    Route::post('task/add', function(Request $request){
        $task = App\Task::create([
            'id' => null,
            'name' => $request->name,
            'description' => $request->description,
            'status' => "TODO",
            'commit' => "",
            'priority' => $request->priority,
            'cost' => $request->cost,
            'date_begin' => "",
            'date_estimated' => "",
            'date_finished' => "",
            'user_story_id' => $request->user_story_id,
        ]);
        return $task;
    });

    //gets a task by id  
    Route::get('taskEdit/{id}',function($id) {
        return Response::json(App\Task::find($id));
    });

    //route used to save changes to a task
    Route::post('task/edit/', function (Request $request){
        $Task=App\Task::find($request->id);
        $Task->name=$request->name;
        $Task->description=$request->description;
        $Task->status=$request->status;
        $Task->commit=$request->commit;
        $Task->priority=$request->priority;
        $Task->cost=$request->cost;
        $Task->save();

    });

    //route usd to get a list of tasks based on status
    //takes the sprint id (id) and the status (status) of the task as a
    //parameter 
    Route::get('get_tasks/{id}/{status}', function($id,$status) {
        $sprint = App\Sprint::find($id);
        $result = array();
        foreach($sprint->UserStorys()->get() as $us){
            foreach($us->Tasks()->where('status',$status)->get() as $task){
                array_push($result, $task);
            }

        }
        return Response::json($result);
    });

    //route used to get a list of tasks fro a userstory , takes the userstory id
    //as parameter 
    Route::get('tasks/{id}', function($id) {

        $userstory = App\UserStory::find($id);

        return Response::json($userstory->Tasks()->get());
    });


    //route to get a task by id 
    Route::post('task/delete/{id}', function($id){
        App\Task::find($id)->delete();
    });

    //change a task status takes a task id and a nes status as parameter
    Route::post('updatetask/{id}/{status}', function($id, $status){
        $task = App\Task::find($id);
        $task->status = $status;
        $task->save();
    });

    //route used to get a list of tasks by id and status 
    Route::get('task/{status}/{id}',function($status,$id){
        $us=App\UserStory::find($id);
        $result=array();
        foreach($us->Tasks()->where('status',$status)->get() as $task){
            array_push($result, $task);
        }


        return Response::json($result);
    });

    ////////////////////////////////////////////////////////////////////////////
    // utilities those are a set of routes that are useful acroos all project //
    ////////////////////////////////////////////////////////////////////////////

    //route used to get a list of users filtered by the q element of a request 
    Route::get('userlist', function(Request $request) {

        $term = $request->q;
        $results = array();
        $queries = DB::table('users')
                 ->where('name', 'LIKE', '%'.$term.'%')
                 ->take(5)->get();
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'name' => $query->name ];
        }
        return Response::json($results);

    });

});
