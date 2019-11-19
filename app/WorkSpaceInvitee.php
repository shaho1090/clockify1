<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class WorkSpaceInvitee extends Pivot
{
    public $incrementing = true;
    protected $table = 'work_space_invitee';
    protected $fillable = ['work_space_id', 'invitee_id' ];
}
