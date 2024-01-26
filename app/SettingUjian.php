<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingUjian extends Model
{
    protected $table = 'setting_ujian';
    protected $guarded = [];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('jenis_ujian', 'like', '%'.$query.'%');
    }

    public static function getData()
    {
        return SettingUjian::all();
    }
}
