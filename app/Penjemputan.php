<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjemputan extends Model
{
    protected $table = 'penjemputan';

    protected $fillable = [
        'petugas_id', 'sedekah_id', 'tanggal', 'berangkat', 'sampai', 
    ];

    public function petugas()
    {
        return $this->belongsTo('App\User', 'petugas_id');
    }

    public function sedekah()
    {
        return $this->belongsTo('App\Sedekah', 'sedekah_id');
    }
}
