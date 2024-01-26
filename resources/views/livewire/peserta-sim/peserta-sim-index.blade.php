<div>
    <div>
        <h4>Data Peserta Simulasi SKD</h4>
    
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    
        @if ($updateMode)
            @include('livewire.peserta-sim.update')
        @else
            @include('livewire.peserta-sim.create')
        @endif

        <div class="row mb-3">
            <div class="col-md-4">
                <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#importExcel" title="import peserta"><i class="fa fa-file-excel"></i> Import</button>
                <a href="{{ route('export-sim') }}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="export semua peserta"><i class="fa fa-file-excel"></i> Export</a>
                <button class="btn btn-sm btn-danger" onclick="confirm('Hapus Semua Peserta ?') || event.stopImmediatePropagation()" wire:click="deleteAll" data-toggle="tooltip" data-placement="top" title="hapus semua peserta"><i class="fa fa-trash"></i> Delete All</button>
                <button class="btn btn-sm btn-secondary" onclick="location.reload()" data-toggle="tooltip" data-placement="top" title="reload"><i class="icon-refresh"></i> Refresh</button>
            </div>
        </div>
        
        <div class="row mb-4">
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
                        <th><a wire:click.prevent="sortBy('nama')" role="button" href="#">
                            Nama
                            @include('includes._sort-icon', ['field' => 'nama'])
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
                    @foreach ($peserta_sim as $key => $row)
                    <tr>
                        <td>{{ $peserta_sim->firstItem() + $key }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->username }}</td>
                        <td>{{ $row->email }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-success" wire:click="edit({{ $row->id }})"><i class="fa fa-edit"></i> Edit</button>
                            @if ($confirming === $row->id)
                                <button wire:click="destroy({{ $row->id }})" class="btn btn-sm btn-danger" title="anda yakin akan menghapus data ini ?"><i class="fa fa-exclamation-circle"></i> Sure ?</button>
                                <button wire:click="cancelDelete()" class="btn btn-sm btn-outline-primary"><i class="fa fa-times"></i> Cancel</button>
                            @else
                                <button wire:click="confirmDelete({{ $row->id }})" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> Delete</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col">
                {{ $peserta_sim->links() }}
            </div>
    
            <div class="col text-right text-muted">
                Showing {{ $peserta_sim->firstItem() }} to {{ $peserta_sim->lastItem() }} out of {{ $peserta_sim->total() }} results
            </div>
        </div>
    </div>   
</div>

<!-- Import Excel -->
<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('import-sim') }}" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Peserta</h5>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}

                    <label>Pilih file excel</label>
                    <div class="form-group">
                        <input type="file" name="file" required="required">
                        <div class="text-danger small">ekstensi yang diijinkan: csv, xls, xlsx</div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>