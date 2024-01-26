<div class="row mt-3">
    <div class="col-md-6">
        <strong>Form Edit Jenis Soal</strong>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <input type="hidden" wire:model="selected_id">
        <div class="form-group">
            <label for="jenis">Jenis Soal</label>
            <input type="text" wire:model="jenis" class="form-control form-control-sm @error('jenis') is-invalid @enderror">
            @error('jenis')
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
