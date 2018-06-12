<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StorePaymentMethod extends Model
{
    protected $fillable =['payment_method'];

    public function orders()
    {
    	return $this->hasMany('App\StorePaymentMethod');
    }
}
