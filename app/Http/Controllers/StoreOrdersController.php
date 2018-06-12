<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\StoreOrder;
use App\StoreOrderDetail;
use Auth;
use Validator;

class StoreOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = StoreOrder::all();
        return $orders;
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

                'order_date'=>'required|date',
                'amount'=>'required|numeric',
                'delivery_email'=>'required|email',
                'payment_method'=>'required',
                'customer_id'=>'required',
                 'product_id'=>'required',
                ];

        $validator = Validator::make(Input::all(),$rules);
        if($validator->fails())
        {
            return $validator->messages();
        }
        $status = 'pending';
        $order = new StoreOrder;
        $order->order_date = $request->order_date;
        $order->customer_id = $request->customer_id;
        $order->amount = $request->amount;
        $order->payment_method = $request->payment_method;
        $order->delivery_email = $request->delivery_email;
        $order->status = $status;
        $order->notes = $request->notes;
        $order->save();

    $products = [];
for($i= 0; $i < count($product); $i++){
    $products[] = [
        'order_id' => $order->id,
        'product_id' => $product['product_id'][$i],
        'qty' => 1,
        'unit_price' => $product['price'][$i],
        'amount' => $product['total'][$i],
    ];
}
//Save order details
DB::table('order_details')->insert($products);

return $request->payment_method;


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = StoreOrder::findOrFail($id);
        return $order;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = StoreOrder::findOrFail($id);
        return $order;
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
        $order = StoreOrder::findOrFail($id);
        return $order->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = StoreOrder::findOrFail($id);
        return $order->delete();
    }
}
