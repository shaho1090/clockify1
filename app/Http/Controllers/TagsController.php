<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagFormRequest;
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
        $tags = Auth::user()->activeWorkSpace()->tags()
            ->orderby('id', 'asc')
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagFormRequest $request)
    {
        Auth::user()->activeWorkSpace()->tags()
            ->create(['title' => $request->get('title')]);

        return redirect(route('tags.index'));
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
     * @param Tag $tag
     * @param Request $request
     * @return void
     */
    public function update(Tag $tag, TagFormRequest $request)
    {
        $tag->update(['title' => $request->get('title')]);

        return redirect()->action('TagsController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $tag
     * @return void
     * @throws \Exception
     */
    public function destroy(Tag $tag)
    {
         $tag->workTimes()->delete();

         $tag->delete();

        return redirect()->route('tags.index');
    }
}
