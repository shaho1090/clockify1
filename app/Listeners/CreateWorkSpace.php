<?php

namespace App\Listeners;

use App\User;
use App\WorkSpace;
use App\WorkspaceStates;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateWorkSpace
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {
        try {
            $event->user->addWorkSpace();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception();
        }
    }
}
