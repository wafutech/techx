<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobSubCategories extends Model
{
     protected $fillable =['job_cat_name','job_cat_desc','cat_icon'];

    public function rules()
    {
        return [
            //Validate form input
        'job_cat_name'         => 'required|string|unique:job_categories',
        'job_cat_desc'      => 'required|alpha_dash',
        'cat_icon'  => 'required|image|mimes:jpg,gif,png',
         

        ];

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($v->errors())
            ->withInput(Input::all());
        }
    }

    public function jobs()
    {
    	return $this->hasMany('App\Job','id');
    }

     public function jobsubcategory()
    {
    	return $this->hasMany('App\SubCategory','id');
    }
}

