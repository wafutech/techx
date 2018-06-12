<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobAttachment extends Model
{
    protected $table ='job_attachments';
    protected $fillable =['job_id','job_attachment'];
     public function job()
    {
      return $this->belongsTo('App\Job');
    }
}
