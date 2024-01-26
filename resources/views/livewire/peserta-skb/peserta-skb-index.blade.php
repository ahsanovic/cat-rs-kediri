<div>
    <div>
        <h4>Data Peserta SKB</h4>

        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($updateMode)
            @include('livewire.peserta-skb.update')
        @else
            @include('livewire.peserta-skb.create')
        @endif

        <div class="row mb-3">
            <div class="col-md-10">
                <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#importExcel" title="import peserta"><i class="fa fa-file-excel"></i> Import</button>
                <a href="{{ route('export-skb') }}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="export peserta"><i class="fa fa-file-excel"></i> Export</a>
                <button class="btn btn-sm btn-danger" onclick="confirm('Hapus Semua Peserta ?') || event.stopImmediatePropagation()" wire:click="deleteAll" data-toggle="tooltip" data-placement="top" title="hapus semua peserta"><i class="fa fa-trash"></i> Delete All</button>
                {{-- <button class="btn btn-sm btn-dark" onclick="confirm('Blokir Peserta yang Terlambat Tes ?') || event.stopImmediatePropagation()" wire:click="blokir" data-toggle="tooltip" data-placement="top" title="blokir peserta terlambat"><i class="fa fa-ban"></i> Blokir Peserta</button> --}}
                <button class="btn btn-sm btn-dark" data-toggle="modal" data-target="#blokir" title="blokir peserta terlambat"><i class="fa fa-ban"></i> Blokir Peserta</button>
                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#unblock" title="unblock peserta per sesi"><i class="fa fa-check"></i> Unblock Peserta</button>
                <button class="btn btn-sm btn-secondary" onclick="location.reload()" data-toggle="tooltip" data-placement="top" title="reload"><i class="icon-refresh"></i> Refresh</button>
            </div>
        </div>

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
                        <th><a wire:click.prevent="sortBy('nama')" role="button" href="#">
                            Nama
                            @include('includes._sort-icon', ['field' => 'nama'])
                        </a></th>
                        <th><a wire:click.prevent="sortBy('nik')" role="button" href="#">
                            NIK
                            @include('includes._sort-icon', ['field' => 'nik'])
                        </a></th>
                        <th><a wire:click.prevent="sortBy('nip')" role="button" href="#">
                            NIPTT-PK
                            @include('includes._sort-icon', ['field' => 'nip'])
                        </a></th>
                        <th><a wire:click.prevent="sortBy('sesi')" role="button" href="#">
                            Sesi
                            @include('includes._sort-icon', ['field' => 'sesi'])
                        </a></th>
                        <th><a wire:click.prevent="sortBy('blokir')" role="button" href="#">
                            Blokir
                            @include('includes._sort-icon', ['field' => 'blokir'])
                        </a></th>
			<th><a wire:click.prevent="sortBy('last_login')" role="button" href="#">
                            Status Login
                            @include('includes._sort-icon', ['field' => 'last_login'])
                        </a></th>
                        <th><a wire:click.prevent="sortBy('jabatan_id')" role="button" href="#">
                            Jabatan
                            @include('includes._sort-icon', ['field' => 'jabatan_id'])
                        </a></th>
                        <th>Action(s)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peserta as $key => $row)
                    <tr>
                        <td>{{ $peserta->firstItem() + $key }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->nik }}</td>
                        <td>{{ $row->nip }}</td>
                        <td>{{ $row->sesi }}</td>
                        <td>{{ $row->blokir }}</td>
			<td>{{ $row->last_login == null ? 'Belum' : 'Sudah' }}</td>
                        <td>{{ $row->jabatan->nama_jabatan }}</td>
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
                {{ $peserta->links() }}
            </div>
    
            <div class="col text-right text-muted">
                Showing {{ $peserta->firstItem() }} to {{ $peserta->lastItem() }} out of {{ $peserta->total() }} results
            </div>
        </div>
    </div>    
</div>

<!-- Import Excel -->
<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('import-skb') }}" enctype="multipart/form-data">
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
                    <div class="form-group">
                        <a href="{{ url('/admin/download-skb') }}" class="btn btn-sm btn-success"><i class="fa fa-file-excel"></i> Download format</a>
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

<!-- Blokir Peserta -->
<div class="modal fade" id="blokir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('blokir-peserta-skb') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Blokir Peserta Terlambat</h5>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('patch')
                    <label>Pilih Sesi</label>
                    <div class="form-group">
                        <select class="form-control form-control-sm" name="sesi">
                            @php $sesi = App\PesertaSkb::getSesi(); @endphp
                            @foreach ($sesi as $s)
                            <option value="{{ $s->sesi }}">{{ $s->sesi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Blokir</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Unblock Peserta -->
<div class="modal fade" id="unblock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('unblock-peserta-skb') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Unblock Peserta</h5>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('patch')
                    <label>Pilih Sesi</label>
                    <div class="form-group">
                        <select class="form-control form-control-sm" name="sesi">
                            @php $sesi = App\PesertaSkb::getSesi(); @endphp
                            @foreach ($sesi as $s)
                            <option value="{{ $s->sesi }}">{{ $s->sesi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Unblock</button>
                </div>
            </div>
        </form>
    </div>
</div>
