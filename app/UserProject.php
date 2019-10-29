<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserProject extends Pivot
{
    public $incrementing = true;
    protected $table = 'user_project';
    protected $fillable = ['user_id',  'project_id','access' ];
}
