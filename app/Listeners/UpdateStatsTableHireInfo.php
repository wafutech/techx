<?php

namespace App\Listeners;

use App\Events\FreelancerHired;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateStatsTableHireInfo
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
     * @param  FreelancerHired  $event
     * @return void
     */
    public function handle(FreelancerHired $event)
    {
        //
    }
}
