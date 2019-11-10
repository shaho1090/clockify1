<?php

namespace App\Http\Controllers;


use App\UserWorkSpace;
use App\WorkTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NewWorkTimeController extends Controller
{

    public function store(Request $request)
    {
        $incompleteWorkTime =UserWorkSpace::find($request->activeWorkSpaceId)
            ->incompleteWorkTimes()
            ->first();

        if (! $incompleteWorkTime) {
           WorkTime::create(['start_time'=> Carbon::now(),
                'user_work_space_id' => $request->activeWorkSpaceId,
                 ]);
            return redirect()->action('WorkTimesController@index');
        }
   }

    public function destroy(Request $request)
    {
        $incompleteWorkTime = UserWorkSpace::find($request->activeWorkSpaceId)
            ->incompleteWorkTimes()
            ->first();

        if (! $incompleteWorkTime) {
            return redirect()->back();
        }

        $incompleteWorkTime->ends();

        return redirect()->action('WorkTimesController@index');
    }
}
