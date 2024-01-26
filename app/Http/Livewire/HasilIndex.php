<?php

namespace App\Http\Livewire;

use App\Hasil;
use App\Peserta;
use Livewire\Component;
use Livewire\WithPagination;

class HasilIndex extends Component
{
    use WithPagination;

    public $confirming;
    public $perPage = 10;
    public $sortField = 'hasil.created_at';
    public $sortAsc = false;
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
        return view('livewire.hasil.hasil-index', [
            'hasil' => Hasil::search($this->search)
                        ->select(
                            'nama',
                            'nik',
                            'nip',
                            'sesi',
                            'hasil.id as id',
                            'nilaitwk',
                            'nilaitiu',
                            'nilaitkp',
                            'nilai_total',
                            'hasil.created_at'
                        )
                        ->join('peserta', 'peserta.id', '=', 'hasil.peserta_id')
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage),
        ]);
    }

    public function destroy($id)
    {
        Hasil::where('id', $id)->delete();
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
        Hasil::truncate();
        session()->flash('message', 'semua hasil tes berhasil dihapus.');
    }
}
