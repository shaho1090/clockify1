<?php

namespace App\Http\Controllers;

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
        $activeUserWorkSpace = Auth::user()->activeUserWorkSpace();

        $incompleteWorkTime = $activeUserWorkSpace
            ->incompleteWorkTimes()
            ->first();

        if (! $incompleteWorkTime) {
            $activeUserWorkSpace->workTimes()
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
        $activeUserWorkSpace = Auth::user()->activeUserWorkSpace();

        $incompleteWorkTime = $activeUserWorkSpace
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
