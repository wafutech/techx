<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Validator;
use DB;
use Auth;
use Userprofile;



class ProfileImageController extends Controller
{
    public function uploadProfileImageForm()
    {
    	return view('profiles.profileimage',['title'=>'Attach Profesional Photo','step'=>'step 5']);
    }

    public function uploadProfileImage(Request $request)
    {

    	$validation_rules = array(
            
           'avatar'      => 'required|image|mimes:jpeg,gif,png,jpg',  
         
          
      );
    $validator = Validator::make(Input::all(), $validation_rules);
     // Return back to form w/ validation errors & session data as input
     if($validator->fails()) {
        return  Redirect::back()->withErrors($validator)->withInput();
    }

    	/*if($request->input('avatar'))
        {*/
            $filename ='profilephoto'.Auth::User()->id.date('his');
       if($request->file('avatar'))
        {
            if(file_exists($filename))
            {
         Storage::delete($filename);

            }

        $ext = $request->file('avatar')->getClientOriginalExtension();
              
        //upload  image


        $path = $request->file('avatar')->storeAs('public', $filename.".".$ext); 
       
        $path = explode('/', $path);
        $path = $path[1];
             
    
      
            //Then update
            DB::update('update userprofiles set avatar=? where user_id =?',[$path,Auth::User()->id]); 
        }

return Redirect::route('userprofiles.index');
    }
}
