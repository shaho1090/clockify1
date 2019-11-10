<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class WorkTime extends Model
{
    protected $fillable = ['start_time','stop_time','billable','title','project_id'];

    public function userWorkSpace()
    {
        return $this->belongsTo(UserWorkSpace::class);
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
