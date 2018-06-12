<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasSkill extends Model
{
    protected $table = 'has_skills';
    protected $fillable = ['freelancer_id','skill_id'];

    public function freelancer()
    {
    	return $this->belongsTo('App\Freelancer','id');
    }

     public function skill()
    {
    	return $this->belongsTo('App\Skill','id');
    }
}
