<?php

namespace App\Http\Livewire;

use Hash;
use App\PesertaSim;
use Livewire\Component;
use Livewire\WithPagination;

class PesertaSimIndex extends Component
{
    use WithPagination;

    public $nama, $username, $email, $password, $selected_id;
    public $confirming;
    public $updateMode = false;
    public $perPage = 10;
    public $sortField = 'nama';
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
        return view('livewire.peserta-sim.peserta-sim-index', [
            'peserta_sim' => PesertaSim::search($this->search)
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage),
        ]);
    }

    private function _resetInput()
    {
        $this->nama = null;
        $this->username = null;
        $this->email = null;
        $this->password = null;
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required|string',
            'username' => 'required|string|min:6|unique:peserta_sim,username',
            'email' => 'required|email|unique:peserta_sim,email',
            'password' => 'required|min:8',
        ], [
            'nama.required' => 'nama harus diisi',
            'username.required' => 'username harus diisi',
            'username.min' => 'username minimal 6 karakter',
            'username.unique' => 'username sudah ada',
            'email.required' => 'email harus diisi',
            'email.unique' => 'email sudah ada',
            'email.email' => 'format email harus benar, ex: contoh@gmail.com',
            'password.required' => 'password harus diisi',
            'password.min' => 'password minimal 8 karakter'
        ]);

        PesertaSim::create([
            'nama' => $this->nama,
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $this->_resetInput();
        session()->flash('message', 'peserta berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $peserta_sim = PesertaSim::findOrFail($id);
        $this->selected_id = $peserta_sim->id;
        $this->nama = $peserta_sim->nama;
        $this->username = $peserta_sim->username;
        $this->email = $peserta_sim->email;
        $this->updateMode = true;
    }

    public function update()
    {
        $char = $this->password != '' ? 'min:8' : '';

        $this->validate([
            'nama' => 'required|string',
            'username' => 'required|string|min:6',
            'email' => 'required|email',
            'password' => $char
        ], [
            'nama.required' => 'nama harus diisi',
            'username.required' => 'username harus diisi',
            'username.min' => 'username minimal 6 karakter',
            'email.required' => 'email harus diisi',
            'password.min' => 'password minimal 8 karakter'
        ]);
        
        if ($this->selected_id) {
            $peserta_sim = PesertaSim::find($this->selected_id);
            if ($this->password != '') {
                $peserta_sim->update([
                    'nama' => $this->nama,
                    'username' => $this->username,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                ]);
            } else {
                $peserta_sim->update([
                    'nama' => $this->nama,
                    'username' => $this->username,
                    'email' => $this->email,
                ]);
            }
        }

        $this->_resetInput();
        $this->updateMode = false;
        session()->flash('message', 'peserta berhasil diupdate.');
    }

    public function destroy($id)
    {
        PesertaSim::where('id', $id)->delete();
        session()->flash('message', 'peserta berhasil dihapus.');
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

    public function deleteAll()
    {
        PesertaSim::truncate();
        session()->flash('message', 'semua peserta berhasil dihapus.');
    }
}
