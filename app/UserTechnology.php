<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTechnology extends Model
{
    protected $fillable = ['user_id','technology_id'];

    public function technology()
    {
    	return $this->belongsTo('App\Technology');
    }

     public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
