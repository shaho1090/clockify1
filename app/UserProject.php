<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Work;

class UserProject extends Pivot
{
    public $incrementing = true;
    protected $table = 'user_project';
    protected $fillable = ['user_id',  'project_id','access' ];

    public function works()
    {
        return $this->hasMany(Work::class,'user_project_id');
    }

   /* public function tasks()
    {
        return $this->hasMany(Task::class);
    }*/
   /*public function works()
    {
        return $this->hasManyThrough(
            Work::class,
            Task::class,
            'user_project_id',// Foreign key on tasks table...
            'task_id', // Foreign key on work_times table...
            'id', // Local key on user_project table...
            'id' // Local key on tasks table...
            );
    }*/
//    public function scopeId($query,$project_id)
//    {
//        $user = Auth::user();
//        $user_project_id = $user
//            ->userProjects()
//            ->where('project_id',$project->id);
//
//        return $user_project_id;
//    }

    public function scopeContributor($query, $userId, $projectId)
    {
        return $query->where('user_id', $userId)
            ->where('project_id', $projectId);
    }

}

