<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
 {
    protected $fillable = ['title', 'project_id','access' ];

  /*  public function userProject()
    {
        return $this->belongsTo(UserProject::class,'user_project_id');
    }

    public function works()
    {
        return $this->hasMany(Work::class);
    }*/
}
