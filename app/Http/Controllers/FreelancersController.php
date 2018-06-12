<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Freelancer;
use App\Userprofile;
use App\Country;
use App\JobCategory;
use App\SkillCategory;
use App\Skill;
use App\FreelancerLevel;
use App\HasSkill;
use Auth;
use Validator;
use App\Certification;
use App\Role;

class FreelancersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    var $countries;
    var $skillCategories;
    var $skills;
      public function __construct()
    {
        $this->middleware(['auth']);
        $this->countries = Country::pluck('country_name','id');
        $this->skillCategories = SkillCategory::pluck('skill_category','id');
        $this->skills = Skill::pluck('skill','id');
        $this->experienceLevels = FreelancerLevel::pluck('level','id');

    }
    public function index()
    {
       $freelancers = Freelancer::all()->paginate(10);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       /* $_isfreelancer = Freelancer::where('user_id',Auth::User()->id)->first();
        if($_isfreelancer!=null)
        {
            return Redirect::route('jobs.index')->with('message','Already Registered as a Freelancer. Begin applying for jobs');
        }
         
         return view('freelancers.create',['title'=>'Complete Profile','countries'=>$this->countries,'step'=>'Step 3','skillcategories'=>$this->skillCategories,'skills'=>$this->skills,'experience_levels'=>$this->experienceLevels]);*/
         
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        
         $validation_rules = array(
            
  //Validate form input
        'user_id'         => 'required',
          'overview'      => 'required|string|min:100',
         'experience_level_id'      => 'required',
         'main_skill_id'      => 'required',
         'years_of_exp'      => 'required|numeric',
         'freelancer_title'      => 'required|string',
         //'url'         => 'url',
          'skill'      => 'required',
          'hourly_rate'      => 'required|numeric',
                
          
      );
    $validator = Validator::make(Input::all(), $validation_rules);
     // Return back to form w/ validation errors & session data as input
     if($validator->fails()) {
        return  $validator->messages();
    }


        $freelancer = new Freelancer;
        $freelancer->user_id = Auth::User()->id;
        $freelancer->freelancer_title = $request->input('freelancer_title');
        $freelancer->overview = $request->input('overview');
        $freelancer->main_skill_id = $request->input('main_skill_id');
        $freelancer->experience_level = $request->input('experience_level_id');
       $freelancer->hourly_rate = $request->input('hourly_rate');
        $freelancer->years_of_exp = $request->input('years_of_exp');
        $freelancer->url = $request->input('url');
       $freelancer->save();

        //save skills
        $skills = $request->input('skill');

       for($i=0;$i<count($skills);$i++)
        {
            $skill = new HasSkill;
            $skill->freelancer_id = $freelancer->id;
            $skill->skill_id = $skills[$i];
            $skill->save();
        }


         $certficate = $request->input('certificate');
        $institution = $request->input('institution');
        $date = $request->input('date');
        $attachment = $request->input('attachment');
        $certificatations = array($certficate,$institution,$date,$attachment);

        for($i=0;$i<count($certificatations)-1;$i++)
        {
            $cert = new Certification;
            $cert->freelancer_id = $freelancer->id;
        $cert->certification_name = $certificatations[0][$i];
        $cert->provider = $certificatations[1][$i];
         $cert->date_earned = $certificatations[2][$i];
        $cert->attachment = $certificatations[3][$i];
        $cert->save();

        }
        //Assign role:freelancer to this user
        $user = Auth::User()->id;
        $role = Role::where('name','freelancer')->first()->id;
                    $user->attachRole($role);

        //Redirect the user to create his freelancer portfolio
       return 'Success';

    
            }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $freelancer = Freelancer::findOrFail($id);
        return response($freelancer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $freelancer = Freelancer::findOrFail($id);
        return response($freelancer);
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
        $freelancer = Freelancer::find($id);
        $freelancer->update($input);    
        return $freelancer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $freelancer = Freelancer::findOrFail($id);
        return $freelancer->delete();
    }
}
