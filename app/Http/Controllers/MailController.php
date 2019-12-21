<?php

namespace App\Http\Controllers;

use App\Invitee;
use App\Mail\InviteMail;
use App\WorkSpace;
use App\WorkSpaceInvitee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PharIo\Manifest\Email;

class MailController extends Controller
{
    const ACCESS_OWNER = 0;
    const ACCESS_INVITEE = 2;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param Invitee $invitee
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Invitee $invitee)
    {
        $activeWorkSpace = Auth::user()->activeWorkSpace();
//          $data = array(
//          'workSpaceId' => $activeUserWorkSpace->id,
//          'email' => $invitee->email,
//      );
//       Mail::send( 'members.invite',$data, function ($message) use ($invitee){
//          $message->from('laravelshaho@gmail.com', 'project manager');
//          $message->to( $invitee->email)->subject('دعوت به همکاری در پروژه');
//      });

        Mail::to($invitee->email)->send(new InviteMail($activeWorkSpace, $invitee->email));

        return redirect(route('members.index'))->with('status', 'ایمیل دعوت نامه با موفقیت ارسال شد!');

//        Mail::send( 'members.welcome',$data, function ($message) {
//            $message->from('laravelshaho@gmail.com', 'Learning Laravel');
//            $message->to('shaho.sanandaji@gmail.com')->subject('Learning Laravel test email');
//        });
    }

    /**
     * Display the specified resource.
     *
     * @param WorkSpace $workSpace
     * @param $email
     * @return void
     */
    public function show(WorkSpace $workSpace)
    {

        if (!Auth::user()->invitation()) {
            return redirect('/home');
        }

        if ($workSpace->users()->find(Auth::user())) {
            return redirect(route('work-spaces.index'))->with('status', 'شما هم اکنون عضو این فضای کاری هستید');
        }

        if (WorkSpaceInvitee::where('work_space_id', '=', $workSpace->id)->get()) {

            Auth::user()->workSpaces()->attach($workSpace->id, ['access' => self::ACCESS_INVITEE]);
            $workSpace->activate();
            Auth::user()->invitation()->remove();

            return redirect(route('work-spaces.index'))->with('status', 'از شما بابت قبول دعوت نامه تشکر می کنیم!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param WorkSpace $workSpace
     * @param $email
     * @return void
     */
    public function edit(WorkSpace $workSpace, $email)
    {
        //dd($workSpace.$email);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
