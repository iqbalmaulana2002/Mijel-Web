<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    protected $table = 'tabungan';

    protected $fillable = [
        'user_id', 'saldo'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function penarikan()
    {
        return $this->hasMany('App\Penarikan', 'tabungan_id');
    }
}
