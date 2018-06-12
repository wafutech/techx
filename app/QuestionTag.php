<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionTag extends Model
{
	public $timestamps = false;

    protected $fillable =['question_id','tag_id'];

    public function question()
    {
    	return $this->hasOne('App\Question');
    }
}
