<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Soal, Peserta, Hasil, Ujian};
use App\{SoalSim, PesertaSim, HasilSim, UjianSimulasi};
use App\{SoalSkb, PesertaSkb, HasilSkb, UjianSkb};

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $soal = Soal::count();
        $peserta = Peserta::count();
        $hasil = Hasil::count();
        $ujian = Ujian::count();

        $soal_sim = SoalSim::count();
        $peserta_sim = PesertaSim::count();
        $hasil_sim = HasilSim::count();
        $ujian_sim = UjianSimulasi::count();

        $soal_skb = SoalSkb::count();
        $peserta_skb = PesertaSkb::count();
        $hasil_skb = HasilSkb::count();
        $ujian_skb = UjianSkb::count();

        return view('admin.home', compact(
            'soal', 'peserta', 'hasil', 'ujian',
            'soal_sim', 'peserta_sim', 'hasil_sim', 'ujian_sim',
            'soal_skb', 'peserta_skb', 'hasil_skb', 'ujian_skb'
            )
        );
    }
}
