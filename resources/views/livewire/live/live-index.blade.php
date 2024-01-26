<div>
    <div>
        <h4>Livescore Tes SKD</h4>

        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row mb-3 mt-4">
            <div class="col-md-6">
                <button class="btn btn-sm btn-danger" onclick="confirm('Hapus Semua Tes ?') || event.stopImmediatePropagation()" wire:click="deleteAll" data-toggle="tooltip" data-placement="top" title="hapus semua tes"><i class="fa fa-trash"></i> Delete All</button>
                <button class="btn btn-sm btn-secondary" onclick="location.reload()" data-toggle="tooltip" data-placement="top" title="reload"><i class="icon-refresh"></i> Refresh</button>
                <a href="{{ route('livescore') }}" target="_blank" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="livescore"><i class="icon-list-ol"></i> Livescore</a>
		<button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#resetwaktu" title="reset waktu ujian"><i class="fa fa-times"></i> Reset Waktu Ujian</button>
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
			<th><center><a wire:click.prevent="sortBy('status')" role="button" href="#">
                            Status
                            @include('includes._sort-icon', ['field' => 'status'])
                        </a></center></th>
                        <th><center><a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                            Mulai Tes
                            @include('includes._sort-icon', ['field' => 'created_at'])
                        </a></center></th>
                        <th><center>Action(s)</center></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($live as $key => $ujian)
                    <tr>
                        <td>{{ $live->firstItem() + $key }}</td>
                        <td>{{ $ujian->nama }}</td>
                        <td>{{ $ujian->nik }}</td>
                        <td>{{ $ujian->nip }}</td>
                        <td>{{ $ujian->sesi }}</td>
                        <td>{{ $ujian->nilaitwk }}</td>
                        <td>{{ $ujian->nilaitiu }}</td>
                        <td>{{ $ujian->nilaitkp }}</td>
                        <td>{{ $ujian->nilai_total }}</td>
			<td>{{ $ujian->status == 0 ? 'UJIAN' : 'SELESAI' }}</td>
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
                {{ $live->links() }}
            </div>

            <div class="col text-right text-muted">
                Showing {{ $live->firstItem() }} to {{ $live->lastItem() }} out of {{ $live->total() }} results
            </div>
        </div>
    </div>
</div>


<!-- Reset Waktu Ujian -->
<div class="modal fade" id="resetwaktu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('reset-waktu-ujian-skd') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reset Waktu Ujian</h5>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('patch')
                    <label>Set Waktu Ujian (y-m-d h:m:s)</label>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="waktu" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Reset</button>
                </div>
            </div>
        </form>
    </div>
</div>
