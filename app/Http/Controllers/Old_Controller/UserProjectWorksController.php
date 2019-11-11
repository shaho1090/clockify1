<?php

namespace App\Http\Controllers;

use App\Project;
use App\UserProject;
use App\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProjectWorksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Project $project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $contributor = UserProject::contributor(auth()->id(),$project->id)->first();

        $lastActiveProject = $contributor->incompletedWorks()->first();

        return view('works.index', [
            'contributor' => $contributor->load('works'),
            'project' => $project,
            'last_project' => $lastActiveProject ?: false,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Project $project
     * @return void
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Work $work
     * @return \Illuminate\Http\Response
     */
    public function edit(Work $work)
    {
        Work::find($work->id)
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $billable = $request->get('selectBillable');
        if(is_null($billable)) {
            $billable = false;
        }

        Work::find($request->get('work_id'))->update(['billable' => $billable,
            'title' => $request->title]);

        return redirect()->action('UserProjectWorksController@index',
            ['project' => $request->user_project_id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
