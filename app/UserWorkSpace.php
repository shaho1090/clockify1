<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserWorkSpace extends pivot
{
    public $incrementing = true;
    protected $table = 'user_work_space';
    protected $fillable = ['user_id',  'work_space_id','access', 'active' ];



}
