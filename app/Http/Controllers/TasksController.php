<?php

namespace App\Http\Controllers;

use App\UserProject;
use App\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TasksController extends Controller
{
    public function store(UserProject $contributor,Request $request)
    {
        $incompletedWork = $contributor->incompletedWorks()->first();
        if (! $incompletedWork) {
           Work::create(['start_time'=> Carbon::now(),
                'user_project_id' => $contributor->id,
                 ]);
            return redirect()->action('UserProjectWorksController@index',['project' => $request->project_id]);
        }
   }

    public function destroy(UserProject $contributor,Request $request)
    {
        $incompletedWork = $contributor->incompletedWorks()->first();

        if (! $incompletedWork) {
            return redirect()->back();
        }

        $incompletedWork->ends();

        return redirect()->action('UserProjectWorksController@index',['project' => $request->project_id]);
    }
}
