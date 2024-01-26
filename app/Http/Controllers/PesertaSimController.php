<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PesertaSimExport;
use App\Imports\PesertaSimImport;
use Maatwebsite\Excel\Facades\Excel;

class PesertaSimController extends Controller
{
    public function exportExcel()
	{
		return Excel::download(new PesertaSimExport, 'peserta-simulasi.xlsx');
    }

    public function importExcel(Request $request) 
    {
        $this->validate($request, [
            'file' => 'required|file|mimes:csv,xls,xlsx'
        ]);

  	    $file = $request->file('file');
        Excel::import(new PesertaSimImport, $file);
        return redirect()->back()->with('message', 'Data berhasil diimport.');
    }
}
