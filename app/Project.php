<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use softdeletes;

    protected $fillable = ['work_space_id','title'];

    public function userWorkSpace()
    {
        return $this->belongsTo(WorkSpace::class);
    }

    public function workTimes()
   {
       return $this->hasMany(WorkTime::class,'project_id');
   }

//    public function tasks()
//    {
//        return $this->hasMany(Task::class,'task_id','id');
//    }




//
//    public function works()
//    {
//         return $this->hasManyThrough(
//                Work::class,
//                UserProject::class,
//                'project_id',// Foreign key on user_project table...
//                'user_project_id', // Foreign key on works table...
//                'id', // Local key on user_project table...
//                'id' // Local key on tasks table...
//         );
//    }
//    public function invites()
//    {
//        $this->hasMany(Invite::class);
//    }



}


