<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobAdditionalQuestion extends Model
{
    protected $table = 'job_additional_questions';
    protected $fillable =['job_id','question'];

    public function rules()
    {
        return [
            //Validate form input
        'job_id'         => 'required',
          'question'      => 'required|string',
      


        ];

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($v->errors())
            ->withInput(Input::all());
        }
    }

     public function job()
    {
    	return $this->belongsTo('App\Job');
    }

    public function answers()
    {
        return $this->hasMany('App\FreelancerJobQuestionAnswer');
    }
}
