<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categori extends Model
{
    	public $timestamps = true;
    protected $fillable = ['image', 'name'];

    public function Event()
    {
    	return $this->hasMany('App\Event', 'category_id');
    }
}
