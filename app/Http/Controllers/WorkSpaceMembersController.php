<?php

namespace App\Http\Controllers;

use App\Invitee;
use App\User;
use App\UserWorkSpace;
use App\WorkSpace;
use App\WorkTime;
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
        $invitees = Auth::user()->activeWorkSpace()//WorkSpace::find($activeWorkSpace->id)
            ->invitees()
            ->get();

        return view('members.index', [
            'members' => Auth::user()->activeWorkSpace()->users()->get(),
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        request()->validate([
//            'email' => 'required|email'
//        ]);
//
//        $user = User::where('email', $request->get('email'))->get()->first();
//        if ($user) {
//            $user->workSpaces()->attach(Auth::user()->activeUserWorkSpace()->work_space_id, ['access' => 2,
//                'active' => false
//            ]);
//
//            return redirect(route('members.index'))->with('status', 'ایمیل مورد نظر به تیم اضافه شد!');
//        }
//
//         return redirect(route('invitees.store',[$request]));
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
     * @param User $user
     * @return void
     */
    public function destroy(User $member)
    {
        $userWorkSpace = UserWorkSpace::where('user_id','=',$member->id)
            ->where('work_space_id','=',Auth::user()->activeWorkSpace()->id)->get()->first();

        $userWorkSpace->workTimes()->delete();

        $member->workSpaces()->detach(Auth::user()->activeWorkSpace()->id);

        return redirect(route('members.index'))->with('status','عضو مورد نظر به همراه انجام کارهای وی از این فضای کاری حذف شد!');
    }
}
