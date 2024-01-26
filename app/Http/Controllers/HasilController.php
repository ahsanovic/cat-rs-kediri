<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\{ HasilExport, HasilSkbExport, HasilSimExport };
use Maatwebsite\Excel\Facades\Excel;

class HasilController extends Controller
{
    public function exportExcel() {
		  return Excel::download(new HasilExport, 'hasil-tes.xlsx');
    }

    public function exportExcelSkb() {
		  return Excel::download(new HasilSkbExport, 'hasil-tes-skb.xlsx');
    }

    public function exportExcelSimulasi() {
		  return Excel::download(new HasilSimExport, 'hasil-tes-simulasi.xlsx');
    }
}
