<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nik', 'nama', 'username', 'password', 'telp', 'jenkel', 'foto', 'qr_code', 'email', 'alamat', 'level', 'is_active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function sedekah()
    {
        return $this->hasMany('App\Sedekah', 'user_id');
    }

    public function tabungan()
    {
        return $this->hasOne('App\Tabungan', 'user_id');
    }

    public function penjemputan()
    {
        return $this->hasMany('App\Penjemputan', 'petugas_id');
    }

    // public function routeNotificationForNexmo($notification)
    // {
    //     return $this->telp;
    // }
}
