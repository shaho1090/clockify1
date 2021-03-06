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

        $incompleteWorkTime = Auth::user()
            ->incompleteWorkTimes()
            ->first();

        if (! $incompleteWorkTime) {
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

        $incompleteWorkTime = Auth::user()
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
