<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penarikan extends Model
{
    protected $table = 'penarikan';

    protected $fillable = [
        'tabungan_id', 'jumlah', 'is_transfer'
    ];

    public function tabungan()
    {
        return $this->belongsTo('App\Tabungan', 'tabungan_id');
    }
}
