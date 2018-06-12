<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
// use  CanResetPassword, EntrustUserTrait;
    use   EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function questions()
  {
    return $this->hasMany('App\Question');
  }

   public function votes()
  {
    return $this->hasMany('App\QuestionVote');
  }

   public function answers()
  {
    return $this->hasMany('App\Answer');
  }

   public function useful_answers()
  {
    return $this->hasMany('App\UsefulAnswer');
  }

  public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

     public function technologies()
  {
    return $this->hasMany('App\Technology');
  }



  /**
JWT Authentication
  */

/**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
   public function getJWTCustomClaims()
    {
        return [];
    }

     public function hiremanagers()
    {
        return $this->hasOne('App\HireManager','id');
    }

     public function freelancer()
    {
        return $this->hasOne('App\Freelancer','id');
    }

    public function testimonies()
    {
        return $this->hasMany('App\Testmony');
    }

    public function awards()
    {
        return $this->hasMany('App\Award','id');
    }
    public function chatmessages()
    {
        return $this->hasMany('App\ChatMessage','id');
    }
    
}
