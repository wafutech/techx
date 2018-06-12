<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['team_name','description','owner'];

    public function teams()
    {
    	return $this->hasMany('App\User');
    }
}
