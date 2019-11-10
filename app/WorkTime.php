<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class WorkTime extends Model
{
    protected $fillable = ['user_work_space_id','start_time','stop_time','billable','title','project_id'];

    public function userWorkSpace()
    {
        return $this->belongsTo(UserWorkSpace::class);
    }

    public function scopeIncomplete($query)
    {
        $query->whereNull('stop_time');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class,'work_time_project')
            ->withPivot('id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'work_time_tag')
            ->withPivot('id');
    }

    public function ends()
    {
        $this->update([
            'stop_time' => Carbon::now()
        ]);
    }
}
