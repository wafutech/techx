<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreelancerFeedback extends Model
{
    protected $fillable =['freelancer_id','feedback'];

    public function rules()
    {
        return [
            //Validate form input
        'freelancer_id'         => 'required',
          'feedback'      => 'required|alpha_dash',
         
        ];


        if ($validation->fails())
        {
            return redirect()->back()->withErrors($v->errors())
            ->withInput(Input::all());
        }
    }

     public function freelancer()
    {
    	return $this->hasMany('App\Freelancer','id');
    }
}
