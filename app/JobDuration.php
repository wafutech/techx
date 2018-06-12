<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobDuration extends Model
{
    protected $fillable = ['job_id','duration'];

     public function job()
    {
    	return $this->belongsTo('App\Job');
    }
}
