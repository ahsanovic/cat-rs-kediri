<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\SettingUjian;
use Livewire\WithPagination;

class SettingUjianIndex extends Component
{
    use WithPagination;

    public $jenis_ujian, $jumlah_soal, $waktu, $nilai_per_soal, $is_active, $selected_id;
    public $confirming;
    public $updateMode = false;
    public $perPage = 10;
    public $sortField = 'jenis_ujian';
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
        return view('livewire.setting-ujian.setting-ujian-index', [
            'settingUjian' => SettingUjian::search($this->search)
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage),
        ]);
    }

    private function _resetInput()
    {
        $this->jenis_ujian = null;
        $this->jumlah_soal = null;
        $this->waktu = null;
        $this->nilai_per_soal = null;
    }

    public function store()
    {
        $this->validate([
            'jenis_ujian' => 'required|string',
            'jumlah_soal' => 'required|integer',
            'waktu' => 'required|integer',
            'nilai_per_soal' => 'required|integer',
        ], [
            'jenis_ujian.required' => 'jenis ujian harus diisi',
            'jumlah_soal.required' => 'jumlah soal harus diisi',
            'waktu.required' => 'waktu ujian harus diisi',
            'nilai_per_soal.required' => 'nilai per soal harus diisi',
            'jumlah_soal.integer' => 'jumlah soal harus angka',
            'waktu.integer' => 'jumlah soal harus angka',
            'nilai_per_soal.integer' => 'jumlah soal harus angka',
        ]);

        SettingUjian::create([
            'jenis_ujian' => $this->jenis_ujian,
            'jumlah_soal' => $this->jumlah_soal,
            'waktu' => $this->waktu,
            'nilai_per_soal' => $this->nilai_per_soal,
        ]);

        $this->_resetInput();
        session()->flash('message', 'setting ujian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = SettingUjian::findOrFail($id);
        $this->selected_id = $data->id;
        $this->jenis_ujian = $data->jenis_ujian;
        $this->jumlah_soal = $data->jumlah_soal;
        $this->waktu = $data->waktu;
        $this->nilai_per_soal = $data->nilai_per_soal;
        $this->is_active = $data->is_active;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'jenis_ujian' => 'required|string',
            'jumlah_soal' => 'required|integer',
            'waktu' => 'required|integer',
            'nilai_per_soal' => 'required|integer',
        ], [
            'jenis_ujian.required' => 'jenis ujian harus diisi',
            'jumlah_soal.required' => 'jumlah soal harus diisi',
            'waktu.required' => 'waktu ujian harus diisi',
            'nilai_per_soal.required' => 'nilai per soal harus diisi',
            'jumlah_soal.integer' => 'jumlah soal harus angka',
            'waktu.integer' => 'jumlah soal harus angka',
            'nilai_per_soal.integer' => 'jumlah soal harus angka',
        ]);

        if ($this->selected_id) {
            $data = SettingUjian::find($this->selected_id);
            $data->update([
                'jenis_ujian' => $this->jenis_ujian,
                'jumlah_soal' => $this->jumlah_soal,
                'waktu' => $this->waktu,
                'nilai_per_soal' => $this->nilai_per_soal,
                'is_active' => $this->is_active,
            ]);

	    if ($this->is_active == 'Y') {
                SettingUjian::where('id', '!=', $this->selected_id)->update(['is_active' => 'N']);
            } else {
                SettingUjian::where('id', '!=', $this->selected_id)->update(['is_active' => 'Y']);
            }
        }

        $this->_resetInput();
        $this->resetValidation();
        $this->updateMode = false;
        session()->flash('message', 'setting ujian berhasil diupdate.');
    }

    public function destroy($id)
    {
        SettingUjian::where('id', $id)->delete();
        session()->flash('message', 'setting ujian berhasil dihapus.');
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
}
