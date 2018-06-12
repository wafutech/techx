<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProposalRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Input;
use Event;
use App\Events\ProposalReceived;
use DB;
use Session;
use App\JobAdditionalQuestion;
use App\Projectmilestone;
use Carbon\Carbon;
use App\ExpectedDuration;
use App\JobTimeCommitement;
use App\ProposalAttachment;
use App\Proposal;
use App\Freelancer;
use App\PaymentType;
use Auth;
use App\HireManager;
use App\Job;
use App\JobAttachment;
use App\FreelancerJobQuestionAnswer;
use Validator;


class ProposalsController extends Controller
{
    var $jobDurations;
    public function __construct()
    
    {
        $this->jobDurations = ExpectedDuration::pluck('duration','id');
        $this->jobTimeCommitments = JobTimeCommitement::pluck('time_commitment','id');



    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proposals = Proposal::all();
        return $proposals;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {
        $job_id = Session::get('job_id');

        //check if the current user is the author of the job under application and prevent this from happening

        $employer = HireManager::where('user_id',Auth::User()->id)->first();
        if($employer)
        {
            $employer = Job::where('id',$job_id)->where('hire_manager_id',$employer->id)->first();
        if($employer)
        {
            $error ='You cannot place a proposal for a job you posted';
            return $error;
        }
         
        }
       


        $job = DB::table('jobs')
                ->join('currencies','currency_id','currencies.id','jobs.currency_id')
            ->join('payment_types','payment_type_id','payment_types.id','jobs.payment_type_id')
            ->join('freelancer_levels','freelancer_experience_id','freelancer_levels.id','jobs.freelancer_experience_id')
            ->join('project_types','job_type_id','project_types.id','jobs.job_type_id')
            ->join('job_time_commitements','time_commitment_id','job_time_commitements.id','jobs.time_commitment_id')
            ->join('job_categories','job_category_id','job_categories.id','jobs.job_category_id')
                ->where('jobs.id',$job_id)->first();

         $skills = DB::table('jobskills')
            ->join('skills','skill_id','skills.id','jobskills.skill_id')
            ->where('jobskills.job_id',$job_id)->get();

        $quizs = JobAdditionalQuestion::where('job_id',$job_id)->get();
        $attachments = JobAttachment::where('job_id',$job_id)->get();
        $similarJobs = Job::where('main_skill_id',$job->main_skill_id)->where('job_status',1)->where('date_line','>',Carbon::now())->get()->take(5);


        return view('proposals.create',['title'=>'Apply for a job','skills'=>$skills,'quizs'=>$quizs,'job'=>$job,'job_durations'=>$this->jobDurations,'time_commitments'=>$this->jobTimeCommitments,'attachments'=>$attachments,'jobs'=>$similarJobs]);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProposalRequest $request)
    {
        $rules = [
            //Validate form input
        'cover_letter'         => 'required|alpha_dash',
          'payment_amount'      => 'required|numeric',
         'client_comment'      => 'alpha_dash',
         'freelancer_comment'      => 'alpha_dash',
         'freelancer_grade'      => 'string',
         
        ];
        $validation = Validator::make(Input::all(),$rules);

        if ($validation->fails())
        {
            return $validation->messages();
        }


        $freelancer = Freelancer::where('user_id',Auth::User()->id)->first();
        $payment_type = PaymentType::where('payment_type',$request->input('payment_type_id'))->first();
        $proposal = new Proposal;
        $proposal->job_id = $request->input('job_id');
        $proposal->freelancer_id = $freelancer->id;
        $proposal->payment_type_id = $payment_type->id;
        $proposal->cover_letter = $request->input('cover_letter');
        $proposal->payment_amount = $request->input('payment_amount');
        $proposal->freelancer_comment = $request->input('freelancer_comment');
        $proposal->expected_duration_id = $request->input('expected_duration_id');
        $proposal->time_commitment_id = $request->input('time_commitment');
       $proposal->save();


       if($request->file('attachments'))
       {
        foreach ($request->attachments as $photo) {
            $filename = $photo->store('proposals');
            ProposalAttachment::create([
                'proposal_id' => $proposal->id,
                'attachment_path' => $filename
            ]);
       }
        
        }

        //Save milestones
        if($request->input('mile_desc'))

        {
            $milestones = [];
            $desc = $request->input('mile_desc');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $cost = $request->input('cost');

            $milestones = [$desc,$start_date,$end_date,$cost];
            for($i=0;$i<count($milestones)-1;$i++)

            {
                $milestone = new Projectmilestone;
                $milestone->proposal_id = $proposal->id;
                $milestone->milestone_desc = $milestones['mile_desc'][$i];
                $milestone->start_date = $milestones['start_date'][$i];
                $milestone->start_date = $milestones['start_date'][$i];
                $milestone->end_date = $milestones['end_date'][$i];
                $milestone->cost = $milestones['cost'][$i];
                $milestone->save();

            }

        }

        //Save freelancers answers to questions from employer if any
        if($request->input('answers'))

        {
            for($i=0;$i<count($request->input('answers'));$i++)
            {
                $answer = new FreelancerJobQuestionAnswer;
                $answer->job_question_id = $request->input('questions')[$i];
                $answer->freelancer_id = $proposal->freelancer_id;
                $answer->proposal_id = $proposal->id;
                $answer->answer = $request->input('answers')[$i];
                $answer->save();

            }
        }

        /*$files = $request->file('attachment');

if($request->hasFile('attachment'))
{
    foreach ($files as $file) {
        $file->store('users/' . $this->user->id . '/messages');
    }
}*/

//Notify the employer that a new proposal has been received
Event::Fire(new ProposalReceived($freelancer=$freelancer->id,$proposal=$proposal->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proposal = DB::table('proposal')
                    ->join('jobs','job_id','jobs.id','proposals.job_id')
                    ->join('freelancers','freelancer_id','freelancers.id','proposals.freelancer_id')
                    ->join('payment_types','payment_type_id','payment_types.id','proposals.payment_type_id')
                    ->join('users','freelancer_id','freelancers.user_id','users.id')
                    ->where('proposals.id',$id)->first();

        $milestones = Projectmilestone::where('proposal_id',$id)->get();

        return view('proposals.show',['proposal'=>$proposal,'milestones'=>$milestones]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proposal = findOrFail($id);
     return view('proposals.edit',['title'=>'Edit Proposal','job'=>$job]);

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
        Proposal::where('id',$id)->update($input);
        $proposal = Proposal::find($id);

        return 'Proposal updates';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proposal = findOrFail($id);
        $proposal->delete();
        return 'Proposal deleted';
    }
}
