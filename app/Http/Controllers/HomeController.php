<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\JobCategory;
use App\Skill;
use DB;
use App\Sitebanner;

class HomeController extends Controller
{
    //

    public function getJobCategories()
    {
    	$categories = JobCategory::all();
        $skills = DB::table('skills')->orderBy('skill','asc')->get()->take(51);
        $banner = Sitebanner::where('status',1)->inRandomOrder()->first();
        //Skill::all()->orderBy('skill','asc');
    return view('home',['categories'=>$categories,'skills'=>$skills,'banner'=>$banner]);
    }

    public function confirmUserForm()
    {
        return view('confirm_user',['title'=>'Confirm']);
    }

    public function confirmUser(Request $request)
    {
    	$user_type = $request->input('confirm');

    	if($user_type==1)
    	{
    		return Redirect::route('clients.create');
    		    	}

    return Redirect::route('freelancers.create');




    }
}
