<?php

namespace App\Listeners;

use App\Events\JobApplicationInvitation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Mail\ProposalInvitationMailer;
use DB;


class JobApplicationInvitationListener
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
     * @param  JobApplicationInvitation  $event
     * @return void
     */
    public function handle(JobApplicationInvitation $event)
    {
        $manager = DB::table('hire_managers') 
                    ->join('users','hire_managers.user_id','users.id','hire_managers.user_id')
                    ->where('hire_managers.id',$event->hire_manager_id)
                    ->first();
        $freelancer = DB::table('freelancers')
                        ->join('users','freelancers.user_id','users.id','freelancers.user_id')
                        ->where('freelancers.id',$event->freelancer_id)
                        ->first();

        $job  = DB::table('jobs')->where('id',$event->job_id)->first();

            Mail::to($freelancer->email)->send(new ProposalInvitationMailer($manager,$freelancer,$job));


           }
}
