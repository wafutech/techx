<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobStatus extends Model
{
    protected $fillable = ['status'];

    /*public function job()
    {
    	return $this->belongsTo('App\Job');
    }*/
}
