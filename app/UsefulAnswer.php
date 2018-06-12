<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsefulAnswer extends Model
{
    protected $fillable =['question_id','user_id','answer_id'];

    public function question()
    {
    	return $this->belongsTo('App\Question');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function answer()
    {
    	return $this->belongsTo('App\Answer');
    }
}
