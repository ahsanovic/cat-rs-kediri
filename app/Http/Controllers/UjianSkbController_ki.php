<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UjianSkb;
use App\PesertaSkb;
use App\SoalSkb;
use App\HasilSkb;
use Auth;

class UjianSkbController extends Controller
{
    public function index()
    {
        $count = HasilSkb::where('peserta_skb_id', '=', Auth::guard('peserta-skb')->user()->id)->count();
        $hasil = HasilSkb::where('peserta_skb_id', '=', Auth::guard('peserta-skb')->user()->id)->first();
        $peserta = PesertaSkb::where('id', '=', Auth::guard('peserta-skb')->user()->id)->with('jabatan')->first();
        if ($count > 0) {
            return view('skb.hasil', compact('hasil'));
        } else {
            return view('skb.index', compact('peserta'));
        }
    }

    public function show(Request $request, $id)
    {
        // Prevent user go into ujian/0, ujian/100++
        // Prevent user go into ujian/finish ujian/hasil when ujian not started
        $count_peserta = UjianSkb::where('peserta_skb_id', '=', Auth::guard('peserta-skb')->user()->id)->count();
        // if($id < 1 || $id > 100 || $count_peserta < 1) {
        if($id < 1 || $id > 25 || $count_peserta < 1){
            return redirect('skb/ujian');
            // return response()->json([
            //     'success' => false,
            // ]);
        }

        // get info peserta
        $peserta = PesertaSkb::where('id', '=', Auth::guard('peserta-skb')->user()->id)->with('jabatan')->first();

        // Get necessary information (soal and jawaban column) from ujians table in DB
        $info_db = UjianSkb::select('soal','jawaban')->where('peserta_skb_id', '=', Auth::guard('peserta-skb')->user()->id)->first();

        // Convert string separated by comma of "random question id" into array
        $nomor_soal_acak = explode(',', $info_db->soal);

        // Convert string separated by comma of "jawaban user" into array
        $jawaban_user = explode(',', $info_db->jawaban);

        // Get requested question
        $soal = SoalSkb::find($nomor_soal_acak[$id - 1]);

        // Get created_at ujian time for timer countdown
        $waktu = UjianSkb::select('created_at')->where('peserta_skb_id', '=', Auth::guard('peserta-skb')->user()->id)->first();
        $waktu = $waktu->created_at->timestamp;

        // Count how much the empty answer
        // for ($i = 0, $j = 0; $i < 100; $i++) {
        for ($i = 0, $j = 0; $i < 25; $i++) {
            if ($jawaban_user[$i] == '0') {
                $j++;
            }
        }

        if($request->ajax()) {
            return response()->json([
                'view' => view('skb.tes',compact('soal', 'peserta'))
                        ->with('nomor_sekarang',$id)
                        ->with('jawaban',$jawaban_user)
                        ->with('waktu',$waktu)
                        ->with('jawaban_kosong', $j)
                        ->render(),
            ]);
        }
    }

    public function store(Request $request)
    {
        $count_peserta = UjianSkb::where('peserta_skb_id', '=', Auth::guard('peserta-skb')->user()->id)->count();
        if ($count_peserta > 0) {
            return redirect('skb/ujian/1');
        } else {
            // Assign random question
            // $soal = SoalSkb::select('id','jawaban')->where('jabatan_id', Auth::guard('peserta-skb')->user()->jabatan_id)->inRandomOrder()->take(100)->get();
            $soal = SoalSkb::select('id','jawaban')->where('jabatan_id', Auth::guard('peserta-skb')->user()->jabatan_id)->inRandomOrder()->take(25)->get();

            // Convert collection of "random question id" and "kunci" into string separated by comma
            $id_soal = $soal->implode('id',',');
            $kunci_soal = $soal->implode('jawaban',',');

            // Initiate the "array of user answer" with '0' value
            for ($i = 0; $i < 25 ; $i++) {
                $jawaban_kosong[$i] = '0';
            }

            // Convert "array of user answer" into string separated by comma
            $jawaban_kosong = implode(',', $jawaban_kosong);

            // Insert string of "random questionid" and "answer" into ujians table in DB
            $ujian = new UjianSkb;
            $ujian->soal = $id_soal;
            $ujian->peserta_skb_id = Auth::guard('peserta-skb')->user()->id;
            $ujian->kunci = $kunci_soal;
            $ujian->jawaban = $jawaban_kosong;
	    $ujian->status = 0;
            $ujian->save();

            return response()->json(['msg' => 'success']);
        }
    }

    public function update(Request $request, $id)
    {
        $count = UjianSkb::where('peserta_skb_id', '=', Auth::guard('peserta-skb')->user()->id)->count();
        if ($count == 0) {
            return response()->json(['error' => true]);
        }

        // Get necessary information (jawaban column) from ujians table in DB
        $info_db = UjianSkb::select('jawaban')->where('peserta_skb_id', '=', Auth::guard('peserta-skb')->user()->id)->first();

        // Convert string separated by comma of "jawaban" column into array
        $jawaban_user = explode(',', $info_db->jawaban);

        // Replace value of current number "jawaban user" array with user answer on page
        if ($request->input('opsi') == '') {
            $jawaban_user[$id-1] = 0;
        } else {
            $jawaban_user[$id-1] = $request->input('opsi');
        }

        // Re-Convert array of "jawaban" into string separated by comma
        $jawaban_user = implode(',', $jawaban_user);

        // Update string of "jawaban" into ujians table in DB
        $update = UjianSkb::where('peserta_skb_id', Auth::guard('peserta-skb')->user()->id)->first();
        $update->jawaban = $jawaban_user;
        $update->save();

        // Get user ujian data
        $ujian = UjianSkb::where('peserta_skb_id', '=', Auth::guard('peserta-skb')->user()->id)->first();

        // Convert string separated by comma of "jawaban" column into array
        $jawaban = explode(',', $ujian->jawaban);

        // Convert string separated by comma of "kunci" column into array
        $kunci = explode(',', $ujian->kunci);

        // Initiate nilai counter
        $nilai = 0;

        // Compare user "jawaban" with "kunci"
        for ($i = 0; $i < 25 ; $i++) {
            if ($jawaban[$i] == $kunci[$i]) {
                $nilai += 2;
            }
        }

        // Insert user nilai into Hasil table in DB
        $score = UjianSkb::where('peserta_skb_id', Auth::guard('peserta-skb')->user()->id)->first();
        $score->nilai = $nilai;
        $score->save();

        // Answering 100th number redirecting user back to the page, instead of 101th number
        if ($id == 25) {
            return response()->json(['max' => true]);
        }

        return response()->json(['msg' => 'success']);
    }

    public function destroy($id)
    { /*  When user click Selesai Ujian button do save hasil and delete ujian record  */
        $count = UjianSkb::where('peserta_skb_id', '=', $id)->count();

        if ($count == 0) {
            return redirect('ujian/hasil');
        }
        // Get user ujian data
        $ujian = UjianSkb::where('peserta_skb_id', '=', $id)->first();
	$ujian->status = 1;
        $ujian->save();

        // move nilai from table ujian to table hasil
        $hasil = new HasilSkb;
        $hasil->peserta_skb_id = $ujian->peserta_skb_id;
        $hasil->nilai = $ujian->nilai;
	$hasil->waktu_mulai = $ujian->created_at;
        $hasil->save();

        // Delete ujian record
        //$ujian->delete();

        return response()->json([
            'view' => view('skb.hasil')->with('hasil', $hasil)->render()
        ]);
    }

}
