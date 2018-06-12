<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Redirect;
use App\JobCategory;
use DB;
use Session;
use Auth;


class JobCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function __construct()
    {

    }
    public function index()
    {
        $jobSubcats = JobCategory::with('subcategories')->orderBy('job_cat_name','asc');
        return $jobSubcats;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cat = new JobCategory;
        $cat->job_cat_name=$request->input('job_cat_name');
        $cat->job_cat_desc=$request->input('job_cat_desc');
        $cat->save();


        //Generate file name
        $filename ='caticon'.date('his');
       if($request->file('cat_icon'))
        {
            if(file_exists($filename))
            {
         Storage::delete($filename);

            }

        $ext = $request->file('cat_icon')->getClientOriginalExtension();
              
        //upload  image


        $path = $request->file('cat_icon')->storeAs('public', $filename.".".$ext); 
       
        $path = explode('/', $path);
        $path = $path[1];
             
    
      
            //Then update
            DB::update('update job_categories set cat_icon=? where id =?',[$path,$cat->id]); 

        
        return 'success';
    }
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job = JobCategory::findOrFail($id);
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
        JobCategory::where('id',$id)->update($input);
        $job = JobCategory::find($id);
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
        $job = JobCategory::findOrFail($id);
        return $job->delete();
    }
}
