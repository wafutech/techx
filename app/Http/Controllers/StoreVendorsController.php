<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StoreVendor;
use Illuminate\Support\Facades\Input;
use Validator;

class StoreVendorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = StoreVendor::all();
        return $vendors;
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
                'name'=>'required|string',
                'address'=>'required',
                'about'=>'required|string',
                'email'=>'email',
                'phone'=>'phone',

                ];

        $validator = Validator::make(Input::all(),$rules);
        if($validator->fails())
        {
            return $validator->messages();
        }
        try
        {
         $vendor = StoreVendor::create($request->all());
        return $vendor;   
        }
        catch(\Exception $e){
            return 'Something went wrong '.$e->getMessage();
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
        $vendor = StoreVendor::findOrFail($id);
        return $vendor;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $vendor = StoreVendor::findOrFail($id);
        return $vendor;
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
         $vendor = StoreVendor::findOrFail($id);
        return $vendor->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $vendor = StoreVendor::findOrFail($id);
        return $vendor->delete();
    }
}
