<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionVote extends Model
{
   protected $fillable = ['question_id','user_id','vote'];

   public function user()
   {
   	return $this->belongsTo('App\User');
   }

    public function question()
   {
   	return $this->belongsTo('App\Question');
   }
}
