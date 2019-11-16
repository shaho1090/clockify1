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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/initial-workspace','InitialWorkSpaceController@store');

Route::middleware('auth')->group(function () {
    Route::get('/work-time/index','WorkTimesController@index')->name('work-time.index');
    Route::post('/work-time/start','NewWorkTimeController@store' )->name('work-time.start');
    Route::post('/work-time/stop','NewWorkTimeController@destroy' )->name('work-time.stop');
    Route::patch('/work-time/{workTime}/edit','WorkTimesController@edit' )->name('work-time.edit');
    Route::put('/work-time/update','WorkTimesController@update' )->name('work-time.update');
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

//Route::middleware('auth')->group(function () {
//    Route::get('/tags/index','TagsController@index')->name('tags.index');
//    Route::post('/tags/store','TagsController@store' )->name('tags.store');
//    Route::patch('/tags/{tag}/edit','TagsController@edit' )->name('tags.edit');
//    Route::get('/tags/update/{tag}/{title}','TagsController@update' )->name('tags.update');
//    Route::delete('/tags/destroy/{tag}','TagsController@destroy' )->name('tags.destroy');
//});

Route::resource('tags', 'TagsController')->except([
    'update'
])->middleware('auth');
Route::put('/tags/update/{tag}','TagsController@update' )->name('tags.update')->middleware('auth');

Route::resource('projects', 'ProjectsController')->middleware('auth');

Route::resource('members', 'WorkSpaceMembersController')->middleware('auth');

Route::resource('invitees', 'InviteesController')->middleware('auth');

//Route::middleware('auth')->group(function () {
//    Route::get('/work-space/members/index','WorkSpaceMembersController@index' );
//    Route::post('/work-space/members/store','WorkSpaceMembersController@store' );
//    Route::get('/work-space/members/show','WorkSpaceMembersController@show' );
//    Route::get('/work-space/members/edit','WorkSpaceMembersController@edit' );
//    Route::post('/work-space/members/update','WorkSpaceMembersController@update' );
//    Route::get('/work-space/members/destroy','WorkSpaceMembersController@destroy' );
//});

//Route::middleware('auth')->group(function () {
//    Route::get('/projects/index','ProjectsController@index' )->name('projects.index');
//    Route::get('/projects/create','ProjectsController@create' )->name('projects.create');
//    Route::post('/projects/store','ProjectsController@store' )->name('projects.store');
//    Route::get('/projects/show/{project}','ProjectsController@show' )->name('projects.show');
//    Route::get('/projects/edit','ProjectsController@edit' )->name('projects.index');
//    Route::post('/projects/update','ProjectsController@update' );
//    Route::delete('/projects/destroy/{project}','ProjectsController@destroy' );
//});

//Route::middleware('auth')->group(function () {
//
//    Route::get('/tag/title/{tag}/{title}','TagTitleController@update' );
//});

//Route::middleware('auth')->group(function () {
//
//    Route::post('/invite-member/store','InviteMembersController@store' );
//});

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



