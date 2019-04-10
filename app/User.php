<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
   public function Transfer()
    {
        return $this->hasMany('App\Transfer', 'user_id');
    }
    public function Event()
    {
        return $this->hasMany('App\Event', 'user_id');
    }
      public function Bank()
    {
        return $this->hasMany('App\Bank', 'user_id');
    }
}