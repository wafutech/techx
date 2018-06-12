<?php

namespace App\Listeners;

use App\Events\ProposalReview;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Proposal;
use App\Freelancer;
use DB;
use Mail;
use App\Mail\ProposalDeclined;
use App\Job;

class ProposalDeclinedListener
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
     * @param  ProposalReview  $event
     * @return void
     */
    public function handle(ProposalReview $event)
    {
        $proposal = Proposal::where('id',1)->first();
        $job = Job::where('id',$proposal->job_id)->first();

        $freelancer = Freelancer::where('id',$proposal->freelancer_id)->first();
       
        //Update the proposals table

        DB::update('update proposals set proposal_status=? where freelancer_id =? and id=?',['declined',$proposal->freelancer_id,$proposal->id]);

        //Send notification to the user 

         $user = DB::table('users')
                    ->join('userprofiles','user_id','users.id','userprofiles.user_id')
                    ->where('users.id',$freelancer->user_id)->first();
        //retrieve five jobs that match the skills of the freelancer

            $jobs = Job::where('main_skill_id',$freelancer->main_skill_id)->take(5)->get();
                   
           // $to ='okoaproject2007@gmail.com';

    Mail::to($user->email)->send(new ProposalDeclined($user,$job,$jobs));




    }
}
