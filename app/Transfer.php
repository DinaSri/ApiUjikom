<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    public $timestamps = true;
    protected $fillable = ['user_id', 'nominal', 'desc', 'status' ,'jumlah_tiket', 'event_id', 'bank_id','tiket_id'];

    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function Event()
    {
        return $this->belongsTo('App\Event', 'event_id');
    }

    public function Bank()
    {
        return $this->belongsTo('App\Bank', 'bank_id');
    }

      public function Tiket()
    {
        return $this->belongsTo('App\Tiket', 'tiket_id');
    }
}