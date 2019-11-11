<?php

namespace App\Http\Controllers;

use App\Project;
use App\UserWorkSpace;
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
        $activeWorkSpace = Auth::user()->activeWorkSpace();

        $projects = Project::where('user_work_space_id', $activeWorkSpace->id)
            ->orderby('id','desc')
            ->get();

        return view('projects.index', [
            'projects' => $projects,
            'activeWorkSpace' =>  $activeWorkSpace,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $activeWorkSpace = Auth::user()->activeWorkSpace();
        $project_title = $request->get('project_title');

        UserWorkSpace::find($activeWorkSpace->id)->projects()->create(['title' =>$project_title]);

        return redirect('/projects/index')->with('status', 'پروژه جدید ایجاد شد!');
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $contributors = $project
            ->users()
            ->get()
            ->all();
        return view('projects.show', [
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $user->projects()->detach($id);
        return redirect()->action('UserProjectsController@index');
     }
}
