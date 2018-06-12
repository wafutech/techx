<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable =['proposal_id','company_id','freelancer_id','start_date','end_date','payment_type_id','payment_amount'];

        public function rules()
    {
        return [
            //Validate form input
        'proposal_id'         => 'required',
          'company_id'      => 'required',
         'freelancer_id'      => 'required',
         'start_date'      => 'required|date',
        'end_date'      => 'required|date',
         'payment_type_id'      => 'required',
         'payment_amount'      => 'required|numeric',
         
         


        ];

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($v->errors())
            ->withInput(Input::all());
        }

}
