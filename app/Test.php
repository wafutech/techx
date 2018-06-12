<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable =['test_name','test_link','test_level_id'];

    public function rules()
    {
       

    public function results()
    {
    	return $this->hasMany('App\TestResult','id');
    }

     public function testslevels()
    {
    return $this->hasMany('App\TestLevel','id');

    }
}
