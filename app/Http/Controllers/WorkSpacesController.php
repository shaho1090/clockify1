<?php

namespace App\Http\Controllers;

use App\UserWorkSpace;
use App\WorkSpace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkSpacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workSpaces = Auth::user()->workSpaces()->get();

        return view('work-spaces.index', [
            'workSpaces' => $workSpaces,
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
        Auth::user()->workSpaces()
            ->create([
                'title' => $request->get('title')
            ]);

        return redirect(route('work-spaces.index'))
            ->with('status', 'محیط کاری جدید ایجاد شد!');
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
     * @param WorkSpace $workSpace
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(WorkSpace $workSpace, Request $request)
    {
        $workSpace->update(['title' => $request->get('title')]);

        return redirect()->action('WorkSpacesController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkSpace $workSpace
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(WorkSpace $workSpace)
    {
        if ($workSpace->isActive()) {
            return redirect()->action('WorkSpacesController@index')
                ->with('warning', 'برای حذف این محیط کاری ابتدا آنرا از حالت فعال خارج کنید!');
        }

        $workSpace->removeAllDependency();

        $workSpace->delete();

        return redirect()->action('WorkSpacesController@index');
    }
}
