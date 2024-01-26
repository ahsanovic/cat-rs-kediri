<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\JenisSoal;
use Livewire\WithPagination;

class JenisSoalIndex extends Component
{
    use WithPagination;

    public $jenis, $selected_id;
    public $confirming;
    public $updateMode = false;
    public $perPage = 10;
    public $sortField = 'jenis_soal';
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

    public function render()
    {
        return view('livewire.jenis.jenis-soal-index', [
            'jenisSoal' => JenisSoal::search($this->search)
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage),
        ]);
    }

    private function _resetInput()
    {
        $this->jenis = null;
    }

    public function store()
    {
        $this->validate([
            'jenis' => 'required|string',
        ], [
            'jenis.required' => 'jenis soal harus diisi',
        ]);

        JenisSoal::create([
            'jenis_soal' => $this->jenis,
        ]);

        $this->_resetInput();
        session()->flash('message', 'jenis soal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = JenisSoal::findOrFail($id);
        $this->selected_id = $data->id;
        $this->jenis = $data->jenis_soal;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'jenis' => 'required|string',
        ], [
            'jenis.required' => 'jenis soal harus diisi',
        ]);

        if ($this->selected_id) {
            $data = JenisSoal::find($this->selected_id);
            $data->update([
                'jenis_soal' => $this->jenis,
            ]);    
        }
                
        $this->_resetInput();
        $this->updateMode = false;
        session()->flash('message', 'jenis soal berhasil diupdate.');
    }

    public function destroy($id)
    {
        JenisSoal::where('id', $id)->delete();
        session()->flash('message', 'jenis soal berhasil dihapus.');
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
