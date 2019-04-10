<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategoritiket extends Model
{
    public $timestamps = true;
    protected $fillable = ['name'];

    public function Tiket()
    {
    	return $this->hasMany('App\Tiket', 'katiket_id');
    }
}
