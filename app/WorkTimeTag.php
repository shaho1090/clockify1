<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkTimeTag extends Model
{
    use softDeletes;

    public $incrementing = true;
    protected $table = 'work_time_tag';
    protected $fillable = ['work_time_id','tag_id'];
}
