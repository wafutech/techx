<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobComplexity extends Model
{
    protected $fillable =['complexity_text'];

        public function rules()
    {
        return [
            //Validate form input
        'complexity_text'         => 'required|string',
          
        ];

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($v->errors())
            ->withInput(Input::all());
        }
    }
}
