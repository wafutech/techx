<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionCategory extends Model
{
	protected $fillable = ['category','description'];
   
   public function questions()
  {
    return $this->hasMany('App\Question');
  }
}
