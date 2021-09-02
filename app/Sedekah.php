<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sedekah extends Model
{
    protected $table = 'sedekah';

    protected $fillable = [
        'user_id', 'tanggal', 'status', 'jumlah', 'harga', 'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function penjemputan()
    {
        return $this->hasOne('App\Penjemputan', 'sedekah_id');
    }
}
