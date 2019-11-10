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

//    public function workTimes()
//    {
//        return $this->hasMany(WorkTime::class,'work_space_id','id');
//    }

}
