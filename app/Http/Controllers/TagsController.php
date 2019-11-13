<?php

namespace App\Http\Controllers;

use App\Tag;
use App\UserWorkSpace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeWorkSpace = Auth::user()->activeWorkSpace();

        $tags =  $activeWorkSpace->tags()
            ->orderby('id','asc')
            ->get();

        return view('tags.index', [
            'tags' => $tags,
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
        $activeWorkSpace = Auth::user()->activeWorkSpace();
        $activeWorkSpace->tags()->create(['title' => $request->get('tag_title')]);

        return redirect('/tags/index');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Tag $tag
     * @param $title
     * @return void
     */
    public function update(Tag $tag, $title)
    {
        $tag->update(['title' => $title]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $tag
     * @return void
     */
    public function destroy(Tag $tag)
    {
        Auth::user()->activeWorkSpace()->tags()->where('id',$tag->id)->delete();
    }
}
