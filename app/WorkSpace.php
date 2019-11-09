<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkSpace extends Model
{
    protected $fillable = ['title'];

    public function users()
    {
        return $this->belongsToMany(User::class,'user_work_space')->withPivot('access','id','active');
    }

}
