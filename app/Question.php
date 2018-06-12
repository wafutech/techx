<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
  protected $fillable = ['question','question_detail','category_id','user_id'];

  public function user()
  {
  	return $this->belongsTo('App\User');
  }

  public function question_category()
  {
  	return $this->belongsTo('App\QuestionCategory');
  }

  public function answers()
  {
    return $this->hasMany('App\Answer');
  }

  public function tags()
  {
    return $this->hasMany('App\Tag');
  }

  public function votes()
  {
    return $this->hasMany('App\QuestionVote');
  }
}
