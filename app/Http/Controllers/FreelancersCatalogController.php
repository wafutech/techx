<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Freelancer;
use DB;

class FreelancersCatalogController extends Controller
{
    
    /* List top freelancers in selected skill based on success levels*/

    public function topFreelancers()
    {
    	$freelancers = DB::table('freelancers')
    					->join('users','user_id','freelancers.user_id','users.id')
    					->join('userprofiles','freelancers.user_id','freelancers.user_id','userprofiles.user_id')
    					->join('countries','userprofiles.country_id','countries.id','userprofiles.country_id')
    					->take(5)
    					->get();
    	//$categories = DB::table('skill_categories')


    	$title = 'Browse Top Freelancers';

    	return view('profiles.top-freelancers-profile',['title'=>$title,'freelancers'=>$freelancers]);
    }
}
