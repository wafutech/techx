<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    protected $fillable = ['technology','description','icon','url'];

    public function frameworks()
    {
    	return $this->hasMany('App\TechnologyFramework');
    }

    
}
