<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectFormRequest;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ContributorsController;

class ProjectsController extends Controller
{
    public function index()
    {
        $owner = Auth::user()->id;
        $projects = DB::table('projects')->where('owner',$owner)->get();
        return view('projects.index', ['projects' => $projects]);
    }
    public function show($project_id)
    {
        $project = DB::table('projects')->where('id',$project_id)->first();
      //  $test = $project->title;
        //dd($test);
        $contributors = DB::table('contributors')->where('id',$project_id)->get();
       // dd( $contributors);
        return view('projects.show', ['project'=>$project,
           'contributors' => $contributors,
        ]);
    }
    public function add(ProjectFormRequest $request)
    {
        $project = new Project(array(
            'title' => $request->get('project_title'),
            'owner' => Auth::user()->id,
        ));
        $project->save();

        //باید ادر اینجا کنترلر کانتربیوتر صدا زده شده و خود ایجاد کننده پروژه به عنوان اولین نفر به لیست مشارکت کنندگان اضافه شود
        return redirect('/projects/index')->with('status', 'پروژه جدید ایجاد شد!');
    }
}
