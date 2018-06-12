<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HireManager extends Model
{
    protected $fillable =['company_name','user_id','company_desc','number_of_employees','company_country_id','company_city','company_address','company_zip'];
    

    public function user()
    {
    	return $this->belongsTo('App\User','id');
    }

      public function messages()
    {
        return $this->hasMany('App\Message','id');
    }

     public function feedbacks()
    {
        return $this->hasMany('App\ClientFeedback','id');
    }

    public function hires()
    {
        return $this->hasMany('App\Hire');
    }

     public function invitations()
    {
        return $this->hasMany('App\Jobinvitations');
    }

    public function ratings()
    {
        return $this->hasMany('App\ClientToFreelancerRating');
    }
}
