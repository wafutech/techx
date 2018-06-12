<?php

namespace App\Listeners;

use App\Events\MessagingEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\MessagingMailer;
use App\Job;
use App\Proposal;
use App\Message;
use Mail;



class MessagingEventListener
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
     * @param  MessagingEvent  $event
     * @return void
     */
    public function handle(MessagingEvent $event)
    {
        $message = Message::where('id',$event->messageid)->first()->toArray();

        $job = Proposal::where('id',$message['proposal_id'])->first()->job_id;
        $job = Job::where('id',$job)->first();
        $message = collect($message);
      $message_id = $message['id'];
        Mail::to($event->freelancer->email)->send(new MessagingMailer($event->freelancer,$job,$message,$message_id));
    }
}
