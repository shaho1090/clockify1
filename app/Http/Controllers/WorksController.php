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
use Illuminate\Support\Facades\Session;


class WorksController extends Controller
{
    private static $startTime = null;
    private static $stopTime = null;
    private static $work_id = null;

    public function index($project_id)
    {
        date_default_timezone_set('Asia/Tehran');
        $user_id = Auth::user()->id;
        $user = User::find($user_id );
        $user_project_id = $user
            ->userProjects()
            ->where('project_id',$project_id)
            ->get('id')
            ->first()
            ->id;
     /*   $user_project_works = $user
            ->works()
            ->where('user_project_id', $user_project_id)
            ->get()
            ->first;*/
        $user_project_works = DB::table('works')
            ->where('user_project_id',  $user_project_id)
            ->get();
        //dd( $user_project_works);
        $project = DB::table('projects')->where('id',$project_id)->get()->first();
        return view('works.index', [
          'works' =>  $user_project_works ,
          'project_title' => $project->title,
          'project_id' => $project_id,
         ]);
    }

    public function setStartTime($project_id)
    {
        date_default_timezone_set('Asia/Tehran');
        $user_id = Auth::user()->id;
        $user = User::find($user_id );
        $user_project_id = $user
            ->userProjects()
            ->where('project_id',$project_id)
            ->get('id')
            ->first()
            ->id;
        $user_project_works = DB::table('works')
            ->where('user_project_id',  $user_project_id)
            ->orderBy('start_time','desc')
            ->first();
        //dd($user_project_works->stop_time);

        if (!is_null($user_project_works->stop_time)){
            $this::$startTime = Carbon::now();
            return $this->setWork($project_id);
        }
        return redirect()->action(
        'WorksController@index', ['id' => $project_id]
    );
    }
    public function setWork($project_id)
    {
       $user_id = Auth::user()->id;
       $user = User::find($user_id );
       $user_project_id = $user
           ->userProjects()
           ->where('project_id',$project_id)
           ->get('id')
           ->first()
           ->id;

       $work = new Work(array(
           'start_time' => $this::$startTime,
           'user_project_id' => $user_project_id,
       ));
       $work->save();
       $this::$work_id = $work->id;
       return redirect()->action(
            'WorksController@index', ['id' => $project_id]
       );
    }



    public function setStopTime($project_id)
    {
        date_default_timezone_set('Asia/Tehran');
        $this::$stopTime = Carbon::now();
        $user_id = Auth::user()->id;
        $user = User::find($user_id );
        $user_project_id = $user
            ->userProjects()
            ->where('project_id',$project_id)
            ->get('id')
            ->first()
            ->id;
        $work = DB::table('works')
            ->where('user_project_id',  $user_project_id)
            ->orderBy('start_time','desc')
            ->first();
        if(is_null($work->stop_time)) {
            DB::table('works')
                ->where('id', $work->id)
                ->update(['stop_time' => $this::$stopTime]);
        }
         return redirect()->action(
            'WorksController@index', ['id' => $project_id]
        );

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
