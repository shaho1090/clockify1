<?php

namespace App\Http\Controllers;


use App\UserWorkSpace;
use App\WorkTime;
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
        $activeWorkSpace = Auth::user()->activeWorkSpace();

        $incompleteWorkTime = $activeWorkSpace
            ->incompleteWorkTimes()
            ->first();

        if (! $incompleteWorkTime) {
            $activeWorkSpace->workTimes()
                ->create(['start_time'=> Carbon::now(),
                 ]);
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

    public function destroy(Request $request)
    {
        $activeWorkSpace = Auth::user()->activeWorkSpace();

        $incompleteWorkTime = $activeWorkSpace
            ->incompleteWorkTimes()
            ->first();

        if (! $incompleteWorkTime) {
            return redirect()->back();
        }

        $incompleteWorkTime->update([
            'billable' => $request->get('selectBillable'),
            'title' =>  $request->get('title'),
            'project_id' =>  $request->get('project_id'),
        ]);

         $tags = $request->get('tags');
         if($tags) {
             foreach ($tags as $tag) {
                 $incompleteWorkTime->tags()->attach($tag);
             }
         }

         $incompleteWorkTime->complete();

        return redirect()->action('WorkTimesController@index');
    }
}
