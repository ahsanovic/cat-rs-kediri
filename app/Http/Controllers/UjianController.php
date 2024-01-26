<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ujian;
use App\Soal;
use App\Hasil;
use Auth;

class UjianController extends Controller
{
    public function index()
    {
	//if (Auth::guard('peserta')->user()->blokir == 'Y') {
        $count = Hasil::where('peserta_id', '=', Auth::guard('peserta')->user()->id)->count();
        $hasil = Hasil::where('peserta_id', '=', Auth::guard('peserta')->user()->id)->first();
        if ($count > 0) {
            return view('tes.hasil', compact('hasil'));
        } else {
            return view('tes.index');
        }
	//}
    }

    public function show(Request $request, $id)
    {  
        // Prevent user go into ujian/0, ujian/100++
        // Prevent user go into ujian/finish ujian/hasil when ujian not started
        $count_peserta = Ujian::where('peserta_id', '=', Auth::guard('peserta')->user()->id)->count();
        if($id < 1 || $id > 100 || $count_peserta < 1){
            return redirect('ujian');
            // return response()->json([
            //     'success' => false,
            // ]);
        }

        // Get necessary information (soal and jawaban column) from ujians table in DB
        $info_db = Ujian::select('soal','jawaban')->where('peserta_id', '=', Auth::guard('peserta')->user()->id)->first();

        // Convert string separated by comma of "random question id" into array
        $nomor_soal_acak = explode(',', $info_db->soal);

        // Convert string separated by comma of "jawaban user" into array
        $jawaban_user = explode(',', $info_db->jawaban);

        // Get requested question
        $soal = Soal::find($nomor_soal_acak[$id-1]);

        // Get created_at ujian time for timer countdown
        $waktu = Ujian::select('created_at')->where('peserta_id', '=', Auth::guard('peserta')->user()->id)->first();
        $waktu = $waktu->created_at->timestamp;

        // Count how much the empty answer
        for ($i = 0, $j = 0; $i < 100; $i++) { 
            if ($jawaban_user[$i] == '0') {
                $j++;
            }
        }

        if($request->ajax()) {
            return response()->json([
                'view' => view('tes.tes',compact('soal'))->with('nomor_sekarang',$id)->with('jawaban',$jawaban_user)->with('waktu',$waktu)->with('jawaban_kosong', $j)->render(),
            ]);
        }
    }

