<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Peserta;
use Livewire\WithPagination;
use Hash;

class PesertaIndex extends Component
{
    use WithPagination;

    public $nama, $nik, $nip, $sesi, $password, $selected_id, $blokir;
    public $confirming;
    public $updateMode = false;
    public $perPage = 10;
    public $sortField = 'id';
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
        return view('livewire.peserta.peserta-index', [
            'peserta' => Peserta::search($this->search)
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage),
        ]);
    }

    private function _resetInput()
    {
        $this->nama = null;
        $this->nik = null;
        $this->nip = null;
        $this->password = null;
        $this->sesi = null;
    }

    public function store()
    {
        $nip = ($this->nip != null or $this->nip != '') ? 'unique:peserta,nip, regex:/^[0-9\.-]/' : '';

        $this->validate([
            'nama' => 'required|string',
            'nik' => 'required|unique:peserta,nik',
            'nip' => [$nip],
            'password' => 'required|min:6',
        ], [
            'nama.required' => 'nama harus diisi',
            'nik.required' => 'NIK harus diisi',
            'nik.unique' => 'NIK sudah ada',
            'nik.numeric' => 'NIK hanya boleh diisi angka',
            'nip.unique' => 'NIPTT-PK sudah ada',
            'nip.regex' => 'format NIPTT-PK tidak sesuai',
            'password.required' => 'password harus diisi',
            'password.min' => 'password minimal 6 karakter'
        ]);

        Peserta::create([
            'nama' => $this->nama,
            'nik' => $this->nik,
            'nip' => $this->nip,
            'sesi' => $this->sesi,
            'password' => Hash::make($this->password),
        ]);

        $this->_resetInput();
        session()->flash('message', 'peserta berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = Peserta::findOrFail($id);
        $this->selected_id = $data->id;
        $this->nama = $data->nama;
        $this->nik = $data->nik;
        $this->nip = $data->nip;
        $this->sesi = $data->sesi;
        $this->blokir = $data->blokir;

        $this->updateMode = true;
    }

    public function update()
    {
        $char = $this->password != '' ? 'min:6' : '';
        $nip = ($this->nip != null or $this->nip != '') ? 'regex:/^[0-9\.-]/' : '';

        $this->validate([
            'nama' => 'required|string',
            'nik' => 'required',
            'nip' => [$nip],
            'password' => $char,
        ], [
            'nama.required' => 'nama harus diisi',
            'nik.required' => 'NIK harus diisi',
            'nik.numeric' => 'NIK hanya boleh diisi angka',
            'nip.unique' => 'NIPTT-PK sudah ada',
            'nip.regex' => 'format NIPTT-PK tidak sesuai',
            'password.min' => 'password minimal 6 karakter'
        ]);
        
        if ($this->selected_id) {
            $peserta = Peserta::find($this->selected_id);
            if ($this->password != '') {
                $peserta->update([
                    'nama' => $this->nama,
                    'nik' => $this->nik,
                    'nip' => $this->nip,
                    'sesi' => $this->sesi,
                    'password' => Hash::make($this->password),
                    'blokir' => $this->blokir
                ]);
            } else {
                $peserta->update([
                    'nama' => $this->nama,
                    'nik' => $this->nik,
                    'nip' => $this->nip,
                    'sesi' => $this->sesi,
                    'blokir' => $this->blokir
                ]);
            }
        }
        $this->_resetInput();
        $this->updateMode = false;
        session()->flash('message', 'peserta berhasil diupdate.');
    }

    public function destroy($id)
    {
        Peserta::where('id', $id)->delete();
        session()->flash('message', 'peserta berhasil dihapus.');
    }

    public function cancel()
    {
        $this->_resetInput();
	$this->resetValidation();
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
        Peserta::truncate();
        session()->flash('message', 'semua peserta berhasil dihapus.');
    }
}
