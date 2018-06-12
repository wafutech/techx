<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\Skill;
use App\SkillCategory;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    var $skillCategories;
     public function __construct()
    {
        $this->skillCategories = SkillCategory::pluck('skill_category','id');
    }


    public function index()
    {
        $skills = Skill::all()->paginate(20);
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
        $validation_rules = array(
            
    'skills'      => 'required|string', 
    'skill_cat_id'      => 'required|numeric',  
 
         
          
      );
    $validator = Validator::make(Input::all(), $validation_rules);
     // Return back to form w/ validation errors & session data as input
     if($validator->fails()) {
        return  $validator->messages();
    }

    $skills = $request->input('skills');

    $skills= explode(',', $skills);
    for($i=0;$i<count($skills);$i++)
    {
        $skill = new Skill;
        $skill->skill_cat_id=$request->input('skill_cat_id');
        $skill->skill = $skills[$i];
        $skill->save();
    }

        
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
        $skill = Skill::findOrFail($id);
        return response($skill);
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
        $skill = Skill::find($id)->update($input);
        return response($skill);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);
        return $skill->delete();
    }
}
