<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobTimeCommitment extends Model
{
    protected $fillable =['job_id','freelancer_id','time'];

    public function job()
    {
    	return $this->belongsTo('App\Job');
    }

     public function freelancer()
    {
    	return $this->belongsTo('App\Freelancer');
    }
}
