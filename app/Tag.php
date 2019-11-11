<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['user_work_space_id','title'];

    public function workTimes()
    {
        return $this->belongsToMany(WorkTime::class,'work_time_tag')
            ->withPivot('id');
    }

}


