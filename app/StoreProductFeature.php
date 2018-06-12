<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreProductFeature extends Model
{
    protected $fillable =['product_id','feature'];
    public function product()
    {
    	return $this->belongsTo('App\StoreProduct');
    }
}
