<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    protected $table = 'ujian';

    public function peserta()
    {
        return $this->belongsTo('App\Peserta');
    }

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('peserta.nama', 'like', '%'.$query.'%')
                    ->orWhere('peserta.nik', 'like', '%'.$query.'%')
                    ->orWhere('peserta.nip', 'like', '%'.$query.'%');
    }
}
