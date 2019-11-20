<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Work extends Model
{
   protected $fillable = ['user_project_id','start_time','stop_time','billable','title'];

    public function user()
    {
       // return $this->()
    }
/*
 * getting last record of user work on the specific project from the works table
 */
    public function lastUserProjectWork($user_project_id)
    {
         $last_user_project_work = $this
             ->where('user_project_id',  $user_project_id)
             ->orderBy('start_time','desc')
             ->first();
         return  $last_user_project_work;
    }

    public function scopeIncomplete($query)
    {
        $query->whereNull('stop_time');
    }

    public function ends()
    {
        $this->update([
            'stop_time' => Carbon::now()
        ]);
    }
}
