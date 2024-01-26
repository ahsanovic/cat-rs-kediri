<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\PesertaSkb;
use App\Jabatan;
use App\Rumpun;
use Livewire\WithPagination;
use Hash;


class PesertaSkbIndex extends Component
{
    use WithPagination;

    public $nama, $nik, $nip, $sesi, $blokir, $password, $jabatan_id, $selected_id;
    public $confirming;
    public $updateMode = false;
    public $perPage = 10;
    public $sortField = 'sesi';
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
        return view('livewire.peserta-skb.peserta-skb-index', [
            'peserta' => PesertaSkb::search($this->search)
                        ->with('jabatan')
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage),
        ]);
    }

    private function _resetInput()
    {
        $this->nama = null;
        $this->nik = null;
        $this->nip = null;
        $this->sesi = null;
        $this->blokir = null;
        $this->password = null;
        $this->jabatan_id = null;
    }

    public function store()
    {
        $nip = ($this->nip != null or $this->nip != '') ? 'unique:peserta_skb,nip, regex:/^[0-9\.-]/' : '';

        $this->validate([
            'nama' => 'required|string',
            'nik' => 'required|unique:peserta_skb,nik',
            'nip' => [$nip],
            'password' => 'required|min:8',
            'jabatan_id' => 'required',
        ], [
            'nama.required' => 'nama harus diisi',
            'nik.required' => 'NIK harus diisi',
            'nik.unique' => 'NIK sudah ada',
            'nik.numeric' => 'NIK hanya boleh diisi angka',
            'nip.unique' => 'NIPTT-PK sudah ada',
            'nip.regex' => 'format NIPTT-PK tidak sesuai',
            'password.required' => 'password harus diisi',
            'password.min' => 'password minimal 8 karakter',
            'jabatan_id.required' => 'jabatan harus dipilih',
        ]);

        PesertaSkb::create([
            'nama' => $this->nama,
            'nik' => $this->nik,
            'nip' => $this->nip,
            'sesi' => $this->sesi,
            'blokir' => 'N',
            'password' => Hash::make($this->password),
            'jabatan_id' => $this->jabatan_id
        ]);

        $this->_resetInput();
        session()->flash('message', 'peserta berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = PesertaSkb::findOrFail($id);
        $this->selected_id = $data->id;
        $this->nama = $data->nama;
        $this->nik = $data->nik;
        $this->nip = $data->nip;
        $this->sesi = $data->sesi;
        $this->blokir = $data->blokir;
        $this->jabatan_id = $data->jabatan_id;

        $this->updateMode = true;
    }

    public function update()
    {
        $char = $this->password != '' ? 'min:8' : '';
        $nip = ($this->nip != null or $this->nip != '') ? 'regex:/^[0-9\.-]/' : '';

        $this->validate([
            'nama' => 'required|string',
            'nik' => 'required',
            'nip' => [$nip],
            'password' => $char,
            'jabatan_id' => 'required',
        ], [
            'nama.required' => 'nama harus diisi',
            'nik.required' => 'NIK harus diisi',
            'nik.numeric' => 'NIK hanya boleh diisi angka',
            'nip.unique' => 'NIPTT-PK sudah ada',
            'nip.regex' => 'format NIPTT-PK tidak sesuai',
            'password.min' => 'password minimal 8 karakter',
            'jabatan_id.required' => 'jabatan harus dipilih',
        ]);
        
        if ($this->selected_id) {
            $peserta = PesertaSkb::find($this->selected_id);
            if ($this->password != '') {
                $peserta->update([
                    'nama' => $this->nama,
                    'nik' => $this->nik,
                    'nip' => $this->nip,
                    'sesi' => $this->sesi,
                    'blokir' => $this->blokir,
                    'password' => Hash::make($this->password),
                    'jabatan_id' => $this->jabatan_id
                ]);
            } else {
                $peserta->update([
                    'nama' => $this->nama,
                    'nik' => $this->nik,
                    'nip' => $this->nip,
                    'sesi' => $this->sesi,
                    'blokir' => $this->blokir,
                    'jabatan_id' => $this->jabatan_id
                ]);
            }
        }
        $this->_resetInput();
	$this->resetValidation();
        $this->updateMode = false;
        session()->flash('message', 'peserta berhasil diupdate.');
    }

    public function destroy($id)
    {
        PesertaSkb::where('id', $id)->delete();
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
        PesertaSkb::truncate();
        session()->flash('message', 'semua peserta berhasil dihapus.');
    }

    public function blokir()
    {
        PesertaSkb::where('blokir', '=', 'N')
                ->where('last_login', '=', null)
                ->orWhere('last_login', '=', '0000-00-00 00:00:00')
                ->update(['blokir' => 'Y']);

        session()->flash('message', 'peserta berhasil diblokir.');
    }
}
