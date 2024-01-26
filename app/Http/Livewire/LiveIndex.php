<?php

namespace App\Http\Livewire;

use App\Ujian;
use Livewire\Component;
use Livewire\WithPagination;

class LiveIndex extends Component
{
    use WithPagination;

    public $confirming;
    public $perPage = 10;
    public $sortField = 'ujian.created_at';
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
        return view('livewire.live.live-index', [
            'live' => Ujian::search($this->search)
                        ->select(
                            'nama',
                            'nik',
                            'nip',
                            'peserta.sesi',
                            'ujian.id as id',
                            'ujian.created_at',
                            'jawaban',
                            'kunci',
                            'nilaitwk',
                            'nilaitiu',
                            'nilaitkp',
                            'nilai_total',
			    'status'
                        )
                        ->join('peserta', 'peserta.id', '=', 'ujian.peserta_id')
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage),
        ]);
    }

    public function destroy($id)
    {
        Ujian::where('id', $id)->delete();
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
        Ujian::truncate();
        session()->flash('message', 'livescore tes berhasil dihapus.');
    }
}
