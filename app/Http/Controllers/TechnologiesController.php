<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Technology;
use Validator;
use Illuminate\Support\Facades\Input;

class TechnologiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $techs = Technology::all();
        return $techs;
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
     $rules =[
            'technology'=>'required|string|unique:technologies',
            'url'=>'url',
            'icon'=>'image|mimes:jpg,jpeg,png',
     ];

     $validator = Validator::make(Input::all(), $rules);

     // Return back to form w/ validation errors & session data as input

     if($validator->fails()) {
        return $validator->messages();

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
        $tech = Technology::find($id);
        return $tech;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $tech = Technology::find($id);
        return $tech;
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
         $tech = Technology::find($id);
         $input = $request->all();
        return $tech->update($input);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $tech = Technology::find($id);
        return $tech->delete();
    }
}
