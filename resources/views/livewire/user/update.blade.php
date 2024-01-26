<div class="card bg-light border-primary mt-2 mb-5">
    <div class="card-header">
        <span class="d-flex justify-content-between">
            Form Edit User
            <button class="btn btn-sm btn-outline-dark" type="button" data-toggle="collapse" data-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">show/hide form
            </button>        
        </span>
    </div>
    <div class="collapse show" id="collapseUser">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <input type="hidden" wire:model="selected_id">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" wire:model="name" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="nama">
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" wire:model="username" class="form-control form-control-sm @error('username') is-invalid @enderror" placeholder="username">
                        @error('username')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" placeholder="email" wire:model="email">
                        @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Password</label><span class="text-danger small pl-2">(kosongkan jika password tidak diganti)</span>
                        <input type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" placeholder="password" wire:model="password">
                        @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button wire:click="update()" class="btn btn-sm btn-primary">Update</button>
                    <button wire:click="cancel()" class="btn btn-sm btn-danger">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>