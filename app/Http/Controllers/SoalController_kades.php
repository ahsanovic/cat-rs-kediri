<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Soal;
use App\{JenisSoal,Bidang};

class SoalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('jenis') or $request->has('bidang') or $request->has('deskripsi')) {
            $soal = Soal::with('bidang','subbidang','jenis')
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
            $soal->appends($request->only(['jenis','bidang','deskripsi'])); // menambahkan parameter jenis, bidang, deskripsi pada url pagination
            $jenis = JenisSoal::pluck('jenis_soal','id');
            $bidang = Bidang::orderBy('bidang')->pluck('bidang','id');
            return view('admin.soal.index', compact('soal','jenis','bidang'));
        } else {
            $soal = Soal::with('bidang','subbidang','jenis')->paginate(10);
            $jenis = JenisSoal::pluck('jenis_soal','id');
            $bidang = Bidang::orderBy('bidang')->pluck('bidang','id');
            return view('admin.soal.index', compact('soal','jenis','bidang'));
        }
    }

    public function create()
    {
        $jenis = JenisSoal::all();
        $bidang = Bidang::all();
        return view('admin.soal.create', compact('jenis', 'bidang'));
    }

    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'upload' => 'image'
        ]);

        if ($validator->fails()) {
            $ckeditor = $request->input('CKEditorFuncNum');
            $msg = 'file harus gambar';
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
            'bidang' => 'required',
            'jawaban' => 'required',
        ], [
            'bidang.required' => 'bidang soal harus dipilih',
            'jawaban.required' => 'kunci jawaban harus diisi'
        ]);

        $soal = Soal::create([
            'jenis_id' => 1,
            'bidang_id' => $request->bidang,
            'deskripsi' => $request->deskripsi,
            'opsi1' => $request->opsi1,
            'opsi2' => $request->opsi2,
            'opsi3' => $request->opsi3,
            'opsi4' => $request->opsi4,
            'opsi5' => $request->opsi5,
            'jawaban' => $request->jawaban,
	        'username' => auth()->guard('admin')->user()->username,
        ]);

        $soal->save();
        return redirect()->route('soal')->with('message', 'soal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $soal = Soal::findOrFail($id);
        $jenis = JenisSoal::pluck('jenis_soal','id');
        $bidang = Bidang::where('jenis_id', $soal->jenis_id)->get();
        return view('admin.soal.edit', compact('soal','jenis','bidang'));
    }

    public function view($id)
    {
        $soal = Soal::findOrFail($id);
        return view('admin.soal.view', compact('soal'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'bidang' => 'required',
            'jawaban' => 'required',
        ], [
            'bidang.required' => 'bidang soal harus dipilih',
            'jawaban.required' => 'kunci jawaban harus diisi'
        ]);

        $soal = Soal::find($request->id);
        $soal->bidang_id = $request->bidang;
        $soal->deskripsi = $request->deskripsi;
        $soal->opsi1 = $request->opsi1;
        $soal->opsi2 = $request->opsi2;
        $soal->opsi3 = $request->opsi3;
        $soal->opsi4 = $request->opsi4;
        $soal->opsi5 = $request->opsi5;
        $soal->jawaban = $request->jawaban;

        $soal->save();
        return redirect()->route('soal')->with('message', 'soal berhasil diupdate.');
    }

    public function destroy($id)
    {
        $soal = Soal::find($id);
        $soal->delete();

        return redirect()->route('soal')->with('message', 'soal berhasil dihapus.');
    }

    /* public function getBidangList(Request $request)
    {
        $bidang = Bidang::where('jenis_id', $request->jenis_id)->pluck('bidang','id');
        return response()->json($bidang);
    }

    public function getSubBidangList(Request $request)
    {
        $subbidang = SubBidang::where('bidang_id', $request->bidang_id)->pluck('subbidang','id');
        return response()->json($subbidang);
    } */
}
