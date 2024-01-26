@extends('layouts.app')

@section('content')
<h4>Data Soal</h4>
<div class="row">
    <div class="col-md-12">        
        <a class="btn btn-sm btn-danger pull-right" href="{{ route('soal-sim') }}" ><i class="icon-arrow-left"></i>
            Kembali</a>
    </div>
</div>
<div class="card bg-light border-primary mt-2">
    <div class="card-header">Form Edit Soal</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="jenis">Jenis Soal</label>
                    <select class="form-control form-control-sm" id="jenis">
                        <option selected disabled>- pilih jenis soal -</option>
                        @foreach ($jenis as $key => $value)
                            <option value="{{ $key }}" @if($key == $soal->jenis_id ) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
            <!-- Form Non TKP -->
            <div id="formnontkp" style="<?php if ($soal->jenis_id != 3) { echo 'display:block;'; } else { echo 'display:none;'; } ?>">
                <form id="form" method="POST" action="{{ route('soal-sim.update', ['id' => $soal->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="jenis" id="jenis_id" value="{{ $soal->jenis_id }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bidang">Bidang Soal</label>
                                <select class="form-control form-control-sm bidang @if ($errors->has('bidang')) is-invalid  @endif" id="bidang" name="bidang">
                                    @foreach ($bidang as $b)
                                    <option value="{{ $b->id }}" @if($b->id == $soal->bidang_id) selected @endif>{{ $b->bidang }}</option>                                
                                    @endforeach
                                </select>
                                @error('bidang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="subbidang">Sub Bidang Soal</label>
                                <select class="form-control form-control-sm subbidang @if ($errors->has('subbidang')) is-invalid  @endif" id="subbidang" name="subbidang">
                                    @foreach ($subbidang as $sb)
                                    <option value="{{ $sb->id }}" @if($sb->id == $soal->subbidang_id) selected @endif>{{ $sb->subbidang }}</option>                                
                                    @endforeach
                                </select>
                                @error('subbidang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
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
                                <textarea class="form-control" name="opsi2" id="ckeditorB">{{ $soal->opsi2 }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="opsi5">Pilihan Jawaban C</label>
                                <textarea class="form-control" name="opsi3" id="ckeditorC">{{ $soal->opsi3 }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="opsi2">Pilihan Jawaban D</label>
                                <textarea class="form-control" name="opsi4" id="ckeditorD">{{ $soal->opsi4 }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="opsi4">Pilihan Jawaban E</label>
                                <textarea class="form-control" name="opsi5" id="ckeditorE">{{ $soal->opsi5 }}</textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="jawaban">Jawaban Benar</label>
                                <select name="jawaban" class="form-control form-control-sm @if ($errors->has('jawaban')) is-invalid  @endif">
                                    <option value="" selected disabled>- pilih jawaban -</option>
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
                                <a class="btn btn-sm btn-danger" href="{{ route('soal') }}">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Form TKP -->
            <div id="formtkp" style="<?php if ($soal->jenis_id == 3) { echo 'display:block;'; } else { echo 'display:none;'; } ?>">
                <form id="form" method="POST" action="{{ route('soal-sim.update', ['id' => $soal->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="jenis" id="jenis-id" value="{{ $soal->jenis_id }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bidang">Bidang Soal</label>
                                <select class="form-control form-control-sm bidang @if ($errors->has('bidang')) is-invalid  @endif" id="bidang" name="bidang">
                                    @foreach ($bidang as $b)
                                    <option value="{{ $b->id }}" @if($b->id == $soal->bidang_id) selected @endif>{{ $b->bidang }}</option>                                
                                    @endforeach
                                </select>
                                @error('bidang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="subbidang">Sub Bidang Soal</label>
                                <select class="form-control form-control-sm subbidang @if ($errors->has('subbidang')) is-invalid  @endif" id="subbidang" name="subbidang">
                                    @foreach ($subbidang as $sb)
                                    <option value="{{ $sb->id }}" @if($sb->id == $soal->subbidang_id) selected @endif>{{ $sb->subbidang }}</option>                                
                                    @endforeach
                                </select>
                                @error('subbidang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi Soal</label>
                                <textarea class="form-control" name="deskripsi" id="ckeditorDesc">{{ $soal->deskripsi }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="opsi1">Pilihan Jawaban A</label>
                                <textarea class="form-control" name="opsi1" id="ckeditor-A">{{ $soal->opsi1 }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="opsi3">Pilihan Jawaban B</label>
                                <textarea class="form-control" name="opsi2" id="ckeditor-B">{{ $soal->opsi2 }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="opsi5">Pilihan Jawaban C</label>
                                <textarea class="form-control" name="opsi3" id="ckeditor-C">{{ $soal->opsi3 }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="opsi2">Pilihan Jawaban D</label>
                                <textarea class="form-control" name="opsi4" id="ckeditor-D">{{ $soal->opsi4 }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="opsi4">Pilihan Jawaban E</label>
                                <textarea class="form-control" name="opsi5" id="ckeditor-E">{{ $soal->opsi5 }}</textarea>
                            </div>
                            <div class="mt-5">
                                <label for="kuncitkp">Kunci Jawaban TKP</label>
                                <select name="kunci1" id="kunci1" onchange="setKunci1()" class="form-control form-control-sm mb-2" style="width:200px;">
                                    <option disabled selected>- Skor 5 -</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select>
                                <select name="kunci2" id="kunci2" onchange="setKunci2()" class="form-control form-control-sm mb-2" style="width:200px;">
                                    <option disabled selected>- Skor 4 -</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select>
                                <select name="kunci3" id="kunci3" onchange="setKunci3()" class="form-control form-control-sm mb-2" style="width:200px;">
                                    <option disabled selected>- Skor 3 -</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select>
                                <select name="kunci4" id="kunci4" onchange="setKunci4()" class="form-control form-control-sm mb-2" style="width:200px;">
                                    <option disabled selected>- Skor 2 -</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select>
                                <select name="kunci5" id="kunci5" onchange="setKunci5()" class="form-control form-control-sm mb-2" style="width:200px;">
                                    <option disabled selected>- Skor 1 -</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <label for="jawaban">Jawaban Benar</label>
                                <input type="text" readonly id="jawaban" 
                                    class="form-control form-control-sm @if ($errors->has('jawaban')) is-invalid  @endif" 
                                    name="jawaban" 
                                    value="{{ $soal->jawaban }}">
                                @error('jawaban')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group mt-5">
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                <a class="btn btn-sm btn-danger" href="{{ route('soal') }}">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
    </div>
</div>
@endsection

@push('script')
    <script type="text/javascript">
        var kunci1,kunci2,kunci3,kunci4,kunci5,kuncitkp; 
        if (kunci1 == undefined || kunci2 == undefined || kunci3 == undefined || kunci4 == undefined || kunci5 == undefined) { 
            kunci1 = "-"; 
            kunci2 = "-"; 
            kunci3 = "-"; 
            kunci4 = "-"; 
            kunci5 = "-"; 
        } 
        function setKunci1(){ 
            kunci1 = document.getElementById('kunci1').value; 
            var kuncitkp = kunci1.concat(kunci2,kunci3,kunci4,kunci5); 
            document.getElementById("jawaban").value = kuncitkp; 
        }
        function setKunci2(){ 
            kunci2 = document.getElementById('kunci2').value; 
            var kuncitkp = kunci1.concat(kunci2,kunci3,kunci4,kunci5); 
            document.getElementById("jawaban").value = kuncitkp; 
        }
        function setKunci3(){ 
            kunci3 = document.getElementById('kunci3').value; 
            var kuncitkp = kunci1.concat(kunci2,kunci3,kunci4,kunci5); 
            document.getElementById("jawaban").value = kuncitkp; 
        }
        function setKunci4(){ 
            kunci4 = document.getElementById('kunci4').value; 
            var kuncitkp = kunci1.concat(kunci2,kunci3,kunci4,kunci5); 
            document.getElementById("jawaban").value = kuncitkp; 
        } 
        function setKunci5(){ 
            kunci5 = document.getElementById('kunci5').value; 
            var kuncitkp = kunci1.concat(kunci2,kunci3,kunci4,kunci5); 
            document.getElementById("jawaban").value = kuncitkp; 
        }
    </script>
    <script>
        $(document).ready(function(){
            $('#jenis').change(function(){
                jenis_id = $(this).val();
                formtkp = document.getElementById('formtkp');
                formnontkp = document.getElementById('formnontkp');

                if (jenis_id == 3) {
                    formtkp.style.display = 'block';
                    formnontkp.style.display = 'none';
                    $('#jenis-id').val(3);
                } else if (jenis_id == 1) {
                    formtkp.style.display = 'none';
                    formnontkp.style.display = 'block';
                    $('#jenis_id').val(1);
                } else if (jenis_id == 2) {
                    formtkp.style.display = 'none';
                    formnontkp.style.display = 'block';
                    $('#jenis_id').val(2);
                }
                
                if (jenis_id) {
                    $.ajax({
                    type: "GET" ,
                    url: "{{ route('get-bidang') }}?jenis_id=" + jenis_id,
                    success: function(data) {
                            if (data) {
                                $('.bidang').empty();
                                $('.bidang').append(`<option selected disabled>- pilih bidang soal -</option>`);
                                $('.subbidang').empty();
                                $('.subbidang').append(`<option selected disabled>- pilih sub bidang soal -</option>`);
                                $.each(data,function(key,value) {
                                    $('.bidang').append('<option value="' + key + '">' + value + '</option>');
                                });
                            } else {
                                $('.bidang').empty();
                            }
                    }
                    });
                } else {
                    $('.bidang').empty();
                    $('.subbidang').empty();
                }
            });

            $('.bidang').change(function(){
                bidang_id = $(this).val();
                if (bidang_id) {
                    $.ajax({
                    type: "GET" ,
                    url: "{{ route('get-subbidang') }}?bidang_id=" + bidang_id,
                    success: function(data) {
                            if (data) {
                                $('.subbidang').empty();
                                $('.subbidang').append(`<option selected disabled>- pilih sub bidang soal -</option>`);
                                $.each(data,function(key,value) {
                                    $('.subbidang').append('<option value="' + key + '">' + value + '</option>');
                                });
                            } else {
                                $('.subbidang').empty();
                            }
                    }
                    });
                } else {
                    $('.subbidang').empty();
                }
            });
        });
    </script>
@endpush

@push('ckeditor')
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('ckeditor', {
            filebrowserUploadUrl: "{{route('soal-sim.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('ckeditorA', {
            filebrowserUploadUrl: "{{route('soal-sim.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('ckeditorB', {
            filebrowserUploadUrl: "{{route('soal-sim.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('ckeditorC',
        {
            filebrowserUploadUrl: "{{route('soal-sim.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('ckeditorD', {
            filebrowserUploadUrl: "{{route('soal-sim.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('ckeditorE', {
            filebrowserUploadUrl: "{{route('soal-sim.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });

        CKEDITOR.replace('ckeditorDesc', {
            filebrowserUploadUrl: "{{route('soal-sim.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('ckeditor-A', {
            filebrowserUploadUrl: "{{route('soal-sim.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('ckeditor-B', {
            filebrowserUploadUrl: "{{route('soal-sim.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('ckeditor-C',
        {
            filebrowserUploadUrl: "{{route('soal-sim.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('ckeditor-D', {
            filebrowserUploadUrl: "{{route('soal-sim.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('ckeditor-E', {
            filebrowserUploadUrl: "{{route('soal-sim.image', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
