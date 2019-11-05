<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Project;
use App\User;
use App\UserProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Project $project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        date_default_timezone_set('Asia/Tehran');
        $user_project_id = $user_project->UserProjectId($project)->get();
        dd($user_project_id);


        $user = User::find($user_id);
        $user->relatedProjects()->get();

        UserProject::contributor($user->id, $project->id)
                ->first()
                ->id;
//        $user_project_id = $user
//            ->userProjects()
//            ->where('project_id',$project->id)
//            ->get('id')
//            ->first()
//            ->id;
        $user_project_works = $user->works()->where('user_project_id',$user_project_id)
            ->get()
            ->all();
        return view('works.index', [
            'works' =>  $user_project_works ,
            'project_title' => $project->title,
            'project_id' => $project->id,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
