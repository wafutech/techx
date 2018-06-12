<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable =['job_id','freelancer_id','payment_type_id','cover_letter','payment_amount','current_proposal_status_id','client_grade','freelancer_grade','client_comment','freelancer_comment'];

   
     public function contracts()
    {
    	return $this->hasMany('App\Contract','id');
    }


     public function attachments()
    {
    	return $this->hasMany('App\ProposalAttachment');
    }

     public function job()
    {
    	return $this->belongsTo('App\Job');
    }

       public function freelancer()
    {
    	return $this->belongsTo('App\Freelancer');
    }

       public function paymentype()
    {
    	return $this->belongsTo('App\PaymentType');
    }

       public function status()
    {
    	return $this->belongsTo('App\ProposalStatus');
    }

    public function milestones()
    {
        return $this->hasMany('App\Projectmilestone');
    }

     public function shortlists()
    {
      return $this->hasMany('App\Shortlist');
    }
}
