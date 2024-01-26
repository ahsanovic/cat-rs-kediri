<div class="row mt-3">
    <div class="col-md-6">
        <strong>Form Edit Setting Ujian</strong>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group">
            <label for="jenis_ujian">Jenis Ujian</label>
            <input type="text" wire:model="jenis_ujian" class="form-control form-control-sm @error('jenis_ujian') is-invalid @enderror">
            @error('jenis_ujian')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="waktu">Waktu Ujian (menit)</label>
            <input type="text" wire:model="waktu" class="form-control form-control-sm @error('waktu') is-invalid @enderror">
            @error('waktu')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <div class="form-group">
                <label>Aktif ?</label>
                <select wire:model="is_active" class="form-control form-control-sm">
                    <option value="Y">Y</option>
                    <option value="N">N</option>  
                </select>
            </div>
            @error('is_active')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="jumlah_soal">Jumlah Soal</label>
            <input type="text" wire:model="jumlah_soal" class="form-control form-control-sm @error('jumlah_soal') is-invalid @enderror">
            @error('jumlah_soal')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="nilai_per_soal">Nilai Per Soal</label>
            <input type="text" wire:model="nilai_per_soal" class="form-control form-control-sm @error('nilai_per_soal') is-invalid @enderror">
            @error('nilai_per_soal')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>        
    </div>
</div>
<div class="row mb-5">
    <div class="col-md-6">
        <button wire:click="update()" class="btn btn-sm btn-primary">Update</button>
        <button wire:click="cancel()" class="btn btn-sm btn-danger">Cancel</button>
    </div>
</div>
