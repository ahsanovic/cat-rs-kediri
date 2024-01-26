<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\SoalSim;
use App\{JenisSoal,Bidang,SubBidang};

class SoalSimController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('jenis') or $request->has('bidang') or $request->has('deskripsi')) {
            $soal_sim = SoalSim::with('bidang','subbidang','jenis')
                ->when($request->jenis, function($query) use ($request){
                    $query->where('jenis_id', '=', $request->jenis);
                })
                ->when($request->bidang, function($query) use ($request){
                    $query->where('bidang_id', '=', $request->bidang);
                })
                ->when($request->deskripsi, function($query) use ($request){
                    $query->where('deskripsi', 'like', '%'.$request->deskripsi.'%');
                })
                ->paginate(10);
            $soal_sim->appends($request->only(['jenis','bidang','deskripsi'])); // menambahkan parameter jenis, bidang, deskripsi pada url pagination
            $jenis = JenisSoal::pluck('jenis_soal','id');
            $bidang = Bidang::orderBy('bidang')->pluck('bidang','id');
            return view('admin.soal_sim.index', compact('soal_sim','jenis','bidang'));
        } else {
            $soal_sim = SoalSim::with('bidang','subbidang','jenis')->paginate(10);
            $jenis = JenisSoal::pluck('jenis_soal','id');
            $bidang = Bidang::orderBy('bidang')->pluck('bidang','id');
            return view('admin.soal_sim.index', compact('soal_sim','jenis','bidang'));
        }
    }

    public function create()
    {
        $jenis = JenisSoal::all();
        return view('admin.soal_sim.create', compact('jenis'));
    }

    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'upload' => 'image|mimes:jpeg,jpg,png|max:500'
        ]);

        if ($validator->fails()) {
            $ckeditor = $request->input('CKEditorFuncNum');
            $msg = 'gagal upload file';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($ckeditor, '', '$msg')</script>";

            //SET HEADERNYA
            @header('Content-type: text/html; charset=utf-8');
            return $response;
        }
        
        //JIKA ADA DATA YANG DIKIRIMKAN
        if ($request->hasFile('upload')) {
            $file = $request->file('upload'); //SIMPAN SEMENTARA FILENYA KE VARIABLE
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); //KITA GET ORIGINAL NAME-NYA
            //KEMUDIAN GENERATE NAMA YANG BARU KOMBINASI NAMA FILE + TIME
            $fileName = $fileName . '_' . time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads'), $fileName); //SIMPAN KE DALAM FOLDER PUBLIC/UPLOADS

            //KEMUDIAN KITA BUAT RESPONSE KE CKEDITOR
            $ckeditor = $request->input('CKEditorFuncNum');
            $url = asset('uploads/' . $fileName); 
            $msg = 'Image uploaded successfully'; 
            //DENGAN MENGIRIMKAN INFORMASI URL FILE DAN MESSAGE
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($ckeditor, '$url', '$msg')</script>";

            //SET HEADERNYA
            @header('Content-type: text/html; charset=utf-8'); 
            return $response;
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            //'jenis' => 'required',
            'bidang' => 'required',
            'subbidang' => 'required',
            'jawaban' => 'required',
            // 'gambar' => 'image|mimes:jpeg,png,jpg|nullable|max:512'
        ], [
            //'jenis.required' => 'jenis soal harus dipilih',
            'bidang.required' => 'bidang soal harus dipilih',
            'subbidang.required' => 'sub bidang soal harus dipilih',
            // 'level.required' => 'level soal harus dipilih',
            'jawaban.required' => 'kunci jawaban harus diisi'
        ]);

        // if($request->hasFile('gambar')){
        //     // Get full filename
        //     $filenameWithExt = $request->file('gambar')->getClientOriginalName();
        //     // Get only filename without extension
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     // Get extension
        //     $extension = $request->file('gambar')->getClientOriginalExtension();
        //     // Give a new name
        //     $filenameToStore = $filename.'_'.time().'.'.$extension;
        //     // Upload image
        //     $path = $request->file('gambar')->StoreAs('public/img',$filenameToStore);
        // } 
        // else {
        //     $filenameToStore = NULL;
        // }

        $soal_sim = SoalSim::create([
            'jenis_id' => $request->jenis,
            'bidang_id' => $request->bidang,
            'subbidang_id' => $request->subbidang,
            'deskripsi' => $request->deskripsi,
            'opsi1' => $request->opsi1,
            'opsi2' => $request->opsi2,
            'opsi3' => $request->opsi3,
            'opsi4' => $request->opsi4,
            'opsi5' => $request->opsi5,
            'jawaban' => $request->jawaban,
            // 'image' => $filenameToStore
        ]);

        $soal_sim->save();
        return redirect()->route('soal-sim')->with('message', 'soal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $soal = SoalSim::findOrFail($id);
        $jenis = JenisSoal::pluck('jenis_soal','id');
        $bidang = Bidang::where('jenis_id', $soal->jenis_id)->get();
        $subbidang = SubBidang::where('bidang_id',$soal->bidang_id)->get();
        return view('admin.soal_sim.edit', compact('soal','jenis','bidang','subbidang'));
    }

    public function view($id)
    {
        $soal = SoalSim::findOrFail($id);
        return view('admin.soal_sim.view', compact('soal'));
    }

    public function update(Request $request)
    {
        $request->validate([
            //'jenis' => 'required',
            'bidang' => 'required',
            'subbidang' => 'required',
            'jawaban' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg|nullable|max:512'
        ], [
            //'jenis.required' => 'jenis soal harus dipilih',
            'bidang.required' => 'bidang soal harus dipilih',
            'subbidang.required' => 'sub bidang soal harus dipilih',
            'jawaban.required' => 'kunci jawaban harus diisi'
        ]);

        $soal = SoalSim::find($request->id);

        // if ($request->hasFile('gambar')) {        
        //     // Get full filename
        //     $filenameWithExt = $request->file('gambar')->getClientOriginalName();
        //     // Get only filename without extension
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     // Get extension
        //     $extension = $request->file('gambar')->getClientOriginalExtension();
        //     // Give a new name
        //     $filenameToStore = $filename.'_'.time().'.'.$extension;
        //     // Upload image
        //     $request->file('gambar')->StoreAs('public/img',$filenameToStore);

        //     if ($soal->image != '' && $soal->image != null) {
        //         $old_file = storage_path('app/public/img/') . $soal->image;
        //         unlink($old_file);
        //     }
        // }

        $soal->jenis_id = $request->jenis;
        $soal->bidang_id = $request->bidang;
        $soal->subbidang_id = $request->subbidang;
        $soal->deskripsi = $request->deskripsi;
        $soal->opsi1 = $request->opsi1;
        $soal->opsi2 = $request->opsi2;
        $soal->opsi3 = $request->opsi3;
        $soal->opsi4 = $request->opsi4;
        $soal->opsi5 = $request->opsi5;
        $soal->jawaban = $request->jawaban;
        // if ($request->hasFile('gambar')) {
        //     $soal->image = $filenameToStore;
        // }

        $soal->save();
        return redirect()->route('soal-sim')->with('message', 'soal berhasil diupdate.');
    }

    public function destroy($id)
    {
        $soal = SoalSim::find($id);
        // if ($soal->image != '' && $soal->image != null) {
        //     unlink(storage_path('app/public/img/') . $soal->image);
        // }
        $soal->delete();

        return redirect()->route('soal-sim')->with('message', 'soal berhasil dihapus.');
    }

    public function getBidangList(Request $request)
    {
        $bidang = Bidang::where('jenis_id', $request->jenis_id)->pluck('bidang','id');
        return response()->json($bidang);
    }

    public function getSubBidangList(Request $request)
    {
        $subbidang = SubBidang::where('bidang_id', $request->bidang_id)->pluck('subbidang','id');
        return response()->json($subbidang);
    }
}
