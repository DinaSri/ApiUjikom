<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
   public $timestamps = true;
    protected $fillable = ['harga', 'stok', 'katiket_id',  'event_id'];

    public function Kategoritiket()
    {
        return $this->belongsTo('App\Kategoritiket', 'katiket_id');
    }

    public function Transfer()
    {
        return $this->hasMany('App\Transfer', 'tiket_id');
    }

    public function Event()
    {
        return $this->belongsTo('App\Event', 'event_id');
    }
}
