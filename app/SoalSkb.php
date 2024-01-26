<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoalSkb extends Model
{
    protected $table = 'soal_skb';
    protected $guarded = [];

    public function rumpun()
    {
        return $this->belongsTo(Rumpun::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
