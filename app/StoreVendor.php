<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreVendor extends Model
{
    protected $fillable =['user_id','name','about','email','phone','address'];

    public function user()
    {
    	return $this->belongsTo('app\User');
    }

    public function products()
    {

    return $this->hasMany('App\StoreProduct');
    }
}

