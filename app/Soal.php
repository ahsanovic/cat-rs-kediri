<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $table = 'soal';
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
