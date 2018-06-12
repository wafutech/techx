<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hire extends Model
{
     protected $fillable =['hire_manager_id','job_id','freelancer_id'];

    public function hireManager()
    {

    	return $this->belongsTo('App\HireManager');
    }

    public function freelancer()
    {
    	return $this->belongsTo*'App\Freelancer');
    }

    public function job()
    {
    	return $this->belongsTo('App\Job');
    }
}
