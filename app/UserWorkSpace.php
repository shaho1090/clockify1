<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserWorkSpace extends pivot
{
    use softDeletes;

    public $incrementing = true;
    protected $table = 'user_work_space';
    protected $fillable = ['user_id', 'work_space_id', 'access', 'active'];

    public function workTimes()
    {
        return $this->hasMany(WorkTime::class, 'user_work_space_id', 'id');
    }

    public function scopeProjects($query)
    {
        return WorkSpace::find($this->work_space_id)->projects();
    }

    public function scopeTags($query)
    {
        return WorkSpace::find($this->work_space_id)->tags();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function workSpace()
    {
        return $this->belongsTo(WorkSpace::class, 'Work_space_id', 'id');
    }

//    public function invitees()
//    {
//        return $this->hasMany(Invitee::class,'work_space_id','id');
//    }

//   public function incompleteWorkTimes()
//    {
//        return $this->workTimes()->whereNull('stop_time');
//    }

//  public function completeWorkTimes()
//      {
//          return $this->workTimes()->whereNotNull('stop_time');
//      }

    public function scopeMembers()
    {
        return WorkSpace::find($this->work_space_id)->users();
    }

//    public function invitees()
//    {
//        return Invitee::where('work_space_id',$this->id)->get();
//    }

    public function scopeWhereActive($query)
    {
        return $query->where('active', '=', true);
    }

}
