<div>
    <div>
        <h4>Hasil Nilai Tes SKB</h4>
    
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
                <a href="{{ route('export-hasil-skb') }}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="export hasil tes"><i class="fa fa-file-excel"></i> Export</a>
                <button class="btn btn-sm btn-danger" onclick="confirm('Hapus Semua Hasil Tes ?') || event.stopImmediatePropagation()" wire:click="deleteAll" data-toggle="tooltip" data-placement="top" title="hapus semua hasil tes"><i class="fa fa-trash"></i> Delete All</button>
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
                        <th><center><a wire:click.prevent="sortBy('nik')" role="button" href="#">
                            NIK
                            @include('includes._sort-icon', ['field' => 'nik'])
                        </a></center></th>
                        <th><center><a wire:click.prevent="sortBy('nip')" role="button" href="#">
                            NIPTT-PK
                            @include('includes._sort-icon', ['field' => 'nip'])
                        </a></center></th>
                        <th><center><a wire:click.prevent="sortBy('sesi')" role="button" href="#">
                            Sesi
                            @include('includes._sort-icon', ['field' => 'sesi'])
                        </a></center></th>
                        <th><center><a wire:click.prevent="sortBy('nilai')" role="button" href="#">
                            Nilai
                            @include('includes._sort-icon', ['field' => 'nilai'])
                        </a></center></th>
                        <th><center><a wire:click.prevent="sortBy('waktu_mulai')" role="button" href="#">
                            Mulai Tes
                            @include('includes._sort-icon', ['field' => 'waktu_mulai'])
                        </a></center></th>
                        <th><center><a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                            Selesai Tes
                            @include('includes._sort-icon', ['field' => 'created_at'])
                        </a></center></th>
                        <th><center>Action(s)</center></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hasil as $key => $row)
                    <tr>
                        <td>{{ $hasil->firstItem() + $key }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->nik }}</td>
                        <td>{{ $row->nip }}</td>
                        <td>{{ $row->sesi }}</td>
                        <td>{{ $row->nilai ?? 0 }}</td>
                        <td>{{ $row->waktu_mulai->format('d M Y H:i') }}</td>
                        <td>{{ $row->created_at->format('d M Y H:i') }}</td>
                        <td>
                            @if ($confirming === $row->id)
                                <button wire:click="destroy({{ $row->id }})" class="btn btn-sm btn-danger" title="anda yakin akan menghapus data ini ?"><i class="fa fa-check"></i></button>
                                <button wire:click="cancel()" class="btn btn-sm btn-outline-primary" title="batal"><i class="fa fa-times"></i></button>
                            @else
                                <button wire:click="confirmDelete({{ $row->id }})" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col">
                {{ $hasil->links() }}
            </div>
    
            <div class="col text-right text-muted">
                Showing {{ $hasil->firstItem() }} to {{ $hasil->lastItem() }} out of {{ $hasil->total() }} results
            </div>
        </div>
    </div>   
</div>
