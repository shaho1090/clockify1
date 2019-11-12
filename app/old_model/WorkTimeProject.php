<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkTimeProject extends Model
{
    public $incrementing = true;
    protected $table = 'work_time_project';
    protected $fillable = ['work_time_id', 'project_id'];


}
