<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::get('/', 'WelcomeControler@index')->name('welcome');
Auth::routes();

Route::get('/profile','UserController@userProfile')->name('profile');
Route::post('/profile','UserController@update_avatar');
Route::get('/project/list','ProjectController@getProject')->name('projects');
Route::get('/backlog/{id}','backlogController@index')->name('backlog');
Route::get('/userstory/{id}/{nb}','userstoryController@index')->name('userstory');
Route::get('/kanban/{id}','sprintController@index')->name('sprint');


