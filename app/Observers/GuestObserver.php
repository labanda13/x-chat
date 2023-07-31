<?php

namespace App\Observers;

use App\Models\Guest;
use App\Models\Room;

class GuestObserver
{
    /**
     * Handle saved event
     *
     * @param Guest $guest
     */
    public function saved(Guest $guest)
    {

    }

    /**
     * Handle the Guest "created" event.
     *
     * @param  \App\Models\Guest  $guest
     * @return void
     */
    public function created(Guest $guest)
    {
        //
    }

    /**
     * Handle the Guest "updated" event.
     *
     * @param  \App\Models\Guest  $guest
     * @return void
     */
    public function updated(Guest $guest)
    {
        //
    }

    /**
     * Handle the Guest "deleted" event.
     *
     * @param  \App\Models\Guest  $guest
     * @return void
     */
    public function deleted(Guest $guest)
    {
        //
    }

    /**
     * Handle the Guest "restored" event.
     *
     * @param  \App\Models\Guest  $guest
     * @return void
     */
    public function restored(Guest $guest)
    {
        //
    }

    /**
     * Handle the Guest "force deleted" event.
     *
     * @param  \App\Models\Guest  $guest
     * @return void
     */
    public function forceDeleted(Guest $guest)
    {
        //
    }
}
