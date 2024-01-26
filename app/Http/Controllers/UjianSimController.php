<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UjianSimulasi;
use App\SoalSim;
use App\HasilSim;
use App\History;
use Auth;

class UjianSimController extends Controller
{
    public function index()
    {
        return view('simulasi.index');
    }

    public function show(Request $request, $id)
    {  
        // Prevent user go into ujian/0, ujian/100++
        // Prevent user go into ujian/finish ujian/hasil when ujian not started
        $count_peserta = UjianSimulasi::where('peserta_sim_id', '=', Auth::guard('peserta-sim')->user()->id)->count();
        if($id < 1 || $id > 100 || $count_peserta < 1){
            return redirect('simulasi/ujian');
            // return response()->json([
            //     'success' => false,
            // ]);
        }

        // Get necessary information (soal and jawaban column) from ujians table in DB
        $info_db = UjianSimulasi::select('soal','jawaban')->where('peserta_sim_id', '=', Auth::guard('peserta-sim')->user()->id)->first();

        // Convert string separated by comma of "random question id" into array
        $nomor_soal_acak = explode(',', $info_db->soal);

        // Convert string separated by comma of "jawaban user" into array
        $jawaban_user = explode(',', $info_db->jawaban);

        // Get requested question
        $soal = SoalSim::find($nomor_soal_acak[$id-1]);

        // Get created_at ujian time for timer countdown
        $waktu = UjianSimulasi::select('created_at')->where('peserta_sim_id', '=', Auth::guard('peserta-sim')->user()->id)->first();
        $waktu = $waktu->created_at->timestamp;

        // Count how much the empty answer
        for ($i = 0, $j = 0; $i < 100; $i++) { 
          if ($jawaban_user[$i] == '0') {
                $j++;
            }
        }

        if($request->ajax()) {
            return response()->json([
                'view' => view('simulasi.tes',compact('soal'))->with('nomor_sekarang',$id)->with('jawaban',$jawaban_user)->with('waktu',$waktu)->with('jawaban_kosong', $j)->render(),
            ]);
        }
    }

