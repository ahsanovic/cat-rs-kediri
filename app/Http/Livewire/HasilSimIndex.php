<?php

namespace App\Http\Livewire;

use App\HasilSim;
use App\PesertaSim;
use Livewire\Component;
use Livewire\WithPagination;

class HasilSimIndex extends Component
{
    use WithPagination;

    public $confirming;
    public $perPage = 10;
    public $sortField = 'hasil_sim.created_at';
    public $sortAsc = true;
    public $search = '';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function updatingSearch()
    {
	$this->resetPage();
    }

    public function render()
    {
        return view('livewire.hasil-sim.hasil-sim-index', [
            'hasil_sim' => HasilSim::search($this->search)
                        ->select(
                            'nama',
                            'username',
                            'email',
                            'hasil_sim.id as id',
                            'nilaitwk',
                            'nilaitiu',
                            'nilaitkp',
                            'nilai_total',
                            'hasil_sim.created_at'
                        )
                        ->join('peserta_sim', 'peserta_sim.id', '=', 'hasil_sim.peserta_sim_id')
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage),
        ]);
    }

    public function destroy($id)
    {
        HasilSim::where('id', $id)->delete();
        session()->flash('message', 'hasil tes peserta berhasil dihapus.');
    }

    public function cancel()
    {
        $this->confirming = '';
    }

    public function confirmDelete($id)
    {
        $this->confirming = $id;
    }

    public function deleteAll()
    {
        HasilSim::truncate();
        session()->flash('message', 'semua hasil tes berhasil dihapus.');
    }
}
