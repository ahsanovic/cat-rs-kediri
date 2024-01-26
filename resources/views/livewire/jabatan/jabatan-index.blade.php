<div>
    @livewire('master-rumpun-index')

    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <strong>Sukses!</strong> {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if ($updateMode)
        @include('livewire.jabatan.update')
    @else
        @include('livewire.jabatan.create')
    @endif

    <div class="row mb-3">
        <div class="col form-inline">
            Per Page: &nbsp;
            <select wire:model="perPage" class="form-control form-control-sm">
                <option>10</option>
                <option>50</option>
                <option>100</option>
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
                    <th><a wire:click.prevent="sortBy('jabatan')" role="button" href="#">
                            Nama Jabatan
                            @include('includes._sort-icon', ['field' => 'jabatan'])
                        </a></th>
                    <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                            ID Jabatan
                            @include('includes._sort-icon', ['field' => 'id'])
                        </a></th>
                    <th><a wire:click.prevent="sortBy('rumpun_id')" role="button" href="#">
                            Rumpun Jabatan
                            @include('includes._sort-icon', ['field' => 'rumpun_id'])
                        </a></th>
                    <th>Action(s)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jabatans as $key => $row)
                <tr>
                    <td>{{ $jabatans->firstItem() + $key }}</td>
                    <td>{{ $row->nama_jabatan }}</td>
		    <td>{{ $row->id }}</td>
                    <td>{{ $row->rumpun->rumpun_jabatan }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-success" wire:click="edit({{ $row->id }})"><i
                                class="fa fa-edit"></i> Edit</button>
                        {{-- @if ($confirming === $row->id)
                        <button wire:click="destroy({{ $row->id }})" class="btn btn-sm btn-danger" data-toggle="tooltip"
                            data-placement="top" title="anda yakin akan menghapus data ini ?"><i
                                class="fa fa-exclamation-circle"></i> Sure ?</button>
                            <button wire:click="cancelDelete()" class="btn btn-sm btn-outline-primary"><i class="fa fa-times"></i> Cancel</button>
                        @else
                        <button wire:click="confirmDelete({{ $row->id }})" class="btn btn-sm btn-outline-danger"><i
                                class="fa fa-trash"></i> Delete</button>
                        @endif --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col">
            {{ $jabatans->links() }}
        </div>

        <div class="col text-right text-muted">
            Showing {{ $jabatans->firstItem() }} to {{ $jabatans->lastItem() }} out of {{ $jabatans->total() }} results
        </div>
    </div>
</div>
</div>
</div>
