<?php

namespace App\Policies;

use App\User;
use App\UserWorkSpace;
use App\WorkSpace;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkSpacePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any work spaces.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the work space.
     *
     * @param \App\User $user
     * @param \App\WorkSpace $workSpace
     * @return mixed
     */
    public function view(User $user, WorkSpace $workSpace)
    {
        //
    }

    /**
     * Determine whether the user can create work spaces.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the work space.
     *
     * @param \App\User $user
     * @param \App\WorkSpace $workSpace
     * @return mixed
     */
    public function update(User $user, WorkSpace $workSpace)
    {
        //
    }

    /**
     * Determine whether the user can delete the work space.
     *
     * @param \App\User $user
     * @param \App\WorkSpace $workSpace
     * @return mixed
     */
    public function delete(User $user, WorkSpace $workSpace)
    {
        //return $user->id === $post->user_id;
        if ($user->isOwnerOf($workSpace)) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the work space.
     *
     * @param \App\User $user
     * @param \App\WorkSpace $workSpace
     * @return mixed
     */
    public function restore(User $user, WorkSpace $workSpace)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the work space.
     *
     * @param \App\User $user
     * @param \App\WorkSpace $workSpace
     * @return mixed
     */
    public function forceDelete(User $user, WorkSpace $workSpace)
    {
        if ($user->isOwnerOf($workSpace)) {
            return true;
        }
    }
}
