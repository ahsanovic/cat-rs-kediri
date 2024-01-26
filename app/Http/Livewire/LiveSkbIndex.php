<?php

namespace App\Http\Livewire;

use App\UjianSkb;
use Livewire\Component;
use Livewire\WithPagination;

class LiveSkbIndex extends Component
{
    use WithPagination;

    public $confirming;
    public $perPage = 10;
    public $sortField = 'ujian_skb.created_at';
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
        return view('livewire.live-skb.live-skb-index', [
            'live' => UjianSkb::search($this->search)
                        ->select(
                            'nama',
                            'nik',
                            'nip',
                            'sesi',
                            'ujian_skb.id as id',
                            'ujian_skb.created_at',
                            'jawaban',
                            'kunci',
                            'nilai',
			    'status'
                        )
                        ->join('peserta_skb', 'peserta_skb.id', '=', 'ujian_skb.peserta_skb_id')
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage),
        ]);
    }

    public function destroy($id)
    {
        UjianSkb::where('id', $id)->delete();
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
        UjianSkb::truncate();
        session()->flash('message', 'livescore tes berhasil dihapus.');
    }
}
