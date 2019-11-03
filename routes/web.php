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

use App\Http\Requests\ProjectFormRequest;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ContributorsController;
use App\UserProject;

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
//Route::get('projects/index','ProjectsController@index')->middleware('auth');
Route::get('/projects/index','ProjectsController@index' )->middleware('auth')->name('projectIndex');
//Route::get('/projects/show/{id?}', 'ProjectsController@show')->middleware('auth');
Route::post('/projects/add', 'ProjectsController@add')->middleware('auth');
Route::get('/projects/show/{project}', 'ProjectsController@show')->middleware('auth');
Route::post('/projects/edit/', 'ProjectsController@edit')->middleware('auth');

Route::get('/contributors/invited/{email?}', 'ContributorsController@add')->middleware('auth')->name('inviteGet');
Route::post('/contributors/invite', 'ContributorsController@invite')->middleware('auth')->name('invitePost');
Route::get('/contributors/index', 'ContributorsController@index')->middleware('auth')->name('contributors');

Route::get('/works/index/{project}', 'WorksController@index')->middleware('auth');
Route::get('/works/start/{id?}', 'WorksController@setStartTime')->middleware('auth');
Route::get('/works/stop/{id?}', 'WorksController@setStopTime')->middleware('auth');
Route::get('/works/edit/{id?}', 'WorksController@editWork')->middleware('auth');
Route::post('/works/storeEdited', 'WorksController@storeEdited')->middleware('auth');
