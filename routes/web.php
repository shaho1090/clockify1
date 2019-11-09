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
//Route::get('/user/project/works/create/{project?}','UserProjectWorksController@create')->middleware('auth');

//Route::resource('/user/project/works/','UserProjectWorksController')->middleware('auth');
//Route::resource('/user/projects/','UserProjectWorksController')->middleware('auth');
Route::middleware('auth')->group(function () {
    Route::get('/user/projects/index','UserProjectsController@index' );
    Route::get('/user/projects/create','UserProjectsController@create' );
    Route::post('/user/projects/store','UserProjectsController@store' );
    Route::get('/user/projects/show/{project}','UserProjectsController@show' );
    Route::get('/user/projects/edit','UserProjectsController@edit' );
    Route::post('/user/projects/update','UserProjectsController@update' )->name('user_project_update');
    Route::get('/user/projects/destroy/{id}','UserProjectsController@destroy' );
});

Route::middleware('auth')->group(function () {
    Route::get('/user/project/works/index/{project}','UserProjectWorksController@index' );
    Route::get('/user/project/works/create/{project?}','UserProjectWorksController@create');
//  Route::post('/user/project/works/store','UserProjectWorksController@store' );
    Route::get('/user/project/works/show/{project?}','UserProjectWorksController@show');
    Route::get('/user/project/works/destroy','UserProjectWorksController@destroy');

    Route::put('/work/update','UserProjectWorksController@update');
    Route::patch('/task/{work?}/edit/','UserProjectWorksController@edit');
    Route::post('/task-start/{contributor}', 'TasksController@store');
    Route::post('/task-end/{contributor}', 'TasksController@destroy');

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

