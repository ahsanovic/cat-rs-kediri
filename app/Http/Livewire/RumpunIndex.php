<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Rumpun;
use Livewire\WithPagination;

class RumpunIndex extends Component
{
    use WithPagination;

    public $rumpun, $selected_id;
    public $confirming;
    public $updateMode = false;
    public $perPage = 10;
    public $sortField = 'rumpun_jabatan';
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
        return view('livewire.rumpun.rumpun-index', [
            'rumpunJabatan' => Rumpun::search($this->search)
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage),
        ]);
    }

    private function _resetInput()
    {
        $this->rumpun = null;
    }

    public function store()
    {
        $this->validate([
            'rumpun' => 'required|string',
        ], [
            'rumpun.required' => 'rumpun jabatan harus diisi',
        ]);

        Rumpun::create([
            'rumpun_jabatan' => $this->rumpun,
        ]);

        $this->_resetInput();
        session()->flash('message', 'rumpun jabatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = Rumpun::findOrFail($id);
        $this->selected_id = $data->id;
        $this->rumpun = $data->rumpun_jabatan;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'rumpun' => 'required|string',
        ], [
            'rumpun.required' => 'rumpun jabatan harus diisi',
        ]);

        if ($this->selected_id) {
            $data = Rumpun::find($this->selected_id);
            $data->update([
                'rumpun_jabatan' => $this->rumpun,
            ]);    
        }
                
        $this->_resetInput();
        $this->updateMode = false;
        session()->flash('message', 'rumpun jabatan berhasil diupdate.');
    }

    public function destroy($id)
    {
        Rumpun::where('id', $id)->delete();
        session()->flash('message', 'rumpun jabatan berhasil dihapus.');
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
