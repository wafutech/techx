<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AwardRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\Paginator;
use Redirect;
use Response;
use App\Job;
use Carbon\Carbon;
use App\Award;
use Auth;
use App\User;
use App\JobCategory;
use App\Skill;
use DB;
use Stevebauman\Location\Location;

class CustomMethodsController extends Controller
{
    //

    public function allJobs()
    {
    	$jobs =Job::where('job_status',1)->where('date_line','>',Carbon::now());

    	 return $jobs;


    }


    

    public function storeAward(AwardRequest $request)
    {
    	if($request->file('award_attachment'))
        {
        $filename ='award'.Auth::User()->id.date('his');

            
            if(file_exists($filename))
            {
         Storage::delete($filename);

            }

        $ext = $request->file('award_attachment')->getClientOriginalExtension();
              
        //upload  image


        $path = $request->file('award_attachment')->storeAs('public/awards', $filename.".".$ext); 
       
        $path = explode('/', $path);
        $path = $path[1];
    }
        //ge
    	$award = new Award;
    	$award->award_title = $request->input('award_title');
    	$award->user_id = Auth::User()->id;
    	$award->award_desc = $request->input('award_desc');
    	 $award->date_awarded = $request->input('date_awarded');

    	$award->organization = $request->input('organization');
    	$award->award_attachment = $path;
    	$award->award_link = $request->input('award_link');
    	$award->save();

    	return response('Award saved, add more...');

    }

    public function userNameExists(Request $request)
    {
        $name = $request->input('name');
        $name = User::where('name',$name)->first();
        if($name)
        {
            return response('taken');
        }

        return response('available');


    }

    public function userEmailExists(Request $request)

    {
         $email = $request->input('email');
        $email = User::where('email',$email)->first();
        if($email)
        {
            return response('taken');
        }
        return response('available');


    }

    public function jobSearchAutoComplete()
    {
        $query = Input::get('search');
        $results =array();
        $jobs = DB::table('skills')
            ->where('skill','LIKE','%'.$query.'%')->take(5)
            ->orderBy('skill','asc')
            ->take(5)
            ->get();


        foreach($jobs as $job)
        {
         $results[] = [ 'id' => $job->skill_cat_id, 'value' => $job->skill ];


        }


return Response::json($results);

    }

    public function jobSearch(Request $request)
    {
    /*$ip = $request->ip();
        $location = new Location;
$position = $location->get('129.232.249.177');
dd($position);*/
    $term = Input::get('search');

  $skill = Skill::where('skill',$term)->first();
     if(!$skill)
     {
        $errorMessage = 'No result found for search text '.$term;
        return $errorMessage;
     }

    $jobs = DB::table('jobs')
        ->where('main_skill_id',$skill->skill_cat_id)
        ->where('job_status',1)
        //->where('date_line','>',Carbon::now())
    ->orderBy('created_at','desc');
    

  return $jobs; 


    }
}
