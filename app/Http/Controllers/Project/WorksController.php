<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Project $project
     * @return void
     */
    public function index(Project $project)
    {
        $user = Auth::user();
        $user_project_works =  $user->works()->get()->all();
        dd($user_project_works);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Project $project
     * @return void
     */
    public function create(Project $project)
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
