<?php

namespace App;

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
        return $this->hasMany(UserWorkSpace::class,'user_id','id');
    }

    public function activeUserWorkSpace()
    {
          return $this->userWorkSpaces()->where('active','=',true)->first();
    }

    public function setWorkSpaceActive(WorkSpace $workSpace)
    {
        UserWorkSpace::find($this->id)->where('work_space_id',$workSpace->id)->update(['active' => true]);

        return $this->setWorkSpacesInActive($workSpace);
    }

    public function setWorkSpacesInActive(WorkSpace $activeWorkSpace)
    {
        $userWorkSpaces = UserWorkSpace::where('user_id',$this->id)->get()->all();

        foreach( $userWorkSpaces as $userWorkSpace) {
            if ($userWorkSpace->work_space_id !== $activeWorkSpace->id) {
                $userWorkSpace->update(['active' => false]);
            }
        }

        return redirect()->action('WorkSpacesController@index');
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
}
