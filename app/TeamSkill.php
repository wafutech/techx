<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamSkill extends Model
{
    protected $fillable =['team_id','skill_id'];

    public function team()
    {
    	return $this->belongToMany('App\Team');
    }

    public function skill()
    {
    	return $this->belongToMany('App\Skill');
    }
}
