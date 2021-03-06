<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name','display name','description'];

	 public function permission()

    {

        return $this->belongsToMany('App\Permission');

    }

    public function users()

    {
        return $this->belongsToMany('App\User');

    }
}
