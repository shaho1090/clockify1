<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkFormRequest;
use App\Project;
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

    public function index(Project $project)
    {
        date_default_timezone_set('Asia/Tehran');
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $user_project_id = $user
            ->userProjects()
            ->where('project_id',$project->id)
            ->get('id')
            ->first()
            ->id;
        $user_project_works = $user->works()->where('user_project_id',$user_project_id)
            ->get()
            ->all();
        return view('works.index', [
          'works' =>  $user_project_works ,
          'project_title' => $project->title,
          'project_id' => $project->id,
         ]);
    }

    public function currentWork(Project $project)
    {
        $current_user_project = $this->currentUserProject($project);
        $user = new User();
        $current_user_work =  $user
            ->currentUser()
            ->works()
            ->where('user_project_id',$current_user_project->id)
            ->get()
            ->last();
        return $current_user_work;
    }

   public function currentUserProject(Project $project)
    {
        $user = new User();
        $current_user_project = $user->currentUser()
            ->userProjects()
            ->where('project_id',$project->id)->get()->first();
        return  $current_user_project;
    }

    public function setStartTime(Project $project)
    {
        date_default_timezone_set('Asia/Tehran');
        $start_time = carbon::now();
        $user = new User();
       /* $user_project_id = $user->currentUser()
            ->userProjects()
            ->where('project_id',$project->id)
            ->get('id')
            ->first()
            ->id;*/
        $work = new Work();
        $work = $work->fill(['user_project_id'=>$user_project_id,
                             'start_time'=> $start_time,
        ]);
        $user_project_works = $user->currentUser()
            ->works()
            ->where('user_project_id',  $user_project_id)
            ->orderBy('start_time','desc')
            ->first();
        if (!is_null($user_project_works)and(!is_null($user_project_works->stop_time))) {
            $this::$startTime = Carbon::now();
            return $this->setWork($project);
        }
        return redirect()->action(
        'WorksController@index', ['project' => $project->id]
         );
    }

    public function setWork(Project $project)
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
        $user = new User();
        $user_project_id = $user->currentUser()
            ->userProjects()
            ->where('project_id',$project_id)
            ->get('id')
            ->first()
            ->id;
        $work = new Work();
        $work = $work->where('user_project_id',  $user_project_id)
            ->orderBy('start_time','desc')
            ->first();

        if(!is_null($work)and(is_null($work->stop_time))) {
            $work->where('id', $work->id)
                 ->update(['stop_time' => Carbon::now()]);
            }
        return redirect()->action(
            'WorksController@index', ['id' => $project_id]
        );
    }

    public function editWork($work_id)
    {
        $work = DB::table('works')
            ->where('id',$work_id)
            ->get()
            ->first();
        $startTime = Carbon::parse($work->start_time);
        $stopTime = Carbon::parse($work->stop_time);
        $totalDuration =  $stopTime->diffInSeconds($startTime);
        return view('works.edit', [
            'totalDuration' => $totalDuration,
            'work' => $work,
        ]);

    }

    public function storeEdited(WorkFormRequest $request)
    {
        $billable = $request->get('selectBillable');
        if(is_null($billable)) {
            $billable = false;
        }
        $work_id = $request->get('work_id');

       DB::table('works')
            ->where('id', $work_id)
            ->update(['billable' => $billable]);

       return $this->index($request->user_project_id);

    }



}
