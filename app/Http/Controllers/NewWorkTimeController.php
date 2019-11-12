<?php

namespace App\Http\Controllers;


use App\UserWorkSpace;
use App\WorkTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class NewWorkTimeController extends Controller
{

    public function store()
    {
        $activeWorkSpace = Auth::user()->activeWorkSpace();

        $incompleteWorkTime =UserWorkSpace::find($activeWorkSpace->id)
            ->incompleteWorkTimes()
            ->first();

        if (! $incompleteWorkTime) {
           WorkTime::create(['start_time'=> Carbon::now(),
               'user_work_space_id' => $activeWorkSpace->id,
                ]);
            return redirect()->action('WorkTimesController@index');
        }
   }

    public function update(Request $request, $id)
    {


        return redirect()->action('WorkTimesController@index');
    }

    public function destroy(Request $request)
    {
        $activeWorkSpace = Auth::user()->activeWorkSpace();

        $incompleteWorkTime = UserWorkSpace::find( $activeWorkSpace->id)
            ->incompleteWorkTimes()
            ->first();

        if (! $incompleteWorkTime) {
            return redirect()->back();
        }

//        if ($request->get('selectProject')) {
//            $incompleteWorkTime->projects()->attach($request->get('selectProject'));
//        }
//        Auth::user()->workSpaces()->attach( $workSpace->id,['access' => 0,
//            'active' =>true

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
