<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Invitee extends Model
{
    protected $fillable = ['work_space_id','token','email'];

    public function workSpaces()
    {
        return $this->belongsToMany(WorkSpace::class,'work_space_invitee')
            ->withPivot('token');
    }

    public function remove()
    {
//        WorkSpace::find(Auth::user()->activeUserWorkSpace()->work_space_id)
//            ->invitees()
//            ->detach($this->id);
        dd($this->workSpaces()->count());
    }

}
