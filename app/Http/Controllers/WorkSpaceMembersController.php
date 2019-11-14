<?php

namespace App\Http\Controllers;

use App\Invitee;
use App\UserWorkSpace;
use App\WorkSpace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkSpaceMembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeWorkSpace = Auth::user()->activeWorkSpace();

        $members =  WorkSpace::find($activeWorkSpace->id)->users()->get();
        $invitees = Invitee::find($activeWorkSpace->work_space_id)->get();

        return view('members.index', [
            'members' => $members,
            'invitees' => $invitees,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $email = $request->get('email');
        if (Invitee::where('email', $email)->first()){
            return redirect('/work-space/members/index')->with('status', 'دعوت نامه برای این ایمیل قبلا ارسال شده است!');
        }

        $workSpaceId = Auth::user()->activeWorkSpace()->work_space_id;
        $uniqId = uniqid();
        Invitee::create([
            'email' => $request->get('email'),
            'token' => $uniqId,
            'work_space_id' => $workSpaceId,
        ]);

        return redirect('/work-space/members/index')->with('status', 'ایمیل دعوت نامه ارسال شد');

//        $data = array(
//            'workSpaceId' => $workSpaceId,
//            'uniqid' => $request->get('project_id'),
//            'email' => $request->get('email'),
//        );
//        Mail::send( 'contributors/welcome',$data, function ($message) use ($email) {
//            $message->from('laravelshaho@gmail.com', 'project manager');
//            $message->to( $email)->subject('دعوت به همکاری در پروژه');
//        });
//        return "Your email has been sent successfully";
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
