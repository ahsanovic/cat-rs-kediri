<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PesertaSkbExport;
use App\Imports\PesertaSkbImport;
use App\PesertaSkb;
use Maatwebsite\Excel\Facades\Excel;

class PesertaSkbController extends Controller
{
    public $sesi;

    public function exportExcel()
	{
		return Excel::download(new PesertaSkbExport, 'peserta-skb.xlsx');
    }

    public function importExcel(Request $request) 
    {
        $this->validate($request, [
            'file' => 'required|file|mimes:csv,xls,xlsx'
        ]);

  	    $file = $request->file('file');
        Excel::import(new PesertaSkbImport, $file);
        return redirect()->back()->with('message', 'Data berhasil diimport.');
    }

    public function getDownload()
    {
        $file = public_path() . "/format-peserta-skb.xlsx";
        $header = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];
        return response()->download($file, 'format-peserta-skb.xlsx', $header);
    }

    public function blokir()
    {
        PesertaSkb::where('blokir', 'N')
                ->where('sesi', request()->sesi)
                //->where(function($q) {
                //    $q->whereNull('ip_address')
                //        ->orWhere('ip_address', '');
                //})
                ->update(['blokir' => 'Y']);
        return redirect()->back()->with('message', 'Peserta berhasil diblokir');
    }

    public function unblock()
    {
        $sesi = request()->sesi;
        PesertaSkb::where('blokir', 'Y')
                ->where('sesi', request()->sesi)
                //->where(function($q) {
                //    $q->whereNull('ip_address')
                //        ->orWhere('ip_address', '');
                //})
                ->update(['blokir' => 'N']);
        return redirect()->back()->with('message', 'Peserta sesi ' . $sesi . ' berhasil diunblock');
    }
}
