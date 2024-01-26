<?php

namespace App\Http\Livewire;

use App\UjianSimulasi;
use Livewire\Component;
use Livewire\WithPagination;

class LiveSimIndex extends Component
{
    use WithPagination;

    public $confirming;
    public $perPage = 10;
    public $sortField = 'ujian_sim.created_at';
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
        return view('livewire.live-sim.live-sim-index', [
            'live_sim' => UjianSimulasi::search($this->search)
                        ->select(
                            'nama',
                            'username',
                            'email',
                            'ujian_sim.id as id',
                            'ujian_sim.created_at',
                            'jawaban',
                            'kunci',
                            'nilaitwk',
                            'nilaitiu',
                            'nilaitkp',
                            'nilai_total'
                        )
                        ->join('peserta_sim', 'peserta_sim.id', '=', 'ujian_sim.peserta_sim_id')
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage),
        ]);
    }

    public function destroy($id)
    {
        UjianSimulasi::where('id', $id)->delete();
        session()->flash('message', 'nilai peserta berhasil dihapus.');
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
        UjianSimulasi::truncate();
        session()->flash('message', 'livescore tes berhasil dihapus.');
    }
}
