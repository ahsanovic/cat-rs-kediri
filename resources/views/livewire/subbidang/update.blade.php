<div class="row mt-3">
    <div class="col-md-6">
        <strong>Form Tambah Sub Bidang Soal</strong>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <input type="hidden" wire:model="selected_id">
        <div class="form-group">
            <label for="subbidang">Sub Bidang Soal</label>
            <input type="text" wire:model="subbidang" class="form-control form-control-sm @error('subbidang') is-invalid @enderror">
            @error('subbidang')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            @php $bidang = App\Bidang::getData(); @endphp
            <label>Bidang Soal</label>
            <select wire:model="bidang_id" class="form-control form-control-sm" required>
                <option value="0" selected>- pilih bidang soal -</option>
                @foreach ($bidang as $item)
                    <option value="{{ $item->id }}">{{ $item->id . ' - ' . $item->bidang }}</option>                    
                @endforeach
            </select>
            @error('jenis_id')
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
