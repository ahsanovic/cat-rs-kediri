<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $guarded = [];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('nama_jabatan', 'like', '%'.$query.'%')
                    ->orWhereHas('rumpun', function($q) use ($query) {
                        $q->where('rumpun_jabatan', 'like', '%'.$query.'%');
                    });
    }

    public function rumpun()
    {
        return $this->belongsTo(Rumpun::class);
    }

    public function soalSkb()
    {
        return $this->hasMany(SoalSkb::class);
    }

    public function pesertaSkb()
    {
        return $this->hasMany('App\PesertaSkb');
    }

    public static function getData()
    {
        return Jabatan::all()->sortBy('nama_jabatan');
    }
}
