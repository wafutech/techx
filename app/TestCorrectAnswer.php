<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestCorrectAnswer extends Model
{
    protected $fillable =['question_id','answer_id'];
    public function question()
    {
    	return $this->belongsTo('App\TestQuestion');
    }

    public function answer()
    {
    	return $this->belongsTo('App\TestAnswer');
    }
}
