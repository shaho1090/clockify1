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

    public function invitees()
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
//    public function workTimes()
//    {
//        return $this->hasMany(WorkTime::class,'work_space_id','id');
//    }

}
