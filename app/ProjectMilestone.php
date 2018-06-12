<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectMilestone extends Model
{
     protected $fillable =['proposal_id','milestone_desc','start_date','end_date','cost'];

    public function proposal()
    {
    	return $this->belongsTo('App\Proposal');
    }
}
