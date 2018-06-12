<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreOrderDetails extends Model
{
    protected $fillable = ['order_id','product_id','unit_price','qty','amount'];

    public function order()
    {
    	return $this->belongsTo('App\StoreOrder');
    }
}
