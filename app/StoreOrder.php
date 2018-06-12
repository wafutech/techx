<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreOrder extends Model
{
    protected $fillable = ['customer_id','order_date','amount','delivery_email','payment_method','notes','status'];

    public function product()
    {
    	return $this->belongsTo('App\StoreProduct');
    }

    public function customer()
    {
    	return $this->belongsTo('App\StoreCustomer');
    }

    public function paymentmethods()
    {
    	return $this->belongsTo('App\StorePaymentMethod');
    }

    public function order_details()
    {
    	return $this->hasMany('App\StoreOrderDetail');
    }
}
