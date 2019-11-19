<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WorkSpace extends Model
{
    protected $fillable = ['title'];

    public function users()
    {
        return $this->belongsToMany(User::class,'user_work_space')
             ->withPivot('access','id','active');
    }

    public function workTimes()
    {
        return $this->hasManyThrough(
            WorkTime::class,
            UserWorkSpace::class,
            'work_space_id',// Foreign key on user_project table...
            'user_work_space_id', // Foreign key on works table...
            'id', // Local key on user_project table...
            'id' // Local key on tasks table...
        );
    }

    public function projects()
    {
        return $this->hasManyThrough(
            WorkTime::class,
            UserWorkSpace::class,
            'work_space_id',// Foreign key on user_project table...
            'user_work_space_id', // Foreign key on works table...
            'id', // Local key on user_project table...
            'id' // Local key on tasks table...
        );
    }

    public function tags()
    {
        return $this->hasManyThrough(
            WorkTime::class,
            UserWorkSpace::class,
            'work_space_id',// Foreign key on user_project table...
            'user_work_space_id', // Foreign key on works table...
            'id', // Local key on user_project table...
            'id' // Local key on tasks table...
        );
    }

//    public function invitees()
//    {
//        return $this->hasManyThrough(
//            WorkTime::class,
//            UserWorkSpace::class,
//            'work_space_id',// Foreign key on user_project table...
//            'work_space_id', // Foreign key on works table...
//            'id', // Local key on user_project table...
//            'id' // Local key on tasks table...
//        );
//    }

    public function isOwner(WorkSpace $workSpace)
    {
        return Auth::user()->workSpaces()->find($this->id)->pivot->access;
    }

    public function isActive()
    {
        return Auth::user()->workSpaces()->find($this->id)->pivot->active;
    }

    public function removeAllDependency()
    {
        $this->workTimes()->delete();
        $this->projects()->delete();
        $this->tags()->delete();
        $this->users()->detach();
        $this->invitees()->detach();

    }

    public function Invitees()
    {
        return $this->belongsToMany(Invitee::class,'work_space_invitee')
            ->withPivot('token');
    }

    public function removeInvitee(Invitee $invitee)
    {

    }



//    public function incompleteWorkTimes()
//    {
//        return $this->workTimes()->incomplete();
//    }
//
//    public function completeWorkTimes()
//    {
//        return $this->workTimes()->complete();
//    }

}
