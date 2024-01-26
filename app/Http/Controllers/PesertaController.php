<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PesertaExport;
use App\Imports\PesertaImport;
use App\Peserta;
use Maatwebsite\Excel\Facades\Excel;

class PesertaController extends Controller
{
    public $sesi;

    public function exportExcel()
	{
		return Excel::download(new PesertaExport, 'peserta.xlsx');
    }

    public function importExcel(Request $request) 
    {
        $this->validate($request, [
            'file' => 'required|file|mimes:csv,xls,xlsx'
        ]);

  	    $file = $request->file('file');
        Excel::import(new PesertaImport, $file);
        return redirect()->back()->with('message', 'Data berhasil diimport.');
    }

    public function getDownload()
    {
        $file = public_path() . "/format-peserta-skd.xlsx";
        $header = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];
        return response()->download($file, 'format-peserta-skd.xlsx', $header);
    }

    public function blokir()
    {
	$sesi = request()->sesi;
        Peserta::where('blokir', 'N')
                ->where('sesi', request()->sesi)
                //->where(function($q) {
                //    $q->whereNull('ip_address')
                //        ->orWhere('ip_address', '');
                //})
                ->update(['blokir' => 'Y']);
        return redirect()->back()->with('message', 'Peserta sesi ' . $sesi . ' berhasil diblokir');
    }

    public function unblock()
    {
        $sesi = request()->sesi;
        Peserta::where('blokir', 'Y')
                ->where('sesi', request()->sesi)
                //->where(function($q) {
                //    $q->whereNull('ip_address')
                //        ->orWhere('ip_address', '');
                //})
                ->update(['blokir' => 'N']);
        return redirect()->back()->with('message', 'Peserta sesi ' . $sesi . ' berhasil diunblock');
    }
}
