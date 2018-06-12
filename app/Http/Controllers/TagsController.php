<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Permission;
use App\Role;
use Hash;
use Mail;
use App\Mail\NewUser;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        return $tags;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

          'tag'           => 'required|string|unique:tags',
         'approved'           => 'required|numeric',          
         
      );

    $validator = Validator::make(Input::all(), $validation_rules);

     // Return back to form w/ validation errors & session data as input

     if($validator->fails()) {
        return $validator->messages();

    }
            $tag = new Tag;
            $tag->tag = $request->tag;
            $tag->approved = $request->approved;
            $tag->save();
            return 'Tag created!';

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = Tag::findOrFail($id);
        return $tag;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return $tag;
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
        $tag = Tag::findOrFail($id);
        $tag->update($input);
        return $tag();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id)->delete();
        return 'Tag Removed!';
    }
}