    public function store(Request $request)
    {
        $count_peserta = Ujian::where('peserta_id', '=', Auth::guard('peserta')->user()->id)->count();
        if ($count_peserta > 0) {
            return redirect('ujian/1');
        } else {
            // Assign random question id for each category

            /* TWK */
            // pancasila:historis  
            $soal = Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',4)->where('subbidang_id',10)->inRandomOrder()->take(1)->get();  

            // pancasila:penghayatan
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',4)->where('subbidang_id',11)->inRandomOrder()->take(1)->get()); 
            $soal = $soal->merge($idtambah);
            
            // UUD 1945 : Pembukaan
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',4)->where('subbidang_id',12)->inRandomOrder()->take(2)->get());     
            $soal = $soal->merge($idtambah);
            
            // UUD 1945 : Batang Tubuh   
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',4)->where('subbidang_id',13)->inRandomOrder()->take(2)->get()); 
            $soal = $soal->merge($idtambah);
            
            // Sistem Adm. Negara RI periode ORLA
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',5)->where('subbidang_id',14)->inRandomOrder()->take(1)->get()); 
            $soal = $soal->merge($idtambah);
            
            // Sistem Adm. Negara RI periode ORBA
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',5)->where('subbidang_id',15)->inRandomOrder()->take(1)->get()); 
            $soal = $soal->merge($idtambah);
            
            // Sistem Adm. Negara RI periode Reformasi
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',5)->where('subbidang_id',16)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Hubungan Pemerintah Pusat & Pemerintah Daerah
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',5)->where('subbidang_id',17)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Pemerintah Provinsi
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',5)->where('subbidang_id',18)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Pemerintah Kabupaten / Kota
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',5)->where('subbidang_id',19)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Legislatif Daerah
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',5)->where('subbidang_id',20)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Kerja Sama Regional
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',5)->where('subbidang_id',21)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);
            
            // 	Teori Ekonomi Klasik & Neo-Klasik
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',6)->where('subbidang_id',23)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Sistem Ekonomi Indonesia : Dasar Filosofi & Yuridis
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',6)->where('subbidang_id',25)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Koperasi
            /* $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',6)->where('subbidang_id',26)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah); */
            
            // Teori Fiskal & Moneter *
            /* $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',6)->where('subbidang_id',27)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah); */
            
            // 	Kebijakan Fiskal & Moneter Indonesia
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',6)->where('subbidang_id',28)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Perjanjian & Perdagangan Internasional
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',6)->where('subbidang_id',29)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Sejarah Dunia
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',7)->where('subbidang_id',30)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Sejarah Kebangsaan & Lokal
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',7)->where('subbidang_id',31)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Pluralisme : Etnik
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',7)->where('subbidang_id',32)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Pluralisme : Agama
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',7)->where('subbidang_id',33)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Wawasan Nusantara
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',8)->where('subbidang_id',34)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Dasar Yuridis Sistem Pertahanan & Keamanan
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',8)->where('subbidang_id',35)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Pertahanan Tingkat Lokal *
            /* $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',8)->where('subbidang_id',36)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah); */
            
            // Sejarah Pemikiran Hukum
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',9)->where('subbidang_id',37)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Hukum Tata Negara
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',9)->where('subbidang_id',38)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);
            
            // Hukum Perdana-Perdata
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',9)->where('subbidang_id',39)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Hak Asasi Manusia
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',9)->where('subbidang_id',40)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Demokrasi : Kelembagaan
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',9)->where('subbidang_id',41)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);
            
            // Demokrasi : Praktek
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',9)->where('subbidang_id',42)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);

            // Bahasa Indonesia
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',1)->where('bidang_id',16)->where('subbidang_id',54)->inRandomOrder()->take(3)->get());    
            $soal = $soal->merge($idtambah);

            /* TIU */
            // Sinonim
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',1)->where('subbidang_id',1)->inRandomOrder()->take(2)->get());
            $soal = $soal->merge($idtambah);
            
            // Antonim
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',1)->where('subbidang_id',2)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);
            
            // Analogi
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',1)->where('subbidang_id',3)->inRandomOrder()->take(3)->get());    
            $soal = $soal->merge($idtambah);
            
            // Pemahaman Wacana
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',1)->where('subbidang_id',4)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);
            
            // Deret Angka
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',2)->where('subbidang_id',5)->inRandomOrder()->take(3)->get());    
            $soal = $soal->merge($idtambah);
            
            // Aritmatika
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',2)->where('subbidang_id',6)->inRandomOrder()->take(4)->get());    
            $soal = $soal->merge($idtambah);
            
            // Geometrika
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',2)->where('subbidang_id',7)->inRandomOrder()->take(2)->get());
            $soal = $soal->merge($idtambah);
            
            // Penalaran Logis
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',3)->where('subbidang_id',8)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);
            
            // Penalaran Analitis
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',3)->where('subbidang_id',9)->inRandomOrder()->take(3)->get());    
            $soal = $soal->merge($idtambah);

            // Figural - Analogi
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',15)->where('subbidang_id',53)->inRandomOrder()->take(3)->get());
            $soal = $soal->merge($idtambah);

            // Figural - Ketidaksamaan
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',15)->where('subbidang_id',55)->inRandomOrder()->take(2)->get());
            $soal = $soal->merge($idtambah);

            // Figural - Serial
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',2)->where('bidang_id',15)->where('subbidang_id',56)->inRandomOrder()->take(2)->get());
            $soal = $soal->merge($idtambah);
            
            /* TKP */
            // Pelayanan Publik
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',17)->where('subbidang_id',57)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);

            // Perubahan
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',10)->where('subbidang_id',43)->inRandomOrder()->take(1)->get());    
            $soal = $soal->merge($idtambah);    

            // Teknologi Informasi & Komunikasi
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',20)->where('subbidang_id',60)->inRandomOrder()->take(3)->get());    
            $soal = $soal->merge($idtambah);
            
            // Pendapat
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',10)->where('subbidang_id',44)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);
            
            // Pengendalian Emosi
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',11)->where('subbidang_id',45)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);
            
            // Sikap Tenang
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',11)->where('subbidang_id',46)->inRandomOrder()->take(3)->get());    
            $soal = $soal->merge($idtambah);
            
            // Fokus pada Tugas
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',12)->where('subbidang_id',47)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);

            // Sosial Budaya
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',19)->where('subbidang_id',59)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);
            
            // Meningkatkan Kinerja
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',12)->where('subbidang_id',48)->inRandomOrder()->take(3)->get());    
            $soal = $soal->merge($idtambah);
            
            // Kejujuran
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',13)->where('subbidang_id',49)->inRandomOrder()->take(3)->get());   
            $soal = $soal->merge($idtambah);

            // Jejaring Kerja
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',18)->where('subbidang_id',58)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);
            
            // Konsistensi
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',13)->where('subbidang_id',50)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);
            
            // Inisiatif
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',14)->where('subbidang_id',51)->inRandomOrder()->take(3)->get());    
            $soal = $soal->merge($idtambah);

            // Profesionalisme
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',21)->where('subbidang_id',61)->inRandomOrder()->take(2)->get());    
            $soal = $soal->merge($idtambah);
            
            // Antisipasi Masalah
            $idtambah = (Soal::select('id','jawaban')->where('jenis_id',3)->where('bidang_id',14)->where('subbidang_id',52)->inRandomOrder()->take(3)->get());    
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
            $ujian = new Ujian;
            $ujian->soal = $id_soal;
            $ujian->peserta_id = Auth::guard('peserta')->user()->id;
            $ujian->kunci = $kunci_soal;
            $ujian->jawaban = $jawaban_kosong;
            $ujian->nilaitwk = 0;
            $ujian->nilaitiu = 0;
            $ujian->nilaitkp = 0;
            $ujian->nilai_total = 0;
	    $ujian->status = 0;
            $ujian->save();
    
            return response()->json(['msg' => 'success']);
        }
    }

