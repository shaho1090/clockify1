<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkFormRequest;
use App\UserProject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class WorksController extends Controller
{
    public function index($project_id)
    {
        $user_id = Auth::user()->id;
        $works = User::find($user_id)->works()->get()->first();
        $project = DB::table('projects')->where('id',$project_id)->get()->first();
        return view('works.index', [
          'works' => $works,
          'project_title' => $project->title,
         ]);
   }
   public function doWork($project_id)
   {

   }
    public function setWork(WorkFormRequest $request)
    {

    }

}
