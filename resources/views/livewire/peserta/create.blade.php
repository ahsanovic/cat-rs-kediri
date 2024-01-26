<div class="card mt-2 bg-light border-primary mb-5">
    <div class="card-header">
        <span class="d-flex justify-content-between">
            Form Tambah Peserta
            <button class="btn btn-sm btn-outline-dark" type="button" data-toggle="collapse" data-target="#collapsePeserta" aria-expanded="false" aria-controls="collapsePeserta">show/hide form
            </button>        
        </span>
    </div>
    <div class="collapse show" id="collapsePeserta">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" wire:model="nama" class="form-control form-control-sm @error('nama') is-invalid @enderror" placeholder="nama">
                        @error('nama')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK/Email</label>
                        <input type="text" wire:model="nik" class="form-control form-control-sm @error('nik') is-invalid @enderror" placeholder="nik">
                        @error('nik')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nip">NIPTT-PK (jika ada)</label>
                        <input type="text" wire:model="nip" class="form-control form-control-sm @error('nip') is-invalid @enderror" placeholder="niptt-pk">
                        @error('nip')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" placeholder="password" wire:model="password">
                        @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Sesi</label>
                        <input type="text" class="form-control form-control-sm @error('sesi') is-invalid @enderror" placeholder="sesi" wire:model="sesi">
                        @error('sesi')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button wire:click="store()" class="btn btn-sm btn-primary">Save</button>
                    <button wire:click="cancel()" class="btn btn-sm btn-danger">Reset</button>
                </div>
            </div>
        </div>
    </div>
</div>
