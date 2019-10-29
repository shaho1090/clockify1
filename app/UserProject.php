<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserProject extends Pivot
{
    public $incrementing = true;
    protected $table = 'user_project';
    protected $fillable = ['user_id',  'project_id','access' ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function works()
    {
        return $this->hasManyThrough(
            Work::class,
            Task::class,
            'user_project_id',// Foreign key on tasks table...
            'task_id', // Foreign key on work_times table...
            'id', // Local key on user_project table...
            'id' // Local key on tasks table...
            );
    }

}
        /*return $this->hasManyThrough(
         'App\Post',
         'App\User',
         'country_id', // Foreign key on users table...
         'user_id', // Foreign key on posts table...
         'id', // Local key on countries table...
         'id' // Local key on users table...
       );*/
