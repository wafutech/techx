<?php

namespace App\Listeners;

use App\Events\JobPosted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;
use App\Stat;
use App\HireManager;
use App\Job;

class UpdateStatsTable
{
  

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    
    }

    /**
     * Handle the event.
     *
     * @param  JobPosted  $event
     * @return void
     */
    public function handle(JobPosted $event)
    {
        $update = new Stat;
        $update->hire_manager_id = $event->hire_manager_id;
        $update->job_id = $event->job_id;
        $update->save();
    }
}
