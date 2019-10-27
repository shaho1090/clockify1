<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectFormRequest;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectsController extends Controller
{
    public function index()
    {
        $owner = Auth::user()->id;
        $projects = DB::table('projects')->where('owner',$owner)->get();
        return view('projects.index', ['projects' => $projects]);
    }
    public function edit($id)
    {
        $project = DB::table('projects')->where('id',$id)->first();
        //return view('projects.index', compact('project'));
    }
    public function add(ProjectFormRequest $request)
    {
        //$test1 = $request->get('project_title');
        //  dd($test1);
        //$test = Auth::user()->id;
        // dd($test);
        $project = new Project(array(
            'title' => $request->get('project_title'),
            'owner' => Auth::user()->id,
        ));
        $project->save();
        return redirect('/projects/index')->with('status', 'پروژه جدید ایجاد شد!');
    }
}
