<?php

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('sendemail', function () {
    $data = array(
        'name' => "Learning Laravel",
    );
    Mail::send( 'contributors.welcome',$data, function ($message) {
        $message->from('laravelshaho@gmail.com', 'Learning Laravel');
        $message->to('shaho.sanandaji@gmail.com')->subject('Learning Laravel test email');
    });
    return "Your email has been sent successfully";
});

Route::get('/contributors/welcome',function () {
    return view('contributors.welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/initial-workspace','InitialWorkSpaceController@store');

Route::middleware('auth')->group(function () {
    Route::get('/work-time/index','WorkTimesController@index');
    Route::post('/work-time/start','NewWorkTimeController@store' );
    Route::post('/work-time/stop','NewWorkTimeController@destroy' );
    Route::patch('/work-time/{workTime}/edit','WorkTimesController@edit' );
    Route::put('/work-time/update','WorkTimesController@update' );
    Route::delete('/work-time/delete/{workTime}','WorkTimesController@destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/tags/index','TagsController@index');
    Route::post('/tags/store','TagsController@store' );
    Route::patch('/tags/{tag}/edit','TagsController@edit' );
    Route::put('/tags/update','TagsController@update' );
});

Route::middleware('auth')->group(function () {
    Route::get('/projects/index','ProjectsController@index' );
    Route::get('/projects/create','ProjectsController@create' );
    Route::post('/projects/store','ProjectsController@store' );
    Route::get('/projects/show/{project}','ProjectsController@show' );
    Route::get('/projects/edit','ProjectsController@edit' );
    Route::post('/projects/update','ProjectsController@update' );
    Route::get('/projects/destroy/{id}','ProjectsController@destroy' );
});

/*Route::prefix('project/works')->middleware('auth')->group(function () {
    Route::get('/index/{id}','project\WorksController@index' );
    Route::get('/create','project\WorksController@create' );
    Route::post('/store','project\WorksController@store' );
    Route::get('/show','project\WorksController@show' );
    Route::get('/edit','project\WorksController@edit' );
    Route::get('/update','project\WorksController@update' );
    Route::get('/destroy','project\WorksController@destroy' );
});*/


//Route::get('projects/index','ProjectsController@index')->middleware('auth');
Route::get('/projects/index','ProjectsController@index' )->middleware('auth');
//Route::get('/projects/show/{id?}', 'ProjectsController@show')->middleware('auth');
Route::post('/projects/create', 'ProjectsController@create')->middleware('auth');
Route::get('/projects/show/{id?}', 'ProjectsController@show')->middleware('auth');
Route::post('/projects/store/', 'ProjectsController@store')->middleware('auth');
Route::post('/projects/delete/', 'ProjectsController@delete')->middleware('auth');


Route::get('/contributors/invited/{email?}', 'ContributorsController@add')->middleware('auth')->name('inviteGet');
Route::get('/contributors/invite/{project}', 'ContributorsController@invite')->middleware('auth')->name('invitePost');
Route::get('/contributors/index', 'ContributorsController@index')->middleware('auth')->name('contributors');

Route::get('/works/index/{project}', 'WorksController@index')->middleware('auth');
Route::get('/works/start/{project}', 'WorksController@setStartTime')->middleware('auth');
Route::get('/works/stop/{project}', 'WorksController@setStopTime')->middleware('auth');
Route::get('/works/edit/{id?}', 'WorksController@editWork')->middleware('auth');
Route::post('/works/storeEdited', 'WorksController@storeEdited')->middleware('auth');
Route::get('/works/current/{project}', 'WorksController@currentWork')->middleware('auth');

