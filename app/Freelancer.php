<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    protected $table = 'freelancers';
    protected $fillable =['user_id','overview','freelancer_title'];
public function rules()
    {
        return [
            //Validate form input
        'overview' => 'required|min:100',
        'url'         => 'url',
          
        ];

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($v->errors())
            ->withInput(Input::all());
        }
    }
    public function answers()
    {
        return $this->hasMany('App\FreelancerJobQuestionAnswer');
    }

    public function user()
    {
    	return $this->belongsTo('App\User','id');
    }

    public function proposals()
    {
    	return $this->hasMany('App\Proposal','id');
    }

     public function certificatations()
    {
    	return $this->hasMany('App\Certification','id');
    }

     public function contracts()
    {
    	return $this->hasMany('App\Contract','id');
    }

     public function freelancerfeedbacks()
    {
    	return $this->hasMany('App\FreelancerFeedback','id');
    }

     public function skills()
    {
    	return $this->hasMany('App\HasSkill','id');
    }

     public function testresults()
    {
    	return $this->hasMany('App\TestResult','id');
    }

     public function resumt()
    {
    	return $this->hasOne('App\FreelancerResume','id');
    }

    public function hires()
    {
        return $this->hasMany('App\Hire');
    }

     public function shortlists()
    {
      return $this->hasMany('App\Shortlist');
    }

    public function invitations()
    {
      return $this->hasMany('App\Jobinvitation');
    }
}
