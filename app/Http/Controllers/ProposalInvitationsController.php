<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Event;
use App\Events\JobApplicationInvitation;
use Redirect;
use Response;
use App\HireManager;
use App\Freelancers;
use App\Job;
use App\Jobinvitation;
use Session;
use App\SkillCategory;
use DB;
use Auth;

class ProposalInvitationsController extends Controller
{
   
   public function __construct()
   {
   	$this->middleware(['auth']);
   } 
	public function invitationIndex()
	{
		$job = Session::get('jobInvitation');

	return view('jobs.invitation.job',['title'=>'Invite Freelancers','job'=>$job]);

	}

	public function inviteFreelancers($id)
	{
				$job = Job::where('id',$id)->first();

		$freelancers = $freelancers = DB::table('freelancers')			
    					->join('users','user_id','freelancers.user_id','users.id')
    					->join('userprofiles','freelancers.user_id','freelancers.user_id','userprofiles.user_id')
    					->join('countries','userprofiles.country_id','countries.id','userprofiles.country_id')
    					->select(
    						DB::raw('freelancers.id'),
    						DB::raw('freelancers.freelancer_title'),
    						DB::raw('freelancers.overview'),
    						DB::raw('freelancers.years_of_exp'),
    						DB::raw('freelancers.hourly_rate'),
    						DB::raw('freelancers.user_id'),
    						DB::raw('users.name'),
    						DB::raw('users.email'),
    						DB::raw('userprofiles.first_name'),
    						DB::raw('userprofiles.last_name'),
    						DB::raw('userprofiles.avatar'),
    						DB::raw('countries.country_name') 			
    						)
    					->where('freelancers.main_skill_id',$job->main_skill_id)
    					->get();
    		$skill = SkillCategory::where('id',$job->main_skill_id)->first()->skill_category;

    		//Set freelancer session


    	$title = 'Browse Top Freelancers in '.$skill;

    	return view('profiles.top-freelancers-profile',['title'=>$title,'freelancers'=>$freelancers,'job'=>$job]);
	}
    public function invite(Request $request)
    {
    	$manager = HireManager::where('user_id',Auth::User()->id)->first()->id;
    	$job_id= $request->input('job');
    	//Check if the freelancer is already invited for the job
    	$already_invited = DB::table('jobinvitations')->where('job_id',$job_id)->where('freelancer_id',$request->input('freelancer_id'))->first();
    	$errors = '';
    	if($already_invited)
    	{
    		$errors = 'This freelancer had been invited';
    		return Response::json($errors);
    	}

    	$invitation = new Jobinvitation;
    	$invitation->job_id = $job_id;
    	$invitation->freelancer_id =$request->input('freelancer_id');
    	$invitation->hire_manager_id =$manager;
    	$invitation->save();
    	Event::Fire(new JobApplicationInvitation($invitation->job_id,$invitation->hire_manager_id,$invitation->freelancer_id));
    	return 'success';

    }
}
