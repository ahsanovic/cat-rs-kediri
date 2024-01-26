<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{ Rumpun, Jabatan, SoalSkb };
use Illuminate\Support\Facades\Validator;

class SoalSkbController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('rumpun') or $request->has('deskripsi') or $request->has('jabatan')) {
            $soal_skb = SoalSkb::with('rumpun','jabatan')
                ->when($request->rumpun, function($query) use ($request){
                    $query->where('rumpun_id', '=', $request->rumpun);
                })
                ->when($request->jabatan, function($query) use ($request){
                    $query->where('jabatan_id', '=', $request->jabatan);
                })
                ->when($request->deskripsi, function($query) use ($request){
                    $query->where('deskripsi', 'like', '%'.$request->deskripsi.'%');
                })
                ->paginate(10);
            $soal_skb->appends($request->only(['rumpun', 'jabatan', 'deskripsi'])); // menambahkan parameter rumpun, deskripsi pada url pagination
            $rumpun = Rumpun::orderBy('rumpun_jabatan')->pluck('rumpun_jabatan','id');
            $jabatan = Jabatan::orderBy('nama_jabatan')->pluck('nama_jabatan','id');
            return view('admin.soal_skb.index', compact('soal_skb','rumpun','jabatan'));

        } else {
            $soal_skb = SoalSkb::with('rumpun','jabatan')->paginate(10);
            $rumpun = Rumpun::orderBy('rumpun_jabatan')->pluck('rumpun_jabatan','id');
            $jabatan = Jabatan::orderBy('nama_jabatan')->pluck('nama_jabatan','id');
            return view('admin.soal_skb.index', compact('soal_skb','jabatan','rumpun'));
        }
    }

    public function create()
    {
        $rumpun = Rumpun::all();
        return view('admin.soal_skb.create', compact('rumpun'));
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
            'rumpun' => 'required',
            'jabatan' => 'required',
            'jawaban' => 'required',
        ], [
            'rumpun.required' => 'rumpun jabatan harus dipilih',
            'jabatan.required' => 'jabatan harus dipilih',
            'jawaban.required' => 'kunci jawaban harus diisi'
        ]);

        $soal = SoalSkb::create([
            'rumpun_id' => $request->rumpun,
            'jabatan_id' => $request->jabatan,
            'deskripsi' => $request->deskripsi,
            'opsi1' => $request->opsi1,
            'opsi2' => $request->opsi2,
            'opsi3' => $request->opsi3,
            'opsi4' => $request->opsi4,
            'opsi5' => $request->opsi5,
            'jawaban' => $request->jawaban,
        ]);

        $soal->save();
        return redirect()->route('soal-skb')->with('message', 'soal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $soal = SoalSkb::findOrFail($id);
        $rumpun = Rumpun::pluck('rumpun_jabatan','id');
        //$jabatan = Jabatan::where('id', $soal->jabatan_id)->get();
	$jabatan = Jabatan::where('rumpun_id', $soal->rumpun_id)->get();
	//$jabatan = Jabatan::all();
        return view('admin.soal_skb.edit', compact('soal','rumpun','jabatan'));
    }

    public function view($id)
    {
        $soal = SoalSkb::findOrFail($id);
        return view('admin.soal_skb.view', compact('soal'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'rumpun' => 'required',
            'jabatan' => 'required',
            'jawaban' => 'required',
        ], [
            'rumpun.required' => 'rumpun jabatan harus dipilih',
            'jabatan.required' => 'jabatan harus dipilih',
            'jawaban.required' => 'kunci jawaban harus diisi'
        ]);

        $soal = SoalSkb::find($request->id);

        $soal->rumpun_id = $request->rumpun;
        $soal->jabatan_id = $request->jabatan;
        $soal->deskripsi = $request->deskripsi;
        $soal->opsi1 = $request->opsi1;
        $soal->opsi2 = $request->opsi2;
        $soal->opsi3 = $request->opsi3;
        $soal->opsi4 = $request->opsi4;
        $soal->opsi5 = $request->opsi5;
        $soal->jawaban = $request->jawaban;

        $soal->save();
        return redirect()->route('soal-skb')->with('message', 'soal berhasil diupdate.');
    }

    public function destroy($id)
    {
        $soal = SoalSkb::find($id);
        $soal->delete();

        return redirect()->route('soal-skb')->with('message', 'soal berhasil dihapus.');
    }

    public function getrumpunList(Request $request)
    {
        $rumpun = Rumpun::where('id', $request->id)->pluck('rumpun_jabatan','id');
        return response()->json($rumpun);
    }

    public function getJabatanList(Request $request)
    {
        $jabatan = Jabatan::where('rumpun_id', $request->rumpun_id)->pluck('nama_jabatan','id');
        return response()->json($jabatan);
    }
}
