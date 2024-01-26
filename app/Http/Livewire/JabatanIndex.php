<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Jabatan;
use Livewire\WithPagination;

class JabatanIndex extends Component
{
    use WithPagination;

    public $jabatan, $rumpun_id, $selected_id;
    public $confirming;
    public $updateMode = false;
    public $perPage = 10;
    public $sortField = 'created_at';
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
        return view('livewire.jabatan.jabatan-index', [
            'jabatans' => Jabatan::search($this->search)
                        ->with('rumpun')
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage),
        ]);
    }

    private function _resetInput()
    {
        $this->jabatan = null;
        $this->rumpun_id = null;
    }

    public function store()
    {
        $this->validate([
            'jabatan' => 'required|string',
            'rumpun_id' => 'required',
        ], [
            'jabatan.required' => 'jabatan harus diisi',
            'rumpun_id.required' => 'rumpun jabatan harus diisi',
        ]);

        Jabatan::create([
            'nama_jabatan' => $this->jabatan,
            'rumpun_id' => $this->rumpun_id,
        ]);

        $this->_resetInput();
        session()->flash('message', 'jabatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $this->selected_id = $jabatan->id;
        $this->jabatan = $jabatan->nama_jabatan;
        $this->rumpun_id = $jabatan->rumpun_id;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'jabatan' => 'required|string',
            'rumpun_id' => 'required',
        ], [
            'jabatan.required' => 'jabatan harus diisi',
            'rumpun_id.required' => 'jenis soal harus diisi',
        ]);

        if ($this->selected_id) {
            $jabatan = Jabatan::find($this->selected_id);
            $jabatan->update([
                'nama_jabatan' => $this->jabatan,
                'rumpun_id' => $this->rumpun_id,
            ]);    
        }
                
        $this->_resetInput();
        $this->updateMode = false;
        session()->flash('message', 'bidang soal berhasil diupdate.');
    }

    public function destroy($id)
    {
        Jabatan::where('id', $id)->delete();
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
