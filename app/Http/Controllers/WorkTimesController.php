<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkTimeFormRequest;
use App\Http\Requests\WorkTimeRequest;
use App\WorkSpace;
use App\WorkTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkTimesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workTimes =  Auth::user()->completeWorkTimes()
            ->orderby('id', 'desc')
            ->get();

        return view('work_times.index', [
            'workTimes' => $workTimes->load('project')->load('tags'),
            'projects' => Auth::user()->activeUserWorkSpace()->projects()->get(),
            'incompleteWorkTime' => Auth::user()
                ->incompleteWorkTimes()
                ->first(),
            'tags' => Auth::user()->activeUserWorkSpace()->tags()->get(),
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param WorkTime $workTime
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkTime $workTime)
    {
        $startTime = Carbon::parse($workTime->start_time);
        $stopTime = Carbon::parse($workTime->stop_time);
        $totalDuration = $stopTime->diffInSeconds($startTime);


        return view('work_times.edit', [
            'totalDuration' => $totalDuration,
            'workTime' => $workTime->load('project'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param WorkTime $workTime
     * @return void
     */
    public function update(WorkTimeRequest $request)
    {
        $billable = $request->get('selectBillable');
        $billable = $billable ? true : false;

        WorkTime::find($request->get('workTimeId'))
            ->update(['billable' => $billable,
                'title' => $request->get('title')]);

        return redirect()->action('WorkTimesController@index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkTime $workTime
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(WorkTime $workTime)
    {
        $workTime->delete();

        return redirect()->action('WorkTimesController@index');
    }
}
