<?php

namespace App\Http\Controllers;

use App\Invitee;
use App\WorkSpace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InviteesController extends Controller
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'email' => 'required|email'
        ]);
        // $uniqId = uniqid(); //bcrypt() . time();
        $invitee = Invitee::where('email', $request->get('email'))->first();
        if ($invitee) {
            return redirect(route('members.index'))
                ->with('status', 'این ایمیل قبلا در لیست ارسال ثبت شده است!');
        }

        $invitee = Invitee::create([
            'email' => $request->get('email'),
        ]);
        $invitee->attachToActiveWorkSpace();


        return redirect(route('members.index'))->with('status', 'ایمیل دعوت نامه برای ارسال ذخیره شد!');

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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
     * @param Invitee $invitee
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Invitee $invitee)
    {
        $invitee->detachFromActiveWorkSpace();

        return redirect(route('members.index'))->with('status', 'لغو دعوت نامه انجام شد!');
    }
}
