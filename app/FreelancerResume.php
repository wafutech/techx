<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreelancerResume extends Model
{
    protected $fillable =['freelancer_id','bio_info','education_level_id','portfolio_link','references'];
        public function rules()
    {
        return [
            //Validate form input
        'freelancer_id'         => 'required',
          'bio_info'      => 'required|alpha_dash',
         'education_level_id'      => 'required',
         'portfolio_link'      => 'url',
        'contact_email'      => 'required|email',
         'references'      => 'string',
         


        ];

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($v->errors())
            ->withInput(Input::all());
        }

        public function freelancer()
        {
        	return $this->belongsTo('App\Freelancer','id');
        }


        public function education_level()
        {
        	return $this->belongsTo('App\Educationlevel','id');
        }
}
