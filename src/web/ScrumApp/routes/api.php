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
Route::group(['middleware' => 'api'], function() {
    Route::get('members/{id}', function($id) {

        $project = App\Project::find($id);
        return Response::json($project->members()->get());
    });

    Route::get('tasks/{id}', function($id) {

        $userstory = App\UserStory::find($id);
        return Response::json($userstory->Tasks()->get());
    });
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

    Route::post('adduser/{userid}/{projectid}', function($userid, $projectid) {
        $project = App\Project::find($projectid);
        $project->members()->attach($userid);
    });
    Route::post('members/delete/{projectid}/{userid}', function($projectid, $userid) {
        $project = App\Project::find($projectid);
        $project->members()->detach($userid);
    });
    Route::post('project/delete/{projectid}', function($projectid) {
         App\Project::find($projectid)->delete();
    });
    Route::post('us/delete/{id}', function($id) {
        App\UserStory::find($id)->delete();
    });

    Route::post('sprint/delete/{id}', function($id) {
        App\Sprint::find($id)->delete();
    });

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

    Route::post('sprint/add', function(Request $request) {
        $sprint = App\Sprint::create([
            'id' => null,
            'name' => $request->name,
            'date_begin' => $request->date_begin,
            'date_estimated' => $request->date_estimated,
            'project_id' => $request->project_id,
        ]);
        return $sprint;
    });

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

    Route::post('project/edit', function(Request $request) {
        $project = App\Project::find($request->id);
        $project->name = $request->name;
        $project->description = $request->description;
        $project->language = $request->language;
        $project->version = $request->version;
        $project->save();

    });
    Route::get('project/{id}', function($id) {
        return Response::json(App\Project::find($id));
    });

    Route::get('sprintnb/{id}', function($id){
        $sprint = App\Sprint::find($id);
        $project = App\Project::find($sprint->project);
        $list = $project->Sprints()->orderBy('created_at')->get()->pluck('id');
        $nb = array_search($id,$list);
        return $nb;
    });

    Route::get('usnb/{id}', function($id){
        $us = App\UserStory::find($id);
        $project = App\Project::find($us->project);
        $list = $project->UserStorys()->orderBy('created_at')->get()->pluck('id');
        $nb = array_search($id,$list);
        return $nb;
    });
    Route::get('backlog/{id}/{order}', function($id, $order) {
        $project = App\Project::find($id);
        return Response::json($project->UserStorys()->orderBy($order)->get());
    });
    Route::get('us/{id}',function($id) {
        return Response::json(App\UserStory::find($id));
    });
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

    Route::get('sprint/{id}', function($id) {
        $project = App\Project::find($id);
        return Response::json($project->Sprints()->get());
    });

     Route::post('task/add', function(Request $request){
        $task = App\Task::create([
            'id' => null,
            'name' => $request->name,
            'description' => $request->description,
            'status' => "",
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

    Route::post('task/delete/{id}', function($id){
        App\Task::find($id)->delete();
    });
    
    Route::get('sprintEdit/{id}',function($id) {
        return Response::json(App\Sprint::find($id));
    });
    Route::post('sprint/edit/', function (Request $request){
        $Sprint=App\Sprint::find($request->id);
        $Sprint->name=$request->name;
        $Sprint->date_begin=$request->date_begin;
        $Sprint->date_estimated=$request->date_estimated;
        $Sprint->project_id=$request->project_id;
        $Sprint->save();

    });
});
