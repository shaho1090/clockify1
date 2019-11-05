<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects =Auth::user()->projects()->get()->all();
        return view("users.projects.index",compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       dd("create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id =Auth::user()->id;
        $project_title = $request->get('project_title');
        $project = new Project(array(
            'title' => $project_title
        ));
        $project->save();
        Auth::user()->projects()->attach( $project->id,['access'=>0]); // zero means owner access
        return redirect('/user/projects/index')->with('status', 'پروژه جدید ایجاد شد!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $contributors = $project
            ->users()
            ->get()
            ->all();
        return view('users.projects.show', [
            'project' => $project,
            'contributors' => $contributors,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $project_title = $request->get('project_title');
        $project_id = $request->get('project_id');

        $project = new Project();
        $project = $project->where('id', $project_id)
            ->update(['title' => $project_title]);

        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $project = new Project();
        $project->where('id',$request->project_id)->delete();
        return $this->index();
    }
}
