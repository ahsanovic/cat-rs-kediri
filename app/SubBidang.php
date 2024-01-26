<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubBidang extends Model
{
    protected $table = 'subbidang';
    protected $guarded = [];
 
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('subbidang', 'like', '%'.$query.'%')
                    // ->orWhere('bidang_id', 'like', '%'.$query.'%');
                    ->orWhereHas('bidang', function($q) use ($query) {
                        $q->where('bidang', 'like', '%'.$query.'%');
                    });
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }

    public function soal()
    {
        return $this->hasMany(Soal::class);
    }

    public static function getData()
    {
        return SubBidang::all();
    }
}
