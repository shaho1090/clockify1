<?php

namespace App\Http\Controllers;

use App\Invitee;
use App\Project;
use App\WorkSpace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InitialWorkSpaceController extends Controller
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
    public function store()
    {
        /**
         * @workSpacesInvited = work spaces from invitees table that demonstrate user invited for them
         */

        if (Auth::user()->invitation()) {
            foreach (Auth::user()->invitation()->workSpaces()->get() as $workSpace) {
                Auth::user()->workSpaces()->attach($workSpace->id, ['access' => 2,
                    'active' => false
                ]);
                $workSpace->active();
            }

            Auth::user()->invitation()->remove();

            return redirect('/home');//->action('NewMemberController@store');
        }

        $workSpace = WorkSpace::create(['title' => Auth::user()->name]);

        Auth::user()->workSpaces()->attach($workSpace->id, ['access' => 0,
            'active' => true
        ]); // zero means owner access

        return redirect('/home');
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
