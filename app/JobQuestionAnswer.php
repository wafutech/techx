<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobQuestionAnswer extends Model
{
   protected $fillable =['question_id','freelancer_id','answer'];

   public function job_question()
   {
   	return $this->belongsTo('App\JobQuestion');
   }
}
