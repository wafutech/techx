<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestAnswer extends Model
{
    protected $fillable = ['question_id','answer'];

    public function question()
    {
    	return $this->belongsTo('App\TestQuestion','id');
    }
}
