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
    Route::get('getownproject/{id}/{search?}', function($id, $search = null) {
        $user = App\User::find($id);
        if($search == null){
            return Response::json($user->owns()->get());
        }else{
            return Response::json($user->owns()
                                  ->where('name', 'LIKE', '%'.$search.'%')
                                  ->get());
        }

    });
    Route::get('getmemberproject/{id}/{search?}', function($id, $search = null) {
        $user = App\User::find($id);
        if($search == null){
            return Response::json($user->memberof()->get());
        }else{
            return Response::json($user->memberof()
                                  ->where('name', 'LIKE', '%'.$search.'%')
                                  ->get());
        }

    });
});