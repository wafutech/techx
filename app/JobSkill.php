<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobSkill extends Model
{
    protected $fillable =['job_id','skill_id'];

    public function job()
    {
    	return $this->belongsTo('App\Job');
    }

     public function skill()
    {
    	return $this->belongsTo('App\Skill');
    }
}
