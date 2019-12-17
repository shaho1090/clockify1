<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkTimeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class NewWorkTimeController extends Controller
{
    /*
    *
    */
    public function store()
    {
        ///  $activeUserWorkSpace = Auth::user()->activeUserWorkSpace();

        $unCompletedWorkTime = Auth::user()
            ->workTimes()->unCompleted()
            ->first();
        // dd($unCompletedWorkTime);

        if (!$unCompletedWorkTime) {
            Auth::user()->startNewWorkTime();

            return redirect()->action('WorkTimesController@index');
        }
    }

    /*
     *
     */

    public function update(Request $request, $id)
    {

    }

    /*
     * end of the setting time with related project and tags
     * @stop_time
     */

    public function destroy(WorkTimeRequest $request)
    {
        // $activeUserWorkSpace = Auth::user()->activeUserWorkSpace();

        $unCompletedWorkTime = Auth::user()
            ->workTimes()->unCompleted()
            ->first();

        if (!$unCompletedWorkTime) {
            return redirect()->back();
        }

        $unCompletedWorkTime->update([
            'billable' => $request->get('selectBillable'),
            'title' => $request->get('title'),
            'project_id' => $request->get('project_id'),
        ]);

        $tags = $request->get('tags');

        if ($tags) {
            foreach ($tags as $tag) {
                $unCompletedWorkTime->tags()->attach($tag);
            }
        }

        $unCompletedWorkTime->complete();

        return redirect()->action('WorkTimesController@index');
    }
}
