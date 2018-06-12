<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Event;
use App\Events\JobPosted;
use Carbon\Carbon;
use Session;
use DB;
use App\Job;
use Illuminate\Pagination\Paginator;
use App\JobCategory;
use App\JobSubcategory;
use App\PaymentType;
use App\ExpectedDuration;
use App\Freelancer;
use App\FreelancerLevel;
use App\JobTimeCommitement;
use App\FreelancerType;
use App\ProjectType;
use App\ProjectLifecycle;
use App\Complexity;
use App\Department;
use App\HireManager;
use App\HireManagerType;
use App\JobAttachment;
use App\JobAdditionalQuestion;
use App\Currency;
use App\SkillCategory;
use App\Jobskill;
use App\Jobstatus;
use App\Skill;
use Auth;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    var $categories;
    var $subCategories;
    var $jobTypes;
    var $freelancerTypes;
    var $jobCommitments;
    var $jobDurations;
    var $paymentTypes;
    var $freelancerExpLevels;
    var $projectPhase;
    var $complexities;
    var $departments;
    var $hireManagerTypes;
    var $currency;
    var $skillCategories;
    var $jobStatus;
      public function __construct()

    {
       $this->middleware(['auth']);
       //$this->middleware(['permission:role-list|role-create|role-edit|role-delete']);
        $this->categories = JobCategory::pluck('job_cat_name','id');
        $this->subCategories = JobSubcategory::pluck('sub_cat_name','id');
        $this->paymentTypes = PaymentType::pluck('payment_type','id');
        $this->jobDurations = ExpectedDuration::pluck('duration','id');
        $this->FreelancerLevel = FreelancerLevel::pluck('level','id');
        $this->jobCommitments = JobTimeCommitement::pluck('time_commitment','id');
        $this->freelancerTypes = FreelancerType::pluck('type','id');

        $this->jobTypes = ProjectType::pluck('project_type','id');
        $this->freelancerExpLevels = FreelancerLevel::pluck('level','id');
        $this->projectPhase = ProjectLifecycle::pluck('life_cycle','id');
         $this->complexities = Complexity::pluck('complexity_text','id');
          $this->departments = Department::pluck('department_name','id');
           $this->hireManagerTypes = HireManagerType::pluck('manager_type','id');
            $this->currency = Currency::pluck('title','id');
        $this->skillCategories = SkillCategory::pluck('skill_category','id');
         $this->jobStatus = Jobstatus::pluck('job_status','id')->take(-2);

    }

    public function index(Request $request)
    {
        //
        $query = $request->input('query');
        if(!$query)
        {
            $freelancer = Freelancer::where('user_id',Auth::User()->id)->first();
            if(!$freelancer)
            {
                
                return 'failed';
       

            }

    $jobs = DB::table('jobs')
        ->where('main_skill_id',$freelancer->main_skill_id)
        ->where('job_status',1)
        ->where('date_line','>',Carbon::now())
    ->orderBy('created_at','desc');

     return $jobs;


        }
        $jobs = Job::where('job_name','LIKE'.'%'.$query.'%');

                 return $jobs;

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $_isEmployer = HireManager::where('user_id',Auth::User()->id)->first();

        if(!$_isEmployer)
        {
            return Redirect::route('clients.create');
        }

        return view('jobs.create',['title'=>'Post Job','categories'=>$this->categories,'subcategories'=>$this->subCategories,'jobtypes'=>$this->jobTypes,'payment_types'=>$this->paymentTypes,'experience_levels'=>$this->freelancerExpLevels,'job_durations'=>$this->jobDurations,'time_commitments'=>$this->jobCommitments,'project_phases'=>$this->projectPhase,'complexities'=>$this->complexities,'departments'=>$this->departments,'hire_manager_type'=>$this->hireManagerTypes,'currency'=>$this->currency,'skillcategories'=>$this->skillCategories,'status'=>$this->jobStatus]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $request)
    {               
        
         $hireManager = HireManager::where('user_id',Auth::User()->id)->first();
         if($hireManager==null)
         {
            return 'Not Found';
         }
         //Check if the user has already posted the same job
         $job_exists = Job::where('job_name',$request->job_name)->where('hire_manager_id',$hireManager->id)->first();

              if($job_exists)
            {

                return 'job exists';
            }

   // Else save the new job
         $job = new Job;
         $job->hire_manager_id = $hireManager->id;
         $job->expected_duration_id = $request->input('expected_duration_id');
        $job->complexity_id = $request->input('complexity_id');
        $job->job_desc = $request->input('job_desc');
        $job->job_name = $request->input('job_name');
        $job->main_skill_id = $request->input('main_skill_id');
        $job->payment_type_id = $request->input('payment_type');
        $job->job_category_id = $request->input('job_category_id');
        $job->payment_amount = $request->input('payment_amount');
         $job->currency_id = $request->input('currency_id');
        $job->freelancers_needed = $request->input('freelancers_needed');
        $job->time_commitment_id = $request->input('time_commitment');
        $job->freelancer_experience_id = $request->input('experience_level');
        $job->project_cycle_id = $request->input('job_type');
        $job->job_type_id = $request->input('project_phase');
        $job->milestone = $request->input('milestone');
         $job->by_invitation = $request->input('by_invitation');
        $job->job_status = $request->input('status');
        $job->max_proposals = $request->input('max_proposals');

        $job->date_line = $request->input('date_line');
        $job->save();

           //save skills
        $skills = $request->input('skill');

       for($i=0;$i<count($skills);$i++)
        {
            $skill = new Jobskill;
            $skill->job_id = $job->id;
            $skill->skill_id = $skills[$i];
            $skill->save();
        }



        //Check if any attachment is available
        if($request->file('job_attachment')!=Null)
        {

            //then process the attachment
             $filename ="kenfree".date('his');
      
            if(file_exists($filename))
            {
         Storage::delete($filename);

            }

        $ext = $request->file('job_attachment')->getClientOriginalExtension();
              
        //upload  image


        $path = $request->file('job_attachment')->storeAs('public', $filename.".".$ext); 
       
        $path = explode('/', $path);

        $path = $path[1];

        $attachment =new JobAttachment;
        $attachment->job_id = $job->id;
        $attachment->job_attachment =$path;
        $attachment->save();
        
        }

        //check if there is any additonal questions
        if($request->input('addQuiz')!=Null)
        {

            
           
            $quizs= $request->input('addQuiz');

            for($i=0;$i<count($quizs);$i++)
            {
                $addQuiz = new JobAdditionalQuestion;
                $addQuiz->job_id = $job->id;
                $addQuiz->question=$quizs[$i];
                $addQuiz->save();

            }
        }

               Event::Fire(new JobPosted($job->id,$job->hire_manager_id));
               if($job->by_invitation==1)
               {
                Session::put('jobInvitation',$job);
                return 'redirect';
                
               }

                //The returned value to be used by API consumer to redirect page view page
               return $job->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = DB::table('jobs')
                ->join('currencies','currency_id','currencies.id','jobs.currency_id')
            ->join('payment_types','payment_type_id','payment_types.id','jobs.payment_type_id')
            ->join('freelancer_levels','freelancer_experience_id','freelancer_levels.id','jobs.freelancer_experience_id')
            ->join('job_time_commitements','jobs.time_commitment_id','job_time_commitements.id','jobs.time_commitment_id')
                ->where('jobs.id',$id)->first();

                //Set job id sessesion

                Session::put('job_id',$id);

               $skills = DB::table('jobskills')
            ->join('skills','skill_id','skills.id','jobskills.skill_id')
            ->where('jobskills.job_id',$id)->get();  
                    
       

        $quizs = JobAdditionalQuestion::where('job_id',$id)->get();
        if(empty($quizs))
        {
            $quizs= 'No questions associated with this job request';
        }
        
       return  array('job' => $job, 'skills'=>$skills,'quizs'=>$quizs);

        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job = Job::findOrFail($id);

         return $job;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $input = $request->all();
        $job = Job::find($id);
        $job->update($input);
        return $job;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        return $job->delete();

    }
}
