<div>
    <h4>Data User</h4>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($updateMode)
        @include('livewire.user.update')
    @else
        @include('livewire.user.create')
    @endif
    
    <div class="row mb-4">
        <div class="col form-inline">
            Per Page: &nbsp;
            <select wire:model="perPage" class="form-control form-control-sm">
                <option>10</option>
                <option>15</option>
                <option>25</option>
            </select>
        </div>

        <div class="col-md-3">
            <input wire:model="search" class="form-control form-control-sm" type="text" placeholder="search...">
        </div>
    </div>
    <div class="row">
        <table class="table table-hover" id="datatable" width="100%">
            <thead>
                <tr>
                    <th style="width:4%">No</th>
                    <th><a wire:click.prevent="sortBy('name')" role="button" href="#">
                        Nama
                        @include('includes._sort-icon', ['field' => 'name'])
                    </a></th>
                    <th><a wire:click.prevent="sortBy('username')" role="button" href="#">
                        Username
                        @include('includes._sort-icon', ['field' => 'username'])
                    </a></th>
                    <th><a wire:click.prevent="sortBy('email')" role="button" href="#">
                        Email
                        @include('includes._sort-icon', ['field' => 'email'])
                    </a></th>
                    <th>Action(s)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $user)
                <tr>
                    <td>{{ $users->firstItem() + $key }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-success" wire:click="edit({{ $user->id }})"><i class="fa fa-edit"></i> Edit</button>
                        @if ($confirming === $user->id)
                            <button wire:click="destroy({{ $user->id }})" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="anda yakin akan menghapus data ini ?"><i class="fa fa-exclamation-circle"></i> Sure ?</button>
                            <button wire:click="cancelDelete()" class="btn btn-sm btn-outline-primary"><i class="fa fa-times"></i> Cancel</button>
                        @else
                            <button wire:click="confirmDelete({{ $user->id }})" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> Delete</button>
                        @endif
                        {{-- <button class="btn btn-sm btn-outline-danger" 
                                onClick="confirm('Apakah Anda yakin akan menghapus {{ $user->name }} ?') || event.stopImmediatePropagation()" 
                                wire:click="destroy({{ $user->id }})"><i class="fa fa-trash"></i>
                        </button> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col">
            {{ $users->links() }}
        </div>

        <div class="col text-right text-muted">
            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} out of {{ $users->total() }} results
        </div>
    </div>
</div>

