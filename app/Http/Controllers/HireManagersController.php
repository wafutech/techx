<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\HireManager;
use DB;
use Session;
use Carbon\Carbon;
use App\Userprofile;
use App\Country;
use Auth;
use App\Role;
class HireManagersController extends Controller
{
   
      public function __construct()
    {
        $this->middleware(['auth']);
     $this->countries = Country::pluck('country_name','id');

    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $hiremanagers = HireManager::all();
        if($hiremanagers->isEmpty())
        {
            return 'Failed!';
        }
        return $hiremanagers;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        //Check if the user has completed a user profile
        $has_profile = Userprofile::where('user_id',Auth::User()->id)->first();
        if(!$has_profile)

        {
       //Else let the user complete basic profile page first
return view('profiles.create',['title'=>'Complete Personal Information','countries'=>$this->countries,'step'=>'Step 2']);
        }

    $_hasEmployeeProfile = HireManager::where('user_id',Auth::User()->id);


        if(!$_hasEmployeeProfile)
        {
             //Create employer profile
        return view('hiremanagers.create',['title'=>'Employer Account Information','countries'=>$this->countries]);

        }

        //Redirect user to post new job page
        return Redirect::route('jobs.create');
 
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input =$request->all();
        $create = HireManager::create($input);

        //Assign role:freelancer to this user
        $user = Auth::User()->id;
        $role = Role::where('name','employer')->first()->id;
            $user->attachRole($role);
        return 'success';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hm = HireManager::findOrFail($id);
        return $hm;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $hireManager = HireManager::findOrFail($id);
        return response($hireManager);
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
        //
        $input = $request->all();
        HireManager::where('id',$id)->update($input);
        $hm = HireManager::find($id);
        return $hm;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $hm = HireManager::findOrFail($id);
        return $hm->delete();
    }
}
