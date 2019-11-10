<?php

namespace App\Http\Controllers;

use App\User;
use App\WorkSpace;
use App\WorkTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserWorkSpace;


class WorkTimesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeWorkSpace = Auth::user()->activeWorkSpace();

        $workTimes = WorkTime::where('work_space_id', $activeWorkSpace->id)
            ->get();

        $incompleteWorkTime = UserWorkSpace::find($activeWorkSpace->id)->incompleteWorkTimes()->first();
      //  dd( $workTimes);

        return view('work_times.index', [
            'workTimes' => $workTimes,
            'activeWorkSpace' =>  $activeWorkSpace,
            'incompleteWorkTime' =>   $incompleteWorkTime,
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
