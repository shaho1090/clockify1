<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['user_id','title'];

    public function users()
    {
        return $this->belongsToMany(User::class,'user_project')->withPivot('access','id');
    }

}


