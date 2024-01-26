<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rumpun extends Model
{
    protected $table = 'rumpun';
    protected $guarded = [];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('rumpun_jabatan', 'like', '%'.$query.'%');
    }

    public function jabatan()
    {
        return $this->hasMany(Jabatan::class);
    }

    public function soalSkb()
    {
        return $this->hasMany(SoalSkb::class);
    }

    public static function getData()
    {
        return Rumpun::all()->sortBy('rumpun_jabatan');
    }
}
