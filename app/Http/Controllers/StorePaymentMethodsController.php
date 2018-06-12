<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StorePaymentMethod;
use Validator;
use Illuminate\Support\Facades\Input;

class StorePaymentMethodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pms = StorePaymentMethod::all();
        return $pms;
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
        $rules =['payment_method'=>'required|unique:store_payment_methods|string'];
        $validator = Validator::make(Input::all(),$rules);
        if($validator->fails())
        {
            return $validator->messages();
        }

        $pm = StorePaymentMethod::create($request->all());
        return $pm;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pm = StorePaymentMethod::find($id);
        return $pm;
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
        $pm = StorePaymentMethod::find($id);
        return $pm->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pm = StorePaymentMethod::find($id);
        return $pm->delete();
    }
}
