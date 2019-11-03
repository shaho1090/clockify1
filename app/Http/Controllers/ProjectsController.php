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
    /*
     * I use Route-model Binding instead this method
     */
   /* public function index()
    {
        $user_id = Auth::user()->id;
        $projects = User::find($user_id)->projects()->get();
        return view('projects.index', ['projects' => $projects]);
    }*/

    public function editProject($project_id)
    {
        $project = DB::table('projects')
            ->where('id',$project_id)
            ->get()
            ->first();
        $contributors = Project::find($project_id)
            ->users()
            ->get()
            ->all();
        return view('projects.edit', [
            'project' => $project,
            'contributors' => $contributors,
        ]);

    }
    public function storeEdited(ProjectFormRequest $request)
    {

        $project_title = $request->get('project_title');
        $project_id = $request->get('project_id');

        DB::table('projects')
            ->where('id', $project_id)
            ->update(['title' => $project_title]);

        return redirect()->action(
            'ProjectsController@editProject', ['id' =>   $project_id]
        );

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
