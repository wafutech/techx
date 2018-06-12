<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shortlist extends Model
{
    protected $fillable =['job_id','proposal_id','freelancer_id'];


     public function job()
    {
      return $this->belongsTo('App\Job');
    }

     public function freelancer()
    {
      return $this->belongsTo('App\Freelancer','id');
    }

     public function proposal()
    {
      return $this->hasMany('App\Proposal','id');
    }
}
