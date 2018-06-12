<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreelancingStat extends Model
{
    protected $fillable = ['freelancer_id','hire_manager_id','job_id'];

    public function freelancer()
    {
    	return $this->belongsTo('App\Freelancer');
    }

    public function manager()
    {
    	return $this->belongsTo('App\HireManager');
    }

    public function job()
    {
    	return $this->belongsTo('App\Job');
    }
}
