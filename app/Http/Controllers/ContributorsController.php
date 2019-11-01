<?php

namespace App\Http\Controllers;

use App\User;
use App\UserProject;
use App\Http\Requests\ContributorFormRequest;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class ContributorsController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $projects = User::find($user_id)->userProjects()->get();
        return view('contributers.index', ['projects' => $projects]);
    }

    public function add($project_id)
    {
        $contributor = new UserProject(array(
            'project_id' => $project_id,
            'contributor' => Auth::user()->id,
        ));
        $contributor->save();

        return redirect('/projects/index')->with('status', 'پروژه جدید ایجاد شد!');
    }
    /*
     *
     */
    public function invite(ContributorFormRequest $request)
    {

        $email = $request->get('email');
        $data = array(
            'project_title' => $request->get('project_title'),
            'project_id' => $request->get('project_id'),
            'email' => $request->get('email'),
        );
        Mail::send( 'contributors/welcome',$data, function ($message) use ($email) {
            $message->from('laravelshaho@gmail.com', 'project manager');
            $message->to( $email)->subject('دعوت به همکاری در پروژه');
        });
        return "Your email has been sent successfully";
    }
   /*
    *
    */


}
