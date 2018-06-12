<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreProductReviews extends Model
{
    protected $fillable =['product_id','customer_id','review','rating'];

    public function product()
    {
    	return $this->belongsTo('App\StoreProduct');
    }

    public function customer()
    {
    	return $this->belongsTo('App\StoreCustomer');
    }
}
