<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilSim extends Model
{
    protected $table = 'hasil_sim';
    
    public function pesertaSim()
    {
        return $this->belongsTo('App\PesertaSim');
    }

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('peserta_sim.nama', 'like', '%'.$query.'%')
                    ->orWhere('peserta_sim.username', 'like', '%'.$query.'%')
                    ->orWhere('peserta_sim.email', 'like', '%'.$query.'%');
    }
}
