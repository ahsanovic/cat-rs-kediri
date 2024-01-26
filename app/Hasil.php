<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    protected $table = 'hasil';
    
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
