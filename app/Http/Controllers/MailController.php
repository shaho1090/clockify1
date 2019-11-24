<?php

namespace App\Http\Controllers;

use App\Invitee;
use App\Mail\InviteMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
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
       $activeUserWorkSpace = Auth::user()->activeUserWorkSpace();
//          $data = array(
//          'workSpaceId' => $activeUserWorkSpace->id,
//          'email' => $invitee->email,
//      );
//       Mail::send( 'members.invite',$data, function ($message) use ($invitee){
//          $message->from('laravelshaho@gmail.com', 'project manager');
//          $message->to( $invitee->email)->subject('دعوت به همکاری در پروژه');
//      });

        Mail::to($invitee->email)->send(new InviteMail());

        return "Your email has been sent successfully";

//        Mail::send( 'members.welcome',$data, function ($message) {
//            $message->from('laravelshaho@gmail.com', 'Learning Laravel');
//            $message->to('shaho.sanandaji@gmail.com')->subject('Learning Laravel test email');
//        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
       dd($request);
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