    public function update(Request $request, $id)
    { 
        $count = Ujian::where('peserta_id', '=', Auth::guard('peserta')->user()->id)->count();        
        if ($count == 0) {
            return response()->json(['error' => true]);
        }

        // Get necessary information (jawaban column) from ujians table in DB
        $info_db = Ujian::select('jawaban')->where('peserta_id', '=', Auth::guard('peserta')->user()->id)->first();

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
        $update = Ujian::where('peserta_id', Auth::guard('peserta')->user()->id)->first();
        $update->jawaban = $jawaban_user;
        $update->save();

        // Get user ujian data
        $ujian = Ujian::where('peserta_id', '=', Auth::guard('peserta')->user()->id)->first();

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
        $nilai = Ujian::where('peserta_id', Auth::guard('peserta')->user()->id)->first();
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
        $count = Ujian::where('peserta_id', '=', $id)->count();
        
        if ($count == 0) {
            return redirect('ujian/hasil');
        }

        // get nilai from tabel ujian based on id peserta
        $ujian = Ujian::where('peserta_id', '=', $id)->first();
	$ujian->status = 1;
	$ujian->save();

        // move nilai from table ujian to table hasil
        $hasil = new Hasil;
        $hasil->peserta_id = $ujian->peserta_id;
        $hasil->nilaitwk = $ujian->nilaitwk;
        $hasil->nilaitiu = $ujian->nilaitiu;
        $hasil->nilaitkp = $ujian->nilaitkp;
        $hasil->nilai_total = $ujian->nilai_total;
        $hasil->save();

        // Delete ujian record
        //$ujian->delete();

        return response()->json([
            'view' => view('tes.hasil')->with('hasil', $hasil)->render()
        ]);
    }

}
