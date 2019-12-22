<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitee extends Model
{
    use softdeletes;

    protected $fillable = ['work_space_id', 'email'];

    public function workSpaces()
    {
        return $this->belongsToMany(WorkSpace::class, 'work_space_invitee')
            ->withPivot('token');
    }

    public function detachFromActiveWorkSpace()
    {
        $this->workSpaces()
            ->detach(Auth::user()
                ->activeWorkSpace());
        return $this->removeIfNotUsed();
    }

    public function removeIfNotUsed()
    {
        if ($this->workSpaces()->doesntExist()) {
            try {
                $this->delete();
            } catch (\Exception $e) {
            }
        }
    }

    public function attachToActiveWorkSpace()
    {
        if ($this->isNotAttached()) {
            return $this->workSpaces()
                ->attach(Auth::user()
                    ->activeWorkSpace(), ['token' => uniqid()
                ]);
        }
    }

    public function isNotAttached()
    {
        if (!$this->workSpaces()
            ->find(Auth::user()
                ->activeWorkSpace())) {
            return $this;
        }
    }

    public function workSpacesInvited()
    {
        $this->workSpaces()->get();

    }

    public function remove()
    {
        $this->workSpaces()->detach();
        try {
            $this->delete();
        } catch (\Exception $e) {
        }
    }

}
