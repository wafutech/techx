<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PortfolioRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use DB;
use Validator;
use App\FreelancerPortfolio;
use App\Freelancer;
use Auth;
use App\Country;
use App\Testimony;


class FreelancerPortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        var $countries;
        public function __construct()
    {
        $this->middleware(['auth']);
        $this->countries = Country::pluck('country_name','id');

        
        
            }

    public function index()
    {
        $portfolios = FreelancerPortfolio::all();
        return view('portfolios.index',['title'=>'Freelancer Portfolios','portfolios'=>$portfolios]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

        return view('portfolios.create',array('title'=>'Create Portfolio'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PortfolioRequest $request)
    {
       
        $freelancer = Freelancer::where('user_id',Auth::User()->id)->first();

                $path ='';

        if(!$freelancer)
        {
            return Redirect::back()->withErrors('You are not a freelancer to complete this action');
        }

        if($request->file('portfolio_image'))
        {
        $filename ='portofilio'.Auth::User()->id.date('his');

            
            if(file_exists($filename))
            {
         Storage::delete($filename);

            }

        $ext = $request->file('portfolio_image')->getClientOriginalExtension();
              
        //upload  image


        $path = $request->file('portfolio_image')->storeAs('public', $filename.".".$ext); 
       
        $path = explode('/', $path);
        $path = $path[1];
        //get logged in freelancer id
        }
              

        $portfolio = new FreelancerPortfolio;
        $portfolio->portfolio_title = $request->input('portfolio_title');
        $portfolio->freelancer_id = $freelancer->id;
        $portfolio->user_id = Auth::User()->id;
        $portfolio->portfolio_image=$path;
        $portfolio->portfolio_desc=$request->input('portfolio_desc');
        $portfolio->portfolio_link=$request->input('portfolio_link');

        $portfolio->save();

        //Check if the user has testimonies
        if($request->input('from'))
        {
            //process testimonials
            $from = $request->input('from');
            $testimony = $request->input('testimony');
            $testimony_link = $request->input('testimony_link');
            $testimonies = ['testifier'=>$from,'testimony'=>$testimony,'link'=>$testimony_link];
            //print_r($testimonies);exit;
            for($i=0;$i<count($testimonies)-1;$i++)
            {
                $testimony = new Testimony;
                $testimony->portfolio_id = $portfolio->id;
                $testimony->user_id = Auth::User()->id;
                $testimony->testifier = $testimonies['testifier'][$i];
                $testimony->testimony = $testimonies['testimony'][$i];
                $testimony->link = $testimonies['link'][$i];
                $testimony->save();
            }
return Redirect::back()->with('message','success, add more portfolios...');
        
   // return view('profiles.profileimage',['title'=>'Upload A profesional Photo','countries'=>$this->countries,'step'=>'Step 5']);



             
        }

   return Redirect::back()->with('message','success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $portfolio = FreelancerPortfolio::findOrFail($id);
        return view('portfolios.show',array('title'=>'Your Portfolio','portfolio'=>$portfolio));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $portfolio = FreelancerPortfolio::findOrFail($id);
        return response($portfolio);
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
        FreelancerPortfolio::findOrFail($id)->update($input);
        return response('Success',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $portfolio = FreelancerPortfolio::findOrFail($id);
        return $portfolio->delete();
    }
}
