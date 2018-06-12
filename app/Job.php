<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable =['job_name','expected_duration_id','complexity_id','job_desc','main_skill_id','payment_type_id','job_category_id','payment_amount','time_commitment_id','freelancer_experience_id','job_type_id','milestone','hire_manager_id'];

   protected $dates =['date_line'];
    

    public function expectedduration()
    {
    	return $this->belongsTo('App\ExpectedDuration','id');
    }

     public function proposals()
    {
      return $this->hasMany('App\Job','id');
    }

     public function paymenttype()
    {
    	return $this->belongsTo('App\PaymentType','id');
    }

     public function jobcategory()
    {
    	return $this->belongsTo('App\JobCategory','id');
    }

    public function time()
    {
      return $this->belongsTo('App\JobTimeCommitement','id');
    }

    public function freelancelevel()
    {
      return $this->belongsTo('App\FreelancerLevel','id');
    }


    public function projecttype()
    {
      return $this->belongsTo('App\ProjectType','id');
    }


    public function projectlifecycle()
    {
      return $this->belongsTo('App\ProjectLifecycle','id');
    }

     public function attachments()
    {
      return $this->hasMany('App\JobAttachment','id');
    }

     public function questions()
    {
      return $this->hasMany('App\JobAdditionalQuestion','id');
    }

     public function currency()
    {
      return $this->belongsTo('App\Currency','id');
    }

    public function hires()
    {
      return $this->hasMany('App\Hire');
    }

     public function shortlists()
    {
      return $this->hasMany('App\Shortlist','job_id');
    }

     public function invitations()
    {
      return $this->hasMany('App\Jobinvitation');
    }
}
