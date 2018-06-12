<?php

namespace App;
use Validator;

use Illuminate\Database\Eloquent\Model;

class ProposalAttachment extends Model
{
    protected $fillable =['proposal_id','attachment'];
    
    public function rules()
    {
        $rules = [
            //Validate form input
        'proposal_id'         => 'required',        
         
         'attachment' => 'mimes:pdf,doc,docx,xls,xlsx,pnt|size:5120',


        ];
        $validation = Validator::make(Input::all(),$rules);

        if ($validation->fails())
        {
            return $validation->messages();
        }
    }

       public function proposal()
    {
    	return $this->belongsTo('App\Proposal','id');
    }
}
