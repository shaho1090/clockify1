<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkSpace extends Model
{
    use softdeletes;

    protected $fillable = ['title'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_work_space')
            ->withPivot('access', 'id', 'active');
    }

    public function workTimes()
    {
        return $this->hasManyThrough(
            WorkTime::class,
            UserWorkSpace::class,
            'work_space_id',// Foreign key on user_project table...
            'user_work_space_id', // Foreign key on works table...
            'id', // Local key on user_project table...
            'id' // Local key on tasks table...
        );
    }

//    public function projects()
//    {
//        return $this->hasManyThrough(
//            WorkTime::class,
//            UserWorkSpace::class,
//            'work_space_id',// Foreign key on user_project table...
//            'user_work_space_id', // Foreign key on works table...
//            'id', // Local key on user_project table...
//            'id' // Local key on tasks table...
//        );
//    }

//    public function tags()
//    {
//        return $this->hasManyThrough(
//            WorkTime::class,
//            UserWorkSpace::class,
//            'work_space_id',// Foreign key on user_project table...
//            'user_work_space_id', // Foreign key on works table...
//            'id', // Local key on user_project table...
//            'id' // Local key on tasks table...
//        );
//    }

//    public function invitees()
//    {
//        return $this->hasManyThrough(
//            WorkTime::class,
//            UserWorkSpace::class,
//            'work_space_id',// Foreign key on user_project table...
//            'work_space_id', // Foreign key on works table...
//            'id', // Local key on user_project table...
//            'id' // Local key on tasks table...
//        );
//    }


    public function isActive()
    {
         if(Auth::user()->workSpaces()->find($this->id)->pivot->active === 1) {
             return true;
         }
         return false;
    }

    public function removeAllDependency()
    {
        $this->workTimes()->delete();
        $this->projects()->delete();
        $this->tags()->delete();
       // $this->users()->detach();
    //    $this->invitees()->detach();
    }

    public function Invitees()
    {
        return $this->belongsToMany(Invitee::class, 'work_space_invitee')
            ->withPivot('token');
    }

    public function removeInvitee(Invitee $invitee)
    {

    }

    //    public function incompleteWorkTimes()
//    {
//        return $this->workTimes()->incomplete();
//    }
//
//    public function completeWorkTimes()
//    {
//        return $this->workTimes()->complete();
//    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'work_space_id', 'id');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class, 'work_space_id', 'id');
    }

    public static function deActivateAll()
    {
        DB::table('user_work_space')
            ->where('user_id', auth()->id())
            ->update(['active' => false]);
    }

    public function activate()
    {
        static::deActivateAll();

        DB::table('user_work_space')
            ->where('user_id', auth()->id())
            ->where('work_space_id', $this->id)
            ->update(['active' => true]);
    }

    public function scopeWhereActive($query)
    {
        return $query->where('active', '=', true);
    }

//    public function scopeMembers()
//    {
//        //return WorkSpace::find($this->work_space_id)->users();
//        return $this->users();
//    }
}
