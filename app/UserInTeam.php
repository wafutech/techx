<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInTeam extends Model
{
    protected $fillable = ['team_id','user_id'];

    public function team()
    { 
    	return $this->belongsTo('App\Team');
    }
    public function user()
    { 
    	return $this->belongsTo('App\User');
    }
}
