@extends('layouts.app')

@section('content')
<h4>Data Soal SKB</h4>
@if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sukses!</strong> {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-sm btn-primary pull-right" title="Create Soal" href="{{ route('soal-skb.create') }}" ><i class="icon-plus"></i>
            Create</a>
    </div>
</div>
<div class="card bg-light border-primary mt-2">
    <div class="card-header">Data Soal SKB</div>
    <div class="card-body">
        <h6 class="text-danger"><i class="fa fa-filter"></i> Filter Berdasarkan :</h6>
        <div class="row mb-3">
            <div class="col-md-2">
                <form action="{{ url()->current() }}" method="get">
                    <div class="form-group">
                        <label>Rumpun Jabatan</label>
                        <select class="form-control form-control-sm" name="rumpun">
                            <option disabled selected>- pilih rumpun -</option>
                            @foreach ($rumpun as $id => $r)
                                <option value="{{ $id }}" <?php if (Request::query('rumpun') == $id) echo 'selected'; ?>>{{ $r }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="col-md-4">                
                <div class="form-group">
                    <label>Jabatan</label>
                    <select class="form-control form-control-sm" name="jabatan">
                        <option disabled selected>- pilih jabatan -</option>
                        @foreach ($jabatan as $id => $j)
                            <option value="{{ $id }}" <?php if (Request::query('jabatan') == $id) echo 'selected'; ?>>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Deskripsi Soal</label>
                    <input type="text" name="deskripsi" class="form-control form-control-sm" value="{{ Request::query('deskripsi') }}"/>
                </div>
            </div>
            <div class="col-md-2 mt-2">
                <br/>
                <button type="submit" class="btn btn-sm btn-success">search</button>
                <a href="{{ route('soal-skb') }}" class="btn btn-sm btn-danger">reset</a>
            </div>
                </form>
        </div>
        <div class="table-responsive">
            <table class="table table-hover" id="datatable" width="100%">
                <thead>
                    <tr>
                        <th style="width:4%">No</th>
                        <th>Deskripsi</th>
                        <th>Rumpun</th>
                        <th>Jabatan</th>
                        <th style="width:8%">Action(s)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($soal_skb as $key => $row)
                    <tr>
                        <td>{{ $soal_skb->firstItem() + $key }}</td>
                        <td>
                            @if (preg_match("/<img/i", $row->deskripsi))
                                {!!$row->deskripsi!!}
                            @else 
                                {{ strip_tags(html_entity_decode($row->deskripsi)) }}
                            @endif
                        </td>
                        <td>{{ $row->rumpun->rumpun_jabatan }}</td>
                        <td>{{ $row->jabatan->nama_jabatan }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('soal-skb.edit', $row->id) }}" class="btn btn-sm btn-outline-success mb-1 mr-1" data-toggle="tooltip" data-placement="top" title="edit"><i class="fa fa-edit"></i></a>
                                <a href="{{ route('soal-skb.view', $row->id) }}" class="btn btn-sm btn-outline-info mb-1 mr-1" data-toggle="tooltip" data-placement="top" title="view" target="_blank"><i class="fa fa-eye"></i></a>
                                <form class="delete" method="POST" action="{{ route('soal-skb.destroy', $row->id) }}">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="delete"><i class="fa fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col">
                {{ $soal_skb->links() }}
            </div>    
            <div class="col text-right text-muted">
                Showing {{ $soal_skb->firstItem() }} to {{ $soal_skb->lastItem() }} out of {{ $soal_skb->total() }} results
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        $('.delete').on('submit', function(){
            return confirm('Hapus Soal ?');
        });
    </script>
@endpush
