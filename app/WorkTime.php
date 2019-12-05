<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkTime extends Model
{
    use softDeletes;

    protected $fillable = ['user_work_space_id','start_time','stop_time','billable','title','project_id'];

    public function userWorkSpace()
    {
        return $this->belongsTo(UserWorkSpace::class);
    }

    public function scopeIncomplete($query)
    {
        $query->whereNull('stop_time');
    }

    public function scopeComplete($query)
    {
        $query->whereNotNull('stop_time');
    }

   public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'work_time_tag')
            ->withPivot('id');
    }

    public function complete()
    {
        $this->update([
            'stop_time' => Carbon::now()
        ]);
    }
}
