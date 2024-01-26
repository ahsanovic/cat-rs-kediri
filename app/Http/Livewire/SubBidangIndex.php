<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\SubBidang;
use Livewire\WithPagination;

class SubBidangIndex extends Component
{
    use WithPagination;

    public $subbidang, $bidang_id, $selected_id;
    public $confirming;
    public $updateMode = false;
    public $perPage = 10;
    public $sortField = 'bidang_id';
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
        return view('livewire.subbidang.sub-bidang-index', [
            'subbidangs' => SubBidang::search($this->search)
                        ->with('bidang')
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage),
        ]);
    }

    private function _resetInput()
    {
        $this->subbidang = null;
        $this->bidang_id = null;
    }
    
    public function store()
    {
        $this->validate([
            'subbidang' => 'required|string',
            'bidang_id' => 'required',
        ], [
            'subbidang.required' => 'sub bidang harus diisi',
            'bidang_id.required' => 'bidang harus diisi'
        ]);

        SubBidang::create([
            'subbidang' => $this->subbidang,
            'bidang_id' => $this->bidang_id
        ]);
        $this->_resetInput();
        session()->flash('message', 'sub bidang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = SubBidang::findOrFail($id);
        $this->selected_id = $data->id;
        $this->subbidang = $data->subbidang;
        $this->bidang_id = $data->bidang_id;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'subbidang' => 'required|string',
            'bidang_id' => 'required',
        ], [
            'subbidang.required' => 'sub bidang harus diisi',
            'bidang_id.required' => 'bidang harus diisi'
        ]);
        
        if ($this->selected_id) {
            $data = SubBidang::find($this->selected_id);
            $data->update([
                'subbidang' => $this->subbidang,
                'bidang_id' => $this->bidang_id
            ]);
        }

        $this->_resetInput();
        $this->updateMode = false;
        session()->flash('message', 'sub bidang berhasil diupdate.');
    }

    public function destroy($id)
    {
        SubBidang::where('id', $id)->delete();
        session()->flash('message', 'sub bidang berhasil dihapus.');
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
