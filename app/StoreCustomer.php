<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreCustomer extends Model
{
    protected $fillable = ['customer_name','phone','country','ip_address','shipping_address','email','user_id'];

    public function orders()
    {
    	return $this->hasMany('App\StoreCustomerOrder');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
