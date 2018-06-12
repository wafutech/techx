<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
  protected $fillable = ['question_id','answer','user_id','accepted'];

  public function user()
   {
   	return $this->belongsTo('App\User');
   }

    public function question()
   {
   	return $this->belongsTo('App\Question');
   }
}
