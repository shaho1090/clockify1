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
/*
 * these routes used for change work time fields using ajax
 */
Route::middleware('auth')->group(function () {

    Route::get('/work-time/title/{workTime}/{title}','WorkTimeTitleController@update' );
    Route::get('/work-time/project/{workTime}/{project}','WorkTimeProjectController@update' );
    Route::get('/work-time/billable/{workTime}/{billable}','WorkTimeBillableController@update' );
});

Route::middleware('auth')->group(function () {
    Route::get('/tags/index','TagsController@index')->name('tags.index');
    Route::post('/tags/store','TagsController@store' );
    Route::patch('/tags/{tag}/edit','TagsController@edit' );
    Route::get('/tags/update/{tag}/{title}','TagsController@update' );
    Route::delete('/tags/destroy/{tag}','TagsController@destroy' );
});

Route::middleware('auth')->group(function () {
    Route::get('/projects/index','ProjectsController@index' );
    Route::get('/projects/create','ProjectsController@create' );
    Route::post('/projects/store','ProjectsController@store' );
    Route::get('/projects/show/{project}','ProjectsController@show' );
    Route::get('/projects/edit','ProjectsController@edit' );
    Route::post('/projects/update','ProjectsController@update' );
    Route::delete('/projects/destroy/{project}','ProjectsController@destroy' );
});

Route::middleware('auth')->group(function () {

    Route::get('/project/title/{project}/{title}','ProjectTitleController@update' );

});

Route::middleware('auth')->group(function () {

    Route::get('/tag/title/{tag}/{title}','TagTitleController@update' );
});

//Route::middleware('auth')->group(function () {
//
//    Route::post('/invite-member/store','InviteMembersController@store' );
//});



Route::middleware('auth')->group(function () {
    Route::get('/work-space/members/index','WorkSpaceMembersController@index' );
    Route::post('/work-space/members/store','WorkSpaceMembersController@store' );
    Route::get('/work-space/members/show','WorkSpaceMembersController@show' );
    Route::get('/work-space/members/edit','WorkSpaceMembersController@edit' );
    Route::post('/work-space/members/update','WorkSpaceMembersController@update' );
    Route::get('/work-space/members/destroy','WorkSpaceMembersController@destroy' );
});




Route::middleware('auth')->group(function () {
   // Route::get('/work-space/members/index','WorkSpaceMembersController@index' );
    Route::post('/invite/members/store','InviteMembersController@store' );
  //  Route::get('/work-space/members/show','WorkSpaceMembersController@show' );
  //  Route::get('/work-space/members/edit','WorkSpaceMembersController@edit' );
   // Route::post('/work-space/members/update','WorkSpaceMembersController@update' );
 //   Route::get('/work-space/members/destroy','WorkSpaceMembersController@destroy' );
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

Route::get('/contributors/invited/{email?}', 'ContributorsController@add')->middleware('auth')->name('inviteGet');
Route::get('/contributors/invite/{project}', 'ContributorsController@invite')->middleware('auth')->name('invitePost');
Route::get('/contributors/index', 'ContributorsController@index')->middleware('auth')->name('contributors');

Route::get('/works/index/{project}', 'WorksController@index')->middleware('auth');
Route::get('/works/start/{project}', 'WorksController@setStartTime')->middleware('auth');
Route::get('/works/stop/{project}', 'WorksController@setStopTime')->middleware('auth');
Route::get('/works/edit/{id?}', 'WorksController@editWork')->middleware('auth');
Route::post('/works/storeEdited', 'WorksController@storeEdited')->middleware('auth');
Route::get('/works/current/{project}', 'WorksController@currentWork')->middleware('auth');

