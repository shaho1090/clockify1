<?php

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('sendemail', function () {
    $data = array(
        'name' => "Learning Laravel",
    );
    Mail::send( 'members.welcome',$data, function ($message) {
        $message->from('laravelshaho@gmail.com', 'Learning Laravel');
        $message->to('shaho.sanandaji@gmail.com')->subject('Learning Laravel test email');
    });
    return "Your email has been sent successfully";
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/initial-workspace','InitialWorkSpaceController@store')->name('initial.workspace');

Route::middleware('auth')->group(function () {
    Route::get('/work-time/index','WorkTimesController@index')->name('work-time.index');
    Route::post('/work-time/start','NewWorkTimeController@store' )->name('work-time.start');
    Route::post('/work-time/stop','NewWorkTimeController@destroy' )->name('work-time.stop');
    Route::patch('/work-time/{workTime}/edit','WorkTimesController@edit' )->name('work-time.edit');
    Route::put('/work-time/update','WorkTimesController@update' )->name('work-time.update');
    Route::delete('/work-time/delete/{workTime}','WorkTimesController@destroy')->name('work-time.destroy');
});
/*
 * these routes used for change work time fields using ajax
 */
Route::middleware('auth')->group(function () {
    Route::put('/work-time/title/{workTime}','WorkTimeTitleController@update' );
    Route::put('/work-time/project/{workTime}','WorkTimeProjectController@update' );
    Route::put('/work-time/billable/{workTime}','WorkTimeBillableController@update' );
    Route::put('/work-time/tag/{workTime}','WorkTimeTagController@update' );
});

Route::resource('work-spaces', 'WorkSpacesController')->except(['update'])->middleware('auth');
Route::put('/work-spaces/update/{workSpace}','WorkSpacesController@update' )->name('work-spaces.update')
    ->middleware('auth');
Route::post('/activate-workspace/{workSpace}', 'ActivateWorkSpaceController@store')->middleware('auth')
    ->name('activate-workspace');

Route::resource('tags', 'TagsController')->except(['update'])->middleware('auth');
Route::put('/tags/update/{tag}','TagsController@update' )->name('tags.update')->middleware('auth');

Route::resource('projects', 'ProjectsController')->except(['update'])->middleware('auth');
Route::put('/projects/update/{project}','ProjectsController@update')
    ->name('projects.update')->middleware('auth');

Route::resource('members', 'WorkSpaceMembersController')->middleware('auth');

Route::resource('invitees', 'InviteesController')->middleware('auth');

Route::post('/send/mail/{invitee}', 'MailController@store')->name('send.mail')->middleware('auth');
Route::get('/get/back', 'MailController@edit')->name('get.back')->middleware('auth');

//Route::get('/contributors/invited/{email?}', 'ContributorsController@add')->middleware('auth')->name('inviteGet');
//Route::get('/contributors/invite/{project}', 'ContributorsController@invite')->middleware('auth')->name('invitePost');
//Route::get('/contributors/index', 'ContributorsController@index')->middleware('auth')->name('contributors');