    public function store(Request $request)
    {
        $count_peserta = UjianSimulasi::where('peserta_sim_id', '=', Auth::guard('peserta-sim')->user()->id)->count();
        if ($count_peserta > 0) {
            return redirect('simulasi/ujian/1');
        } else {
            // Assign random question id for each category
            $soal = SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',4)->where('subbidang_id',10)->inRandomOrder()->take(1)->get();    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',4)->where('subbidang_id',11)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',4)->where('subbidang_id',12)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',4)->where('subbidang_id',13)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',5)->where('subbidang_id',14)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',5)->where('subbidang_id',15)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',5)->where('subbidang_id',16)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',5)->where('subbidang_id',17)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',5)->where('subbidang_id',18)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',5)->where('subbidang_id',19)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',5)->where('subbidang_id',20)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',5)->where('subbidang_id',21)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',6)->where('subbidang_id',23)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',6)->where('subbidang_id',25)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',6)->where('subbidang_id',26)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',6)->where('subbidang_id',27)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',6)->where('subbidang_id',28)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',6)->where('subbidang_id',29)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',7)->where('subbidang_id',30)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',7)->where('subbidang_id',31)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',7)->where('subbidang_id',32)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',7)->where('subbidang_id',33)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',8)->where('subbidang_id',34)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',8)->where('subbidang_id',35)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',8)->where('subbidang_id',36)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',9)->where('subbidang_id',37)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',9)->where('subbidang_id',38)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',9)->where('subbidang_id',39)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',9)->where('subbidang_id',40)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',9)->where('subbidang_id',41)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',9)->where('subbidang_id',42)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);

            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',1)->where('subbidang_id',1)->inRandomOrder()->take(5)->get());
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',1)->where('subbidang_id',2)->inRandomOrder()->take(4)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',1)->where('subbidang_id',3)->inRandomOrder()->take(3)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',1)->where('subbidang_id',4)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',2)->where('subbidang_id',5)->inRandomOrder()->take(3)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',2)->where('subbidang_id',6)->inRandomOrder()->take(4)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',2)->where('subbidang_id',7)->inRandomOrder()->take(2)->get());  // bidang kuantitatif, subbidang geometrika  
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',3)->where('subbidang_id',8)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',3)->where('subbidang_id',9)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);

            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',15)->where('subbidang_id',53)->inRandomOrder()->take(3)->get()); // figural
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',10)->where('subbidang_id',43)->inRandomOrder()->take(6)->get());    
            $soal = $soal->merge($idtambah);    
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',10)->where('subbidang_id',44)->inRandomOrder()->take(5)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',11)->where('subbidang_id',45)->inRandomOrder()->take(3)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',11)->where('subbidang_id',46)->inRandomOrder()->take(3)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',12)->where('subbidang_id',47)->inRandomOrder()->take(3)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',12)->where('subbidang_id',48)->inRandomOrder()->take(3)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',13)->where('subbidang_id',49)->inRandomOrder()->take(3)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',13)->where('subbidang_id',50)->inRandomOrder()->take(3)->get());    
            $soal = $soal->merge($idtambah);
    
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',14)->where('subbidang_id',51)->inRandomOrder()->take(3)->get());    
            $soal = $soal->merge($idtambah);
            $idtambah = (SoalSim::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',14)->where('subbidang_id',52)->inRandomOrder()->take(3)->get());   
            $soal = $soal->merge($idtambah);
    
            // Convert collection of "random question id" and "kunci" into string separated by comma
            $id_soal = $soal->implode('id',',');
            $kunci_soal = $soal->implode('jawaban',',');
    
            // Initiate the "array of user answer" with '0' value
            for ($i = 0; $i < 100 ; $i++) {
                $jawaban_kosong[$i] = '0';
            }
    
            // Convert "array of user answer" into string separated by comma
            $jawaban_kosong = implode(',', $jawaban_kosong);
    
            // Insert string of "random questionid" and "answer" into ujians table in DB
            $ujian = new UjianSimulasi;
            $ujian->soal = $id_soal;
            $ujian->peserta_sim_id = Auth::guard('peserta-sim')->user()->id;
            $ujian->kunci = $kunci_soal;
            $ujian->jawaban = $jawaban_kosong;
            $ujian->save();
    
            return response()->json(['msg' => 'success']);
        }
    }

    public function update(Request $request, $id)
    { 
        $count = UjianSimulasi::where('peserta_sim_id', '=', Auth::guard('peserta-sim')->user()->id)->count();        
        if ($count == 0) {
            return response()->json(['error' => true]);
        }

        // Get necessary information (jawaban column) from ujians table in DB
        $info_db = UjianSimulasi::select('jawaban')->where('peserta_sim_id', '=', Auth::guard('peserta-sim')->user()->id)->first();

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
        $update = UjianSimulasi::where('peserta_sim_id', Auth::guard('peserta-sim')->user()->id)->first();
        $update->jawaban = $jawaban_user;
        $update->save();

        // Get user ujian data
        $ujian = UjianSimulasi::where('peserta_sim_id', '=', Auth::guard('peserta-sim')->user()->id)->first();

        // Convert string separated by comma of "jawaban" column into array
        $jawaban = explode(',', $ujian->jawaban);

        // Convert string separated by comma of "kunci" column into array
        $kunci = explode(',', $ujian->kunci);

        // Initiate nilai counter
        $tiu = 0;
        $twk = 0;
        $tkp = 0;

        // Compare user "jawaban" with "kunci"
        for ($i = 0; $i < 100 ; $i++) { 
            if ($i < 35) {
                if ($jawaban[$i] == $kunci[$i]) {
                    $twk += 5;
                } 
            }
            else if ($i > 34 && $i < 65) {
                if ($jawaban[$i] == $kunci[$i]) {
                    $tiu += 5;
                }
            }
            else if ($i > 64 && $i < 100) {
                $kunci_tkp = $kunci[$i];
                for ($j = 0; $j < 5; $j++) {
                    if ($jawaban[$i] == $kunci_tkp[$j]) {  
                    if ($j == 0) {$tkp += 5;}
                    else if ($j == 1) {$tkp += 4;}
                    else if ($j == 2) {$tkp += 3;}
                    else if ($j == 3) {$tkp += 2;}
                    else if ($j == 4) {$tkp += 1;}
                    }
                }    
            }            
        }

        // Insert user nilai into Hasil table in DB
        $nilai = UjianSimulasi::where('peserta_sim_id', Auth::guard('peserta-sim')->user()->id)->first();
        $nilai->nilaitwk = $twk;
        $nilai->nilaitiu = $tiu;
        $nilai->nilaitkp = $tkp;
        $nilai->nilai_total = $twk + $tiu + $tkp;
        $nilai->save();

        // Answering 100th number redirecting user back to the page, instead of 101th number
        if ($id == 100) {
            return response()->json(['max' => true]);
        }

        return response()->json(['msg' => 'success']);
    }

    public function destroy($id)
    { /*  When user click Selesai Ujian button do save hasil and delete ujian record  */
        $count = UjianSimulasi::where('peserta_sim_id', '=', $id)->count();
        
        if ($count == 0) {
            return redirect('ujian/hasil');
        }
        // Get user ujian data
        $ujian = UjianSimulasi::where('peserta_sim_id', '=', $id)->first();

        // move nilai from table ujian to table hasil
        $hasil = new HasilSim;
        $hasil->peserta_sim_id = $ujian->peserta_sim_id;
        $hasil->ujian_id = $ujian->id;
        $hasil->nilaitwk = $ujian->nilaitwk;
        $hasil->nilaitiu = $ujian->nilaitiu;
        $hasil->nilaitkp = $ujian->nilaitkp;
        $hasil->nilai_total = $ujian->nilai_total;
        $hasil->save();

        // move nilai from table ujian to table history
        $history = new History;
        $history->ujian_id = $ujian->id;
        $history->peserta_sim_id = $ujian->peserta_sim_id;
        $history->soal = $ujian->soal;
        $history->jawaban = $ujian->jawaban;
        $history->kunci = $ujian->kunci;
        $history->save();

        // Delete ujian record
        $ujian->delete();
        
        return response()->json([
            'view' => view('simulasi.hasil')->with('hasil', $hasil)->render()
        ]);
    }

}
