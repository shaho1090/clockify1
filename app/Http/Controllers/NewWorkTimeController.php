<?php

namespace App\Http\Controllers;

use App\UserProject;
use App\UserWorkSpace;
use App\Work;
use App\WorkTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NewWorkTimeController extends Controller
{

    public function store(UserWorkSpace $activeWorkSpace,Request $request)
    {
        $incompleteWorkTime = $activeWorkSpace->incompleteWorkTimes()->first();
        if (! $incompleteWorkTime) {
           WorkTime::create(['start_time'=> Carbon::now(),
                'work_space_id' => $activeWorkSpace->id,
                 ]);
            return redirect()->action('WorkTimesController@index');
        }
   }

    public function destroy(UserWorkSpace $activeWorkSpace,Request $request)
    {
        $incompleteWorkTime = $activeWorkSpace->incompleteWorkTimes()->first();

        if (! $incompleteWorkTime) {
            return redirect()->back();
        }

        $incompleteWorkTime->ends();

        return redirect()->action('WorkTimesController@index');
    }
}
