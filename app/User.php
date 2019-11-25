<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /*
    *many to many relationship with pivot table user_work_space
    */
    public function workSpaces()
    {
        return $this->belongsToMany(WorkSpace::class, 'user_work_space')
            ->withPivot('access', 'id', 'active');
    }

    public function userWorkSpaces()
    {
        return $this->hasMany(UserWorkSpace::class, 'user_id', 'id');
    }

    public function activeWorkSpace()
    {
        return $this->workSpaces()->wherePivot('active', '=', true)->first();
    }

    public function workTimes()
    {
        return $this->hasManyThrough(
            WorkTime::class,
            UserWorkSpace::class,
            'user_id',// Foreign key on user_project table...
            'user_work_space_id', // Foreign key on works table...
            'id', // Local key on user_project table...
            'id' // Local key on tasks table...
        );
    }

    public function scopeInvited()
    {
        return Invitee::where('email', $this->email)->get();
    }

    public function completeWorkTimes()
    {
        return $this->workTimes()->whereNotNull('stop_time');
    }

    public function incompleteWorkTimes()
    {
        return $this->workTimes()->whereNull('stop_time');
    }

    public function createNewWorkTime()
    {
        return UserWorkSpace::where('user_id',$this->id)
            ->workTimes()
            ->create(['start_time',Carbon::now()]);
    }
}
