<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestAnswerSheet extends Model
{
     protected $fillable = ['question_id','user_id','answer_id','correct_answer'];

    public function answer()
    {
    	return $this->belongsTo('App\TestAnswer','id');
    }

    public function question()
    {
    	return $this->belongsTo('App\TestQuestion','id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User','id');
    }
}
