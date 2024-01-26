<?php

namespace App\Http\Livewire;

use App\HasilSkb;
use Livewire\Component;
use Livewire\WithPagination;

class HasilSkbIndex extends Component
{
    use WithPagination;

    public $confirming;
    public $perPage = 10;
    public $sortField = 'hasil_skb.created_at';
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
        return view('livewire.hasil-skb.hasil-index', [
            'hasil' => HasilSkb::search($this->search)
                        ->select(
                            'nama',
                            'nik',
                            'nip',
			    'sesi',
                            'hasil_skb.id as id',
                            'nilai',
                            'waktu_mulai',
                            'hasil_skb.created_at'
                        )
                        ->join('peserta_skb', 'peserta_skb.id', '=', 'hasil_skb.peserta_skb_id')
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage),
        ]);
    }

    public function destroy($id)
    {
        HasilSkb::where('id', $id)->delete();
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
        HasilSkb::truncate();
        session()->flash('message', 'semua hasil tes berhasil dihapus.');
    }
}
