<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobInvitation extends Model
{
    protected $fillable = ['job_id','freelancer_id','hire_manager_id'];

    public function freelancers()
    {
    	return $this->belongsTo('App\Freelancer','id');
    }

     public function jobs()
    {
    	return $this->belongsTo('App\Job','id');
    }

     public function managers()
    {
    	return $this->belongsTo('App\HireManager','id');
    }
}
