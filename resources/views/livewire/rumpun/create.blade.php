<div class="row mt-3">
    <div class="col-md-6">
        <strong>Form Tambah Rumpun Jabatan</strong>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group">
            <label for="rumpun">Rumpun Jabatan</label>
            <input type="text" wire:model="rumpun" class="form-control form-control-sm @error('rumpun') is-invalid @enderror">
            @error('rumpun')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
<div class="row mb-5">
    <div class="col-md-6">
        <button wire:click="store()" class="btn btn-sm btn-primary">Save</button>
        <button wire:click="cancel()" class="btn btn-sm btn-danger">Reset</button>
    </div>
</div>
