<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticable;

class PesertaSim extends Authenticable
{
    use Notifiable;
    protected $table = 'peserta_sim';
    protected $fillable = ['nama', 'username', 'email', 'password'];
    protected $hidden = 'password';
    protected $guard = 'peserta-sim';

    public function ujianSimulasi()
    {
        return $this->hasOne('App\UjianSimulasi', 'peserta_sim_id');
    }

    public function hasilSimulasi()
    {
        return $this->hasMany('App\HasilSim', 'peserta_sim_id');
    }

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('nama', 'like', '%'.$query.'%')
                    ->orWhere('username', 'like', '%'.$query.'%')
                    ->orWhere('email', 'like', '%'.$query.'%');
    }
}
