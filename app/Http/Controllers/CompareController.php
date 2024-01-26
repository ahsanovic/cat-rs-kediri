<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompareController extends Controller
{
    public function compare()
    {
        $data = DB::table('ujian')->select('kunci', 'jawaban')->first();
        $kunci = explode(',', $data->kunci);
        $jawaban = explode(',', $data->jawaban);
        return view('livescore.compare', compact('kunci', 'jawaban'));
    }

    public function compareskb()
    {
        $data = DB::table('ujian_skb')->select('kunci', 'jawaban')->first();
        $kunci = explode(',', $data->kunci);
        $jawaban = explode(',', $data->jawaban);
        return view('livescore.compare-skb', compact('kunci', 'jawaban'));
    }
}
