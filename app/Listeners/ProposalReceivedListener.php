<?php

namespace App\Listeners;

use App\Events\ProposalReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Mail\ProposalReceivedMail;
use App\Proposal;
use App\Job;
use App\Freelancer;
use App\HireManager;
use App\User;
use Auth;

class ProposalReceivedListener
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
     * @param  ProposalReceived  $event
     * @return void
     */
    public function handle(ProposalReceived $event)
    {
        $proposal = Proposal::where('id',$event->proposal)->first();
        $job = Job::where('id',$proposal->job_id)->first();
        $freelancer = Freelancer::where('user_id',Auth::User()->id)->first();
        $freelancer = User::where('id',$freelancer->user_id)->first();

        $employer = HireManager::where('id',$job->hire_manager_id)->first()->user_id;
        $user = User::where('id',$employer)->first();

            Mail::to($user->email)->send(new ProposalReceivedMail($user,$job,$freelancer,$proposal));

    }
}
