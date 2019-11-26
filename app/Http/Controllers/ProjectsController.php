<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectFormRequest;
use App\Project;
use App\UserWorkSpace;
use App\WorkSpace;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        $activeUserWorkSpace = Auth::user()->activeUserWorkSpace();
;
        $projects = WorkSpace::find($activeUserWorkSpace->work_space_id)->projects()
            ->orderby('id','desc')
            ->get();

        return view('projects.index', [
            'projects' => $projects,
            'activeWorkSpace' =>  $activeUserWorkSpace,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ProjectFormRequest $request)
    {
        $this->authorize('store', Project::class);

        Auth::user()->activeUserWorkSpace()->projects()
            ->create(
                ['title' =>$request->get('title')]);

        return redirect(route('projects.index'))->with('status', 'پروژه جدید ایجاد شد!');
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return Response
     */
    public function show(Project $project)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Project $project
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function update(Project $project, ProjectFormRequest $request)
    {
        $project->update(['title' => $request->get('title')]);

        return redirect()->action('ProjectsController@index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return Response
     * @throws Exception
     */
    public function destroy(Project $project)
    {
        $project->workTimes()->delete();
        $project->delete();

        return redirect()->action('ProjectsController@index');
     }
}
