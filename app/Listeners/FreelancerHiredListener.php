<?php

namespace App\Listeners;

use App\Events\FreelancerHired;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Mail\FreelancerHiredMail;
use DB;
use App\Job;

class FreelancerHiredListener
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
        
            DB::update('update proposals set proposal_status=? where job_id =?',['closed',$event->proposal->job_id]);


        $freelancers = DB::table('proposals')
                    ->join('freelancers',$event->proposal->freelancer_id)
                    ->join('users','freelancers.user_id','freelancers.user_id','users.id')
                    ->where('proposals.job_id',$event->proposal->job_id)
                    ->where('proposals.freelancer_id','!=',$event->proposal->freelancer_id)
                    ->where('proposals.proposal_status','closed')
                    ->get();
        $job = Job::where('id',$event->proposal->job_id)->first();



        if($freelancers)
        {
            //Loop through the lost freelancers and notify them that the job was closed
            foreach($freelancers as $freelancer)
            {
        $available_jobs = Job::where('main_skill_id',$freelancer->main_skill_id)->take(5)->get();

        Mail::to($freelancer->email)->send(new FreelancerHiredMail($freelancer,$job,$available_jobs));


            }
        }

    

    }
}
