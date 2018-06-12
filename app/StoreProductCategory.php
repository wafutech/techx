<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreProductCategory extends Model
{
    protected $fillable =['product_category','description','icon'];

    public function products()
    {
    	return $this->hasMany('App\StoreProduct');
    }
}
