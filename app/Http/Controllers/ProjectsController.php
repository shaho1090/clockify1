<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectFormRequest;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ContributorsController;
use App\UserProject;



class ProjectsController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
      //  $projects = DB::table('projects')->where('user_id',$user_id)->get();
       $projects = User::find($user_id)->projects()->get();
      /*  $user = User::find($user_id);
        foreach ($user->projects as $project) {
            echo $project;
        }*/
        return view('projects.index', ['projects' => $projects]);
    }


    public function show($project_id)
    {
        //$contributors = Project::find($project_id)->user()->orderBy('id')->get();
      //  $projects = Project::find($project_id);
       // $user = $projects->user;
        //dd($user);
       // dd($projects);
        //$projects = User::find($user_id)->project()->orderBy('id')->get();

        $project = DB::table('projects')->where('id',$project_id)->first();
       // $contributors = DB::table('users')->where('id',$contributor)->get();

        //dd( $contributors);

        return view('projects.show', ['project'=>$project,
           'projects' =>  $projects,
        ]);
    }
    public function createNewProject(ProjectFormRequest $request)
    {
        $user_id = Auth::user()->id;
        $project_title = $request->get('project_title');
        $project = new Project(array(
            'title' => $project_title ,
            'user_id' =>$user_id,
        ));
        $project->save();
       /*
        * پروژه جدید در جدول projects ایجاد شده و همزمان باید رکورد ارتباط بین جدول user_project ایجاد شود
        * در پایین این کار انجام شده است.
        */
        $latest_project = DB::table('projects')->where('user_id',$user_id)->latest('created_at')->first();
        $user = User::find($user_id);

        $user->projects()->attach( $latest_project->id,['access'=>0]); // zero means owner access
        return redirect('/projects/index')->with('status', 'پروژه جدید ایجاد شد!');
    }

}
