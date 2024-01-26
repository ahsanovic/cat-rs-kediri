<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $table = 'bidang';
    protected $guarded = [];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('bidang', 'like', '%'.$query.'%')
                    // ->orWhere('jenis_id', 'like', '%'.$query.'%');
                    ->orWhereHas('jenisSoal', function($q) use ($query) {
                        $q->where('jenis_soal', 'like', '%'.$query.'%');
                    });
    }

    public function jenisSoal()
    {
        return $this->belongsTo(JenisSoal::class, 'jenis_id');
    }

    public function subbidang()
    {
        return $this->hasMany(SubBidang::class);
    }

    public function soal()
    {
        return $this->hasMany(SoalSim::class);
    }

    public static function getData()
    {
        return Bidang::all();
    }
}
