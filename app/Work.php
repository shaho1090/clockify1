<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
   protected $fillable = ['user_project_id','start_time','stop_time','billable'];
    public function user()
    {
       // return $this->()
    }
}
