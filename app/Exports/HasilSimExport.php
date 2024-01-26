<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use App\HasilSim;
use Maatwebsite\Excel\Concerns\FromView;

class HasilSimExport implements FromView
{
    public function view(): View
    {
        return view('livewire.hasil-sim.excel-hasil', [
            'hasil_sim' => HasilSim::select(
                'nama',
                'username',
                'email',
                'nilaitwk',
                'nilaitiu',
                'nilaitkp',
                'hasil_sim.created_at'
            )
            ->join('peserta_sim', 'peserta_sim.id', '=', 'hasil_sim.peserta_sim_id')
            ->get()
        ]);
    }
}
