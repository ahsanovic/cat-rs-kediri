<div class="row mt-3">
    <div class="col-md-6">
        <strong>Form Edit Bidang Soal</strong>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <input type="hidden" wire:model="selected_id">
        <div class="form-group">
            <label for="bidang">Bidang Soal</label>
            <input type="text" wire:model="bidang" class="form-control form-control-sm @error('bidang') is-invalid @enderror">
            @error('bidang')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Jenis Soal</label>
            @php $jenis = App\JenisSoal::getData() @endphp            
            <select wire:model="jenis_id" class="form-control form-control-sm" required>
                <option value="0" selected>- pilih jenis soal -</option>
                @foreach ($jenis as $item)
                    <option value="{{ $item->id }}">{{ $item->id . ' - ' . $item->jenis_soal }}</option>                    
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
