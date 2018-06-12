<?php

namespace App\Listeners;

use App\Events\AnswerPostedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AnswerPostedEventListener
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
     * @param  AnswerPostedEvent  $event
     * @return void
     */
    public function handle(AnswerPostedEvent $event)
    {
        //
    }
}
