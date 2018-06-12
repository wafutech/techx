<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    protected $fillable = ['test_id','question'];

    public function test()
    {
    	return $this->belongsTo('App\Test','id');
    }

    public function answersheets()
    {
    	return $this->hasMany('App\TestAnswerSheet','id');
    }
}
