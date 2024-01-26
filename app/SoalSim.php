<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoalSim extends Model
{
    protected $table = 'soal_sim';
    protected $guarded = [];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function jenis()
    {
        return $this->belongsTo(JenisSoal::class);
    }

    public function subbidang()
    {
        return $this->belongsTo(SubBidang::class);
    }
}
