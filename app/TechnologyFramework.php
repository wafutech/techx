<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechnologyFramework extends Model
{
     protected $fillable = ['framework','description','icon','url','technology_id'];

     public function technology()
     {
     	return $this->belongsTo('App\Technology');
     }
}
