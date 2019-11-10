<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkTimeTag extends Model
{
    public $incrementing = true;
    protected $table = 'work_time_tag';
    protected $fillable = ['work_time_id', 'tag_id'];


}
