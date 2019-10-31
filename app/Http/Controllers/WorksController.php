<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkFormRequest;
use App\UserProject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Work;


class WorksController extends Controller
{
    private static $startTime = null;
    private static $stopTime = null;

    public function index($project_id)
    {
        $user_id = Auth::user()->id;
        $works = User::find($user_id)->works()->get()->first();
        $project = DB::table('projects')->where('id',$project_id)->get()->first();
        return view('works.index', [
          'works' => $works,
          'project_title' => $project->title,
          'project_id' => $project_id,
         ]);
   }
    public function setWork($project_id)
    {
        $user_id = Auth::user()->id;
       // $user_project_id = DB::table('user_project')->where(['user_id', $user_id] and ['project_id',$project_id]);
       $user = User::find($user_id );
       $user_project_id = $user->userProjects()->where('project_id',$project_id)->get('id')->first();
       //dd($test->id);
        if(isset($this::$startTime))
        {
           $work = new Work(array(
               'start_time' => $this::$startTime,
               'user_project_id' => $user_project_id,
           ));
           $work->save();
        }
        return $this->index($project_id);

    }

    public function setStartTime($project_id)
    {
        date_default_timezone_set('Asia/Tehran');

        if (!isset($this::$startTime)) {
            $this::$startTime = Carbon::now();
        }
        return $this->setWork($project_id);
    }

    public function setStopTime()
    {
        $this::$startTime = null;
        date_default_timezone_set('Asia/Tehran');
        if (!isset($this::$stopTime)) {
            $this::$stopTime = Carbon::now();
        }
    }
    public function showTime($time)
    {

    }

    public function doWork($project_id)
   {
       $user_id = Auth::user()->id;
       $works = User::find($user_id)->works()->get()->first();
       $project = DB::table('projects')->where('id',$project_id)->get()->first();

       return view('works.index', [
           'project_title' => $project->title,
           'works' => $works,
           ]);
   }



}
