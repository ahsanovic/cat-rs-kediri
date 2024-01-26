<div>
    <div>
        <h4>Livescore Tes Simulasi SKD</h4>
    
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row mb-3 mt-4">
            <div class="col-md-4">
                <button class="btn btn-sm btn-danger" onclick="confirm('Hapus Semua Tes ?') || event.stopImmediatePropagation()" wire:click="deleteAll" data-toggle="tooltip" data-placement="top" title="hapus semua tes"><i class="fa fa-trash"></i> Delete All</button>
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
                        <th style="width:4%"><center>No</center></th>
                        <th><center><a wire:click.prevent="sortBy('nama')" role="button" href="#">
                            Nama
                            @include('includes._sort-icon', ['field' => 'nama'])
                        </a></center></th>
                        <th><center><a wire:click.prevent="sortBy('username')" role="button" href="#">
                            Username
                            @include('includes._sort-icon', ['field' => 'username'])
                        </a></center></th>
                        <th><center><a wire:click.prevent="sortBy('email')" role="button" href="#">
                            Email
                            @include('includes._sort-icon', ['field' => 'email'])
                        </a></center></th>
                        <th><center><a wire:click.prevent="sortBy('nilaitwk')" role="button" href="#">
                            TWK
                            @include('includes._sort-icon', ['field' => 'nilaitwk'])
                        </a></center></th>
                        <th><center><a wire:click.prevent="sortBy('nilaitiu')" role="button" href="#">
                            TIU
                            @include('includes._sort-icon', ['field' => 'nilaitiu'])
                        </a></center></th>
                        <th><center><a wire:click.prevent="sortBy('nilaitkp')" role="button" href="#">
                            TKP
                            @include('includes._sort-icon', ['field' => 'nilaitkp'])
                        </a></center></th>
                        <th><center><a wire:click.prevent="sortBy('nilai_total')" role="button" href="#">
                            Total
                            @include('includes._sort-icon', ['field' => 'nilai_total'])
                        </a></center></th>
                        <th><center><a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                            Mulai Tes
                            @include('includes._sort-icon', ['field' => 'created_at'])
                        </a></center></th>
                        <th><center>Action(s)</center></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($live_sim as $key => $ujian)
                    <tr>
                        <td>{{ $live_sim->firstItem() + $key }}</td>
                        <td>{{ $ujian->nama }}</td>
                        <td>{{ $ujian->username }}</td>
                        <td>{{ $ujian->email }}</td>
                        <td>{{ $ujian->nilaitwk }}</td>
                        <td>{{ $ujian->nilaitiu }}</td>
                        <td>{{ $ujian->nilaitkp }}</td>
                        <td>{{ $ujian->nilai_total }}</td>
                        <td>{{ $ujian->created_at->format('d M Y H:i') }}</td>
                        <td>
                            @if ($confirming === $ujian->id)
                                <button wire:click="destroy({{ $ujian->id }})" class="btn btn-sm btn-danger" title="anda yakin akan menghapus data ini ?"><i class="fa fa-check"></i></button>
                                <button wire:click="cancel()" class="btn btn-sm btn-outline-primary"><i class="fa fa-times"></i></button>
                            @else
                                <button wire:click="confirmDelete({{ $ujian->id }})" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col">
                {{ $live_sim->links() }}
            </div>
    
            <div class="col text-right text-muted">
                Showing {{ $live_sim->firstItem() }} to {{ $live_sim->lastItem() }} out of {{ $live_sim->total() }} results
            </div>
        </div>
    </div>   
</div>
