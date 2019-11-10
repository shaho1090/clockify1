<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['user_work_space_id','title'];

    public function users()
    {
       return $this->belongsToMany(WorkTime::class,'work_time_project')->withPivot('id');
    }


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


