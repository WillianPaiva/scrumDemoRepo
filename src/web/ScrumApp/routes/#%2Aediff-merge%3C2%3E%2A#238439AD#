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
        return $project->members()->get();
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

    Route::get('backlog/{id}/{order}', function($id, $order) {
        $project = App\Project::find($id);
        return Response::json($project->UserStorys()->orderBy($order)->get());
    });
    Route::get('us/{id}',function($id) {
    return Response::json(App\UserStory::find($id)->get());
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
});
