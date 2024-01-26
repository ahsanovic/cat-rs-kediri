<div class="row mt-3">
    <div class="col-md-6">
        <strong>Form Edit Bidang Soal</strong>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <input type="hidden" wire:model="selected_id">
        <div class="form-group">
            <label for="jabatan">Nama Jabatan</label>
            <input type="text" wire:model="jabatan" class="form-control form-control-sm @error('jabatan') is-invalid @enderror">
            @error('jabatan')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Rumpun Jabatan</label>
            @php $rumpun = App\Rumpun::getData() @endphp            
            <select wire:model="rumpun_id" class="form-control form-control-sm" required>
                <option value="0" selected>- pilih rumpun jabatan -</option>
                @foreach ($rumpun as $item)
                    <option value="{{ $item->id }}">{{ $item->rumpun_jabatan }}</option>                    
                @endforeach
            </select>
            @error('rumpun_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="row mb-5">
    <div class="col-md-6">
        <button wire:click="update" class="btn btn-sm btn-primary">Update</button>
        <button wire:click="cancel" class="btn btn-sm btn-danger">Cancel</button>
    </div>
</div>
