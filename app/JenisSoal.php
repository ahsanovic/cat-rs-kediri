<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisSoal extends Model
{
    protected $table = 'jenis_soal';
    protected $guarded = [];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('jenis_soal', 'like', '%'.$query.'%');
    }

    public function bidang()
    {
        return $this->hasMany(Bidang::class);
    }

    public function soal()
    {
        return $this->hasMany(SoalSim::class);
    }

    public static function getData()
    {
        return JenisSoal::all();
    }
}
