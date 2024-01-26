<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{ Ujian, UjianSkb };

class LiveController extends Controller
{
    public function index()
    {
        $live = Ujian::with('peserta')->orderBy('nilai_total','desc')->get();
        return view('livescore.index', compact('live'));
        // if ($request->ajax()) {
        //     return response()->json([
        //         'html' => view('livescore.index', compact('live'))->render(),
        //     ]);
        // }
    }

    public function liveSkb()
    {
        $live_skb = UjianSkb::with('pesertaSkb')->orderBy('nilai','desc')->get();
        return view('livescore.skb', compact('live_skb'));
    }

    public function resetWaktuSkb()
    {
        UjianSkb::query()->update(['created_at' => date(request()->waktu)]);
        return redirect()->back()->with('message', 'Reset waktu ujian berhasil');
    }

    public function resetWaktuSkd()
    {
        Ujian::query()->update(['created_at' => date(request()->waktu)]);
        return redirect()->back()->with('message', 'Reset waktu ujian berhasil');
    }
}
