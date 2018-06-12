<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use App\Proposal;
use App\Freelancer;
use App\HireManager;
use App\Skill;
use App\JobAdditionalQuestion;
use App\ShortList;
use Event;
use App\Events\ProposalReview;
use App\Events\ProposalShortListed;
use App\Events\FreelancerHired;
use App\Hire;
use App\Job;

class ProposalReviewController extends Controller
{
    public function __construct()
    {
    	//Reserve this controller to only authenticated users

    	$this->middleware(['auth']);
    }

    public function viewProposals($id)
    {
    	$hm = HireManager::where('user_id',$id)->first()->id;
        
        $proposals = DB::table('proposals')
                    ->join('jobs','proposals.job_id','jobs.id','proposals.job_id')        
                 ->select(

            DB::raw('job_name'),
             DB::raw('proposals.id'),
             DB::raw('job_id'),
            DB::raw('cover_letter')

            )

        ->where('hire_manager_id',$hm)->get();

    	return $proposals;
    }

    public function reviewProposal($id)

    {
      
        $proposal = DB::table('proposals')
    				->join('jobs','job_id','proposals.job_id','jobs.id')
    				->join('freelancers','freelancer_id','proposals.freelancer_id','freelancers.id')
    				->join('payment_types','proposals.payment_type_id','proposals.payment_type_id','payment_types.id')
    				->join('currencies','jobs.currency_id','jobs.currency_id','currencies.id')
    				->join('expected_durations','proposals.expected_duration_id','expected_durations.id','proposals.expected_duration_id')
    				->join('job_time_commitements','proposals.time_commitment_id','job_time_commitements.id','proposals.time_commitment_id')
    				->join('freelancer_levels','freelancers.experience_level','freelancer_levels.id','freelancers.experience_level')
    				->where('proposals.id',$id)
    				->first();
                  


    	$skill = DB::table('freelancers')
    				->join('skill_categories','main_skill_id','freelancers.main_skill_id','skill_categories.id')->first();
    	$skills = Skill::where('skill_cat_id',$skill->id)->get();

    	
    	$questions = DB::table('freelancer_job_question_answers')
                    ->join('job_additional_questions','freelancer_job_question_answers.job_question_id','job_additional_questions.id','freelancer_job_question_answers.job_question_id')
                    ->where('freelancer_job_question_answers.proposal_id',$id)->get();

    	
    				
    	return view('proposals.reviews.review',['title'=>$proposal->job_name,'proposal'=>$proposal,'skills'=>$skills,'questions'=>$questions,'proposal_id'=>$id]);

    }

    public function shortListFreelancer($id)

    {
    	$proposal = Proposal::where('id',$id)->first();

    	//Check if the freelancer is already shortlisted for the same job
    	$already_shortlisted = ShortList::where('job_id',$proposal->job_id)->where('freelancer_id',$proposal->freelancer_id)->where('proposal_id',$proposal->id)->first();
    	if(!empty($already_shortlisted))
    	{
    		return 'already shortlisted';
    	}
    	$shortlist = new ShortList;
    	$shortlist->job_id = $proposal->job_id;
    	$shortlist ->freelancer_id = $proposal->freelancer_id;
    	$shortlist->proposal_id = $id;
    	$shortlist->save();
    	//Fire and event
    	Event::Fire(new ProposalShortListed($id));

                return 'Added to shortlist';


    }

    public function declineProposal($id)

    {
    	Event::Fire(new ProposalReview($id));

    	return 'The proposal was removed from your review list';

    }

    public function jobShortlists()

    {
        
        $manager = HireManager::where('user_id',Auth::User()->id)->first()->id;
    $shortlists = Job::with('shortlists')->where('hire_manager_id',$manager)->get();

return $shortlists;
    }


    public function hire($id)
    {
        $proposal = Proposal::where('id',$id)->first();
        $hm = HireManager::where('user_id',Auth::User()->id);
        //Save changes
        $hire = new Hire;
        $hire->hire_manager_id = $hm->hire_manager_id;
        $hire->job_id = $proposal->job_id;
        $hire->freelancer_id = $proposal->freelancer_id;
        $hire->save();

        $number_of_freelancers = Job::where('job_id',$proposal->job_id)->first()->freelancers_needed;
        $hires = Hire::where('job_id',$proposal->job_id)->get();
        if(count($hires==$number_of_freelancers))

        {
            //Then close the proposal and notify unsuccessful bidders that the proposal was closed

            Event::Fire(FreelancerHired($proposal,$hm));
        }



    }
}
