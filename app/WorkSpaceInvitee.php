<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkSpaceInvitee extends Pivot
{
    use softDeletes;

    public $incrementing = true;
    protected $table = 'work_space_invitee';
    protected $fillable = ['work_space_id', 'invitee_id','token'];
}
