<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HireManagerFeedback extends Model
{
    protected $fillable =['hire_manager_id','feedback'];

    public function rules()
    {
        return [
            //Validate form input
        'hire_manager_id'         => 'required',
          'feedback'      => 'required|alpha_dash',
         


        ];


        if ($validation->fails())
        {
            return redirect()->back()->withErrors($v->errors())
            ->withInput(Input::all());
        }
    }

     public function hiremanager()
    {
    	return $this->hasMany('App\HireManager','id');
    }
}
