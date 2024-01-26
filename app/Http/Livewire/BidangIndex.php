<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Bidang;
use Livewire\WithPagination;

class BidangIndex extends Component
{
    use WithPagination;

    public $bidang, $jenis_id, $selected_id;
    public $confirming;
    public $updateMode = false;
    public $perPage = 5;
    public $sortField = 'jenis_id';
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
        return view('livewire.bidang.bidang-index', [
            'bidangs' => Bidang::search($this->search)
                        ->with('jenisSoal')
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage),
        ]);
    }

    private function _resetInput()
    {
        $this->bidang = null;
        $this->jenis_id = null;
    }

    public function store()
    {
        $this->validate([
            'bidang' => 'required|string',
            'jenis_id' => 'required',
        ], [
            'bidang.required' => 'bidang harus diisi',
            'jenis_id.required' => 'jenis soal harus diisi',
        ]);

        Bidang::create([
            'bidang' => $this->bidang,
            'jenis_id' => $this->jenis_id,
        ]);

        $this->_resetInput();
        session()->flash('message', 'bidang soal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $bidang = Bidang::findOrFail($id);
        $this->selected_id = $bidang->id;
        $this->bidang = $bidang->bidang;
        $this->jenis_id = $bidang->jenis_id;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'bidang' => 'required|string',
            'jenis_id' => 'required',
        ], [
            'bidang.required' => 'bidang harus diisi',
            'jenis_id.required' => 'jenis soal harus diisi',
        ]);

        if ($this->selected_id) {
            $bidang = Bidang::find($this->selected_id);
            $bidang->update([
                'bidang' => $this->bidang,
                'jenis_id' => $this->jenis_id,
            ]);    
        }
                
        $this->_resetInput();
        $this->updateMode = false;
        session()->flash('message', 'bidang soal berhasil diupdate.');
    }

    public function destroy($id)
    {
        Bidang::where('id', $id)->delete();
        session()->flash('message', 'bidang soal berhasil dihapus.');
    }

    public function cancel()
    {
        $this->_resetInput();
        $this->updateMode = false;
    }

    public function cancelDelete()
    {
        $this->confirming = '';
    }

    public function confirmDelete($id)
    {
        $this->confirming = $id;
    }
}
