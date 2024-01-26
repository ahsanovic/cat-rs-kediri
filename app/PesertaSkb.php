<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticable;
use DB;

class PesertaSkb extends Authenticable
{
    use Notifiable;
    protected $table = 'peserta_skb';

    protected $guarded = [];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('nama', 'like', '%'.$query.'%')
                    ->orWhere('nik', 'like', '%'.$query.'%')
                    ->orWhere('nip', 'like', '%'.$query.'%');
    }

    public function jabatan()
    {
        return $this->belongsTo('App\Jabatan');
    }

    public static function getSesi()
    {
        return DB::table('peserta_skb')
                ->select('sesi')
                ->groupBy('sesi')
                ->get();
    }
}
