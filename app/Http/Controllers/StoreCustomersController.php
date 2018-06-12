<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StoreCustomer;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;

class StoreCustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = StoreCustomer::all();
        return $customers;
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
        $rules = [

                'customer_name'=>'required|string',
                'country'=>'required|string',
                'email'=>'required|email',
                'phone'=>'required|numeric',
                'shipping_address'=>'',
                'ip_address'=>'',

                ];

        $validator = Validator::make(Input::all(),$rules);
        if($validator->fails())
        {
            return $validator->messages();
        }

        $customer new StoreCustomer;
        $customer->customer_name = $request->customer_name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->country = $request->country;
        $customer->ip_address = null;/*$request->user_agent();*/
        $customer->shipping_address = $request->shipping_address;
        $customer->save();
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
        $customer = StoreCustomer::findOrFail($id);
        return $customer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $customer = StoreCustomer::findOrFail($id);
        return $customer;
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
         $customer = StoreCustomer::findOrFail($id);
        return $customer->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $customer = StoreCustomer::findOrFail($id);
        return $customer->delete();
    }
}
