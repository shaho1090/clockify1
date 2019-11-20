<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Invitee extends Model
{
    protected $fillable = ['work_space_id', 'token', 'email'];

    public function workSpaces()
    {
        return $this->belongsToMany(WorkSpace::class, 'work_space_invitee')
            ->withPivot('token');
    }

    public function detachFromActiveWorkSpace()
    {
        $this->workSpaces()
            ->detach(Auth::user()
                ->activeUserWorkSpace()
                ->work_space_id);
        return $this->removeIfNotUsed();
    }

    public function removeIfNotUsed()
    {
        if ($this->workSpaces()->doesntExist()) {
            $this->delete();
        }
    }

    public function attachToActiveWorkSpace()
    {
        if ($this->isNotAttached()) {
            return $this->workSpaces()
                ->attach(Auth::user()
                    ->activeUserWorkSpace()
                    ->work_space_id, ['token' => uniqid()
                ]);
        }
    }

    public function isNotAttached()
    {
        if (!$this->workSpaces()
            ->find(Auth::user()
                ->activeUserWorkSpace()
                ->work_space_id)) {
            return $this;
        }
    }

}
