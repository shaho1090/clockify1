<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectFormRequest;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ContributorsController;
use App\UserProject;

class ProjectsController extends Controller
{
    public function index()
    {
        $user = new User;
        $projects = $user->currentUser()->projects()->get()->all();
        return view("projects.index",compact('projects'));
    }
    public function editProject(Project $project)
    {
        $contributors = $project
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
        $project = new Project();

        $project = $project->where('id', $project_id)
            ->update(['title' => $project_title]);

        return redirect()->action(
            'ProjectsController@editProject', ['id' =>   $project_id]
        );

    }

    public function createNewProject(ProjectFormRequest $request)
    {
        $user = new User();
        $user_id =$user->currentUserId();
        $project_title = $request->get('project_title');
        $project = new Project(array(
            'title' => $project_title ,
            'user_id' =>$user_id,
        ));
        $project->save();
        $latest_project = $project->where('user_id',$user_id)->latest('created_at')->first();
        $user->currentUser()->projects()->attach( $latest_project->id,['access'=>0]); // zero means owner access
        return redirect('/projects/index')->with('status', 'پروژه جدید ایجاد شد!');
    }

}
