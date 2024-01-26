@extends('layouts.app')

@section('content')
<h4>Data Soal SKB</h4>
<div class="row">
    <div class="col-md-12">        
        <a class="btn btn-sm btn-danger pull-right" href="{{ route('soal-skb') }}" ><i class="icon-arrow-left"></i>
            Kembali</a>
    </div>
</div>
<div class="card bg-light border-primary mt-2">
    <div class="card-header">Form Edit Soal SKB</div>
    <div class="card-body">
        <form id="form" method="POST" action="{{ route('soal-skb.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <input type="hidden" value="{{ $soal->id }}" name="id">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="rumpun">Rumpun Jabatan</label>
                        <select class="form-control form-control-sm" id="rumpun" name="rumpun">
                            @foreach ($rumpun as $key => $value)
                                <option value="{{ $key }}" @if($key == $soal->rumpun_id ) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
    
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jabatan">Nama Jabatan</label>
                        <select class="form-control form-control-sm" id="jabatan" name="jabatan">
                            @foreach ($jabatan as $j)
                            <option value="{{ $j->id }}" @if($j->id == $soal->rumpun_id) selected @endif>{{ $j->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Soal</label>
                        <textarea class="form-control" name="deskripsi" id="ckeditor">{{ $soal->deskripsi }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="opsi1">Pilihan Jawaban A</label>
                        <textarea class="form-control" name="opsi1" id="ckeditorA">{{ $soal->opsi1 }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="opsi3">Pilihan Jawaban B</label>
                        <textarea class="form-control" name="opsi2" id="ckeditorC">{{ $soal->opsi2 }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="opsi5">Pilihan Jawaban C</label>
                        <textarea class="form-control" name="opsi3" id="ckeditorE">{{ $soal->opsi3 }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="opsi2">Pilihan Jawaban D</label>
                        <textarea class="form-control" name="opsi4" id="ckeditorB">{{ $soal->opsi4 }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="opsi4">Pilihan Jawaban E</label>
                        <textarea class="form-control" name="opsi5" id="ckeditorD">{{ $soal->opsi5 }}</textarea>
                    </div>
                    <div class="form-group mt-3">
                        <label for="jawaban">Jawaban Benar</label>
                        <select name="jawaban" id="jawaban" class="form-control form-control-sm @if ($errors->has('jawaban')) is-invalid  @endif">
                            <option value="A" {{ ($soal->jawaban == 'A') ? 'selected' : '' }}>A</option>
                            <option value="B" {{ ($soal->jawaban == 'B') ? 'selected' : '' }}>B</option>
                            <option value="C" {{ ($soal->jawaban == 'C') ? 'selected' : '' }}>C</option>
                            <option value="D" {{ ($soal->jawaban == 'D') ? 'selected' : '' }}>D</option>
                            <option value="E" {{ ($soal->jawaban == 'E') ? 'selected' : '' }}>E</option>
                        </select>
                        @error('jawaban')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mt-5">
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                        <a class="btn btn-sm btn-danger" href="{{ route('soal-skb') }}">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $('#rumpun').change(function(){
                rumpun_id = $(this).val();

                if (rumpun_id) {
                    $.ajax({
                    type: "GET" ,
                    url: "{{ route('get-jabatan') }}?rumpun_id=" + rumpun_id,
                    success: function(data) {
                            if (data) {
                                $('#jabatan').empty();
                                $('#jabatan').append(`<option selected disabled>- pilih jabatan -</option>`);
                                $.each(data,function(key,value) {
                                    $('#jabatan').append('<option value="' + key + '">' + value + '</option>');
                                });
                            } else {
                                $('#jabatan').empty();
                            }
                    }
                    });
                } else {
                    $('#jabatan').empty();
                }
            });
        });
    </script>
@endpush

@push('ckeditor')
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('ckeditor', {
            filebrowserUploadUrl: "{{route('soal-skb.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('ckeditorA', {
            filebrowserUploadUrl: "{{route('soal-skb.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('ckeditorB', {
            filebrowserUploadUrl: "{{route('soal-skb.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('ckeditorC',
        {
            filebrowserUploadUrl: "{{route('soal-skb.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('ckeditorD', {
            filebrowserUploadUrl: "{{route('soal-skb.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('ckeditorE', {
            filebrowserUploadUrl: "{{route('soal-skb.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
