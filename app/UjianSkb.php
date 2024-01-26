<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UjianSkb extends Model
{
    protected $table = 'ujian_skb';

    public function pesertaSkb()
    {
        return $this->belongsTo('App\PesertaSkb');
    }

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('peserta_skb.nama', 'like', '%'.$query.'%')
                    ->orWhere('peserta_skb.nik', 'like', '%'.$query.'%')
                    ->orWhere('peserta_skb.nip', 'like', '%'.$query.'%');
    }
}
