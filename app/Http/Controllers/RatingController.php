<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use DB;
use App\ClientToFreelancerRating;
use Auth;
use App\HireManager;

class RatingController extends Controller
{
    
    public function __construct()
    {
    	$this->middleware(['auth']);
    }

    public function clientRating(Request $request)

    {
    	$rate = ClientToFreelancerRating::create($request->all());
    	/*$clientId = HireManager::where('user_id',Auth::User()->id)->first()->id;

    	$rate = New ClientToFreelancerRating;
    	$rate->client_id = $clientId;
    	$rate->freelancer_id = 5;
    	$rate->job_id = 12;
    	$rate->rate = $request->input('rate');
    	$rate->save();*/
    return Response::json($rate);


    }
}
