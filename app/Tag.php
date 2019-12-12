<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use softDeletes;
    protected $fillable = ['work_space_id','title'];

    public function workTimes()
    {
        return $this->belongsToMany(WorkTime::class,'work_time_tag')
            ->withPivot('id');
    }

}


