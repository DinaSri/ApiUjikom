<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterBank extends Model
{
     public $timestamps = true;
    protected $fillable = ['image', 'name'];

    public function Bank()
    {
    	return $this->hasMany('App\Bank', 'master_bank_id');
    }
}
