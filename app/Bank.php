<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
   public $timestamps = true;
    protected $fillable = [ 'number','master_bank_id','user_id'];


    public function MasterBank()
    {
        return $this->belongsTo('App\MasterBank', 'master_bank_id');
    }

   public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function Transfer()
    {
        return $this->hasMany('App\Transfer', 'bank_id');
    }
}