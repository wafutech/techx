<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\JobCategory;
use App\SkillCategory;
use App\Skill;
use App\FreelancerLevel;
use App\FreelancerPortfolio;
use App\FreelancerFeedback;
use App\Job;
use App\Stat;
use App\Proposal;
use DB;
use Auth;
use App\HireManager;
use App\Country;

class EmployerProfileController extends Controller


{
	var $countries;
   public function __construct()
    {
        $this->middleware(['auth']);
        $this->countries = Country::pluck('country_name','id');


    }



    public function EmployerProfileView()
    {
    	$_isEmployer = HireManager::where('user_id',Auth::User()->id)->first();
    	if(!$_isEmployer)
    	{
    		return 'Redirect to hire manager signup page';
    	}

    	$profile = DB::table('users')
                        ->join('countries','country_id','users.country_id','countries.id')
                    ->where('users.id',Auth::User()->id)->first();
$manager = DB::table('hire_managers')
                        ->join('countries','company_country_id','hire_managers.company_country_id','countries.id')
                    ->where('hire_managers.user_id',Auth::User()->id)->first();
      $manager_id = HireManager::where('user_id',Auth::User()->id)->first();

      $manager_id = $manager_id->id;

$proposals = DB::table('proposals')
				->join('jobs','job_id','proposals.job_id','jobs.id')
				->where('jobs.hire_manager_id',$manager_id)->get();


$stats = Stat::where('hire_manager_id',$manager->id)->get();

$comments = FreelancerFeedback::where('freelancer_id',$manager->id)->get();
$jobs = Job::where('hire_manager_id',$manager_id)->get();


return view('profiles.employer_profile',array('title'=>'Your Profile','profile'=>$profile,'manager'=>$manager,'stats'=>$stats,'comments'=>$comments,'jobs'=>$jobs,'proposals'=>$proposals));
    }
}
