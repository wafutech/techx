<?php

namespace App\Listeners;

use App\Events\ProposalShortListed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;
use App\Job;
use App\Freelancer;
use App\Proposal;

class ProposalShortListedListener
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
     * @param  ProposalShortListed  $event
     * @return void
     */
    public function handle(ProposalShortListed $event)
    {
        $proposal = Proposal::where('id',$event->id)->first();
        $job = Job::where('id',$proposal->job_id)->first();

        $freelancer = Freelancer::where('id',$proposal->freelancer_id)->first();
       
        //Update the proposals table

        DB::update('update proposals set proposal_status=? where freelancer_id =? and  id=?',['shortlisted',$proposal->freelancer_id,$proposal->id]);
    }
}
