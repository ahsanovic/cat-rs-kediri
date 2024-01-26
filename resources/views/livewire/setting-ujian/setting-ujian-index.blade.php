<div>
    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <strong>Sukses!</strong> {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if ($updateMode)
    @include('livewire.setting-ujian.update')
    @else
    @include('livewire.setting-ujian.create')
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

        <div class="col-md-2">
            <input wire:model="search" class="form-control form-control-sm" type="text" placeholder="search...">
        </div>
    </div>

    <div class="row">
        <table class="table table-hover" id="datatable" width="100%">
            <thead>
                <tr>
                    <th style="width:4%">No</th>
                    <th style="width:15%">
                        <a wire:click.prevent="sortBy('jenis_ujian')" role="button" href="#">
                            Jenis Ujian
                            @include('includes._sort-icon', ['field' => 'jenis_ujian'])
                        </a>
                    </th>
                    <th style="width:15%">
                        <a wire:click.prevent="sortBy('jumlah_soal')" role="button" href="#">
                            Jumlah Soal
                            @include('includes._sort-icon', ['field' => 'jumlah_soal'])
                        </a>
                    </th>
                    <th style="width:15%">
                        <a wire:click.prevent="sortBy('waktu')" role="button" href="#">
                            Waktu Ujian
                            @include('includes._sort-icon', ['field' => 'waktu'])
                        </a>
                    </th>
                    <th style="width:15%">
                        <a wire:click.prevent="sortBy('nilai_per_soal')" role="button" href="#">
                            Nilai Per Soal
                            @include('includes._sort-icon', ['field' => 'nilai_per_soal'])
                        </a>
                    </th>
                    <th style="width:10%">
                        <a wire:click.prevent="sortBy('is_active')" role="button" href="#">
                            Aktif ?
                            @include('includes._sort-icon', ['field' => 'is_active'])
                        </a>
                    </th>
                    <th style="width:10%">Action(s)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($settingUjian as $key => $row)
                <tr>
                    <td>{{ $settingUjian->firstItem() + $key }}</td>
                    <td>{{ $row->jenis_ujian }}</td>
                    <td>{{ $row->jumlah_soal }}</td>
                    <td>{{ $row->waktu }} menit</td>
                    <td>{{ $row->nilai_per_soal }}</td>
                    <td>{{ $row->is_active }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-success" wire:click="edit({{ $row->id }})"><i
                                class="fa fa-edit"></i></button>
                        @if ($confirming === $row->id)
                        <button wire:click="destroy({{ $row->id }})" class="btn btn-sm btn-danger" data-toggle="tooltip"
                            data-placement="top" title="anda yakin akan menghapus data ini ?"><i
                                class="fa fa-exclamation-circle"></i> Sure ?</button>
                            <button wire:click="cancelDelete()" class="btn btn-sm btn-outline-primary"><i class="fa fa-times"></i> Cancel</button>
                        @else
                        <button wire:click="confirmDelete({{ $row->id }})" class="btn btn-sm btn-outline-danger"><i
                                class="fa fa-trash"></i></button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col">
            {{ $settingUjian->links() }}
        </div>

        <div class="col text-right text-muted">
            Showing {{ $settingUjian->firstItem() }} to {{ $settingUjian->lastItem() }} out of {{ $settingUjian->total() }} results
        </div>
    </div>
</div>
