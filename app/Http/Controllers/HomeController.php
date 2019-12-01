<?php

namespace App\Http\Controllers;

use App\WorkSpace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //dd(Auth::user()->workSpaces()->get());
        if (!Auth::user()->workSpaces()->get()->first()) {
            $workSpace = WorkSpace::create(['title' => Auth::user()->name]);
            Auth::user()->workSpaces()->attach($workSpace->id, [
                'access' => 0,
                'active' => true,
            ]); // zero means owner access
        }

        return view('home');
    }
}
