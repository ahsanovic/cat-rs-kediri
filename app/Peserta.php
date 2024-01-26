<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticable;
use DB;

class Peserta extends Authenticable
{
    use Notifiable;
    protected $table = 'peserta';

    protected $guarded = [];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('nama', 'like', '%'.$query.'%')
                    ->orWhere('nik', 'like', '%'.$query.'%')
                    ->orWhere('nip', 'like', '%'.$query.'%');
    }

    public static function getSesi()
    {
        return DB::table('peserta')
                ->select('sesi')
                ->groupBy('sesi')
                ->get();
    }
}
