<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Auth;

class UserWorkSpace extends pivot
{
    public $incrementing = true;
    protected $table = 'user_work_space';
    protected $fillable = ['user_id', 'work_space_id', 'access', 'active' ];

    public function workTimes()
    {
        return $this->hasMany(WorkTime::class,'user_work_space_id','id');
    }

//    public function projects()
//    {
//        return $this->hasMany(Project::class,'user_work_space_id','id');
//    }

//    public function tags()
//    {
//        return $this->hasMany(Tag::class,'user_work_space_id','id');
//    }

    public function user()
    {
        return $this->belongsTo(User::class,'user','id');
    }

    public function workSpace()
    {
        return $this->belongsTo(WorkSpace::class,'work_space_id','id');
    }

//    public function invitees()
//    {
//        return $this->hasMany(Invitee::class,'work_space_id','id');
//    }

   public function incompleteWorkTimes()
    {
        return $this->workTimes()->whereNull('stop_time');
    }

  public function completeWorkTimes()
      {
          return $this->workTimes()->whereNotNull('stop_time');
      }

    public function members()
    {
        return WorkSpace::find($this->id)->users()->get();
    }

//    public function invitees()
//    {
//        return Invitee::where('work_space_id',$this->id)->get();
//    }

}
