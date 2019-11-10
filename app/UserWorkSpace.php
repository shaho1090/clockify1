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

    public function projects()
    {
        return $this->hasMany(Project::class,'user_work_space_id','id');
    }

    public function incompleteWorkTimes()
    {
        return $this->workTimes()->incomplete();
    }


}
