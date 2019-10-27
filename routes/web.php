<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('sendemail', function () {
    $data = array(
        'name' => "Learning Laravel",
    );
    Mail::send( 'contributors.invite',$data, function ($message) {
        $message->from('laravelshaho@gmail.com', 'Learning Laravel');
        $message->to('shaho.sanandaji@gmail.com')->subject('Learning Laravel test email');
    });
    return "Your email has been sent successfully";
});
Route::get('/contributors/invite',function () {
    return view('contributors.invite');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('projects/index','ProjectsController@index')->middleware('auth');
Route::get('/projects/show/{id?}', 'ProjectsController@show')->middleware('auth');
Route::post('/projects/add', 'ProjectsController@add')->middleware('auth');
Route::get('/projects/edit/{id?}', 'ProjectsController@edit')->middleware('auth');

