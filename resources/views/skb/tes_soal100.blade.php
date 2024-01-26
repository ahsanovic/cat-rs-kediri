@extends('layouts.app-skb-tes')

@section('content')
<!-- Sidebar  -->
<nav id="sidebar">
    <div class="list-group list-group-flush overflow-auto vh-100 mt-1">
        @php
            $nomor_soal = 1;
            $kosong = 0;
        @endphp
        @for ($i = 1; $i <= 20 ; $i++)
        <div class="btn-toolbar ml-2" role="toolbar" aria-label="Toolbar with button groups">
            @for ($j = 1; $j <= 5; $j++)
            <div class="btn-group mr-1" role="group" style="margin-left: 2px; margin-bottom: 2px;">
                <a 
                    href="#"
                    id="btn-soal<?= $nomor_soal ?>"
                    data-soal="{{ route('ujian-skb.show', ['id' => $nomor_soal]) }}"
                    class="btn btn-<?php 
                        if($jawaban[$nomor_soal - 1] == '0') {
                            echo 'danger'; 
                            $kosong++; 
                        } else {
                            echo 'success text-white';
                        }
                        ?> btn-block" style="width: 40px;">{{ $nomor_soal++ }}
                </a>
            </div>
            @endfor
        </div>
        @endfor
    </div>
</nav>

<!-- Page Content  -->
<div id="content">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <h5 class="text-muted">Computer Based Test BKD Jatim</h5>
                        <small>{{ Auth::guard('peserta-skb')->user()->nama .' - '. Auth::guard('peserta-skb')->user()->nik .' / Sesi '. Auth::guard('peserta-skb')->user()->sesi }}</small>
                    </li>
                </ul>
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item">
                        <div class="alert alert-success text-center mr-4" style="width: 180px; height: 45px;">
                            Soal Dijawab: {{ 100 - $kosong }}
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="alert alert-danger text-center mr-4" style="width: 200px; height: 45px;">
                            Belum Dijawab: {{ $kosong }}
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="alert alert-info text-center mr-4" style="width: 150px; height: 45px;">
                            <strong><span class="time"></span></strong>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="alert alert-dark text-center mr-4" style="width: 100px; height: 45px;">
                            <a href="#" data-toggle="modal" data-target="#modal-finish">
                                <strong>Selesai</strong>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="card bg-light border-secondary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-lg-12">
                    <h5>Soal No. {{ $nomor_sekarang }}</h5>
                </div>
                <div class="col-md-6 col-lg-12 mb-3">
                    @if (preg_match("/<img/i", $soal->deskripsi))
                        {!!$soal->deskripsi!!}
                    @else 
                        {{ strip_tags(html_entity_decode($soal->deskripsi)) }}
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-12">
                    <form id="form-save">
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="radio" 
                                name="opsi" 
                                value="A" 
                                id="opsi1"
                                @if ($jawaban[$nomor_sekarang-1] == 'A')
                                    @php
                                    echo 'checked';
                                    @endphp
                                @endif
                            >
                            <label class="form-check-label" for="opsi1">
                                @if (preg_match("/<img/i", $soal->opsi1))
                                    A. {!!$soal->opsi1!!}
                                @else 
                                    A. {{ strip_tags(html_entity_decode($soal->opsi1)) }}
                                @endif
                            </label>
                        </div>
                        <div class="form-check">
                            <input 
                                class="form-check-input"
                                type="radio"
                                name="opsi"
                                value="B"
                                id="opsi2"
                                @if ($jawaban[$nomor_sekarang-1] == 'B')
                                    @php
                                    echo 'checked';
                                    @endphp
                                @endif
                            >
                            <label class="form-check-label" for="opsi2">
                                @if (preg_match("/<img/i", $soal->opsi2))
                                    B. {!!$soal->opsi2!!}
                                @else 
                                    B. {{ strip_tags(html_entity_decode($soal->opsi2)) }}
                                @endif
                            </label>
                        </div>
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="opsi"
                                value="C"
                                id="opsi3"
                                @if ($jawaban[$nomor_sekarang-1] == 'C')
                                    @php
                                    echo 'checked';
                                    @endphp
                                @endif
                            >
                            <label class="form-check-label" for="opsi3">
                                @if (preg_match("/<img/i", $soal->opsi3))
                                    C. {!!$soal->opsi3!!}
                                @else 
                                    C. {{ strip_tags(html_entity_decode($soal->opsi3)) }}
                                @endif
                            </label>
                        </div>
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="opsi"
                                value="D"
                                id="opsi4"
                                @if ($jawaban[$nomor_sekarang-1] == 'D')
                                    @php
                                    echo 'checked';
                                    @endphp
                                @endif
                            >
                            <label class="form-check-label" for="opsi4">
                                @if (preg_match("/<img/i", $soal->opsi4))
                                    D. {!!$soal->opsi4!!}
                                @else 
                                    D. {{ strip_tags(html_entity_decode($soal->opsi4)) }}
                                @endif
                            </label>
                        </div>
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="opsi"
                                value="E"
                                id="opsi5"
                                @if ($jawaban[$nomor_sekarang-1] == 'E')
                                    @php
                                    echo 'checked';
                                    @endphp
                                @endif
                            >
                            <label class="form-check-label" for="opsi5">
                                @if (preg_match("/<img/i", $soal->opsi5))
                                    E. {!!$soal->opsi5!!}
                                @else 
                                    E. {{ strip_tags(html_entity_decode($soal->opsi5)) }}
                                @endif
                            </label>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col md-6 lg-12 mt-4 d-flex">
                        <button 
                            type="submit" 
                            data-url="{{ route('ujian-skb.update', ['id' => $nomor_sekarang]) }}" 
                            data-next="{{ route('ujian-skb.show', ['id' => $nomor_sekarang + 1]) }}"
                            class="btn btn-sm btn-success mr-2" 
                            id="btn-save">Simpan & Lanjutkan
                        </button>
                    </form>
                    <a 
                        class="btn btn-sm btn-danger <?php if ($nomor_sekarang == 100) echo 'disabled'; ?>" 
                        data-url="{{ route('ujian-skb.show', ['id' => $nomor_sekarang + 1]) }}" 
                        id="btn-skip" 
                        href="#">Lewati Soal
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-finish" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">KONFIRMASI AKHIRI UJIAN</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">Nama Lengkap</div>
                    <div class="col-8">: &nbsp; {{ Auth::guard('peserta-skb')->user()->nama }}</div>
                </div>
                <div class="row">
                    <div class="col-4">NIK</div>
                    <div class="col-8">: &nbsp; {{ Auth::guard('peserta-skb')->user()->nik }}</div>
                </div>
                <!-- <div class="row">
                    <div class="col-4">NIPTT-PK</div>
                    <div class="col-8">: &nbsp; {{ Auth::guard('peserta-skb')->user()->nip }}</div>
                </div> -->
                <div class="row">
                    <div class="col-4">Jabatan Yang Dilamar</div>
                    <div class="col-8">: &nbsp; {{ $peserta->jabatan->nama_jabatan }}</div>
                </div>
                <div class="row">
                    <div class="col-4">Soal Dijawab</div>
                    <div class="col-8">: &nbsp; {{ 100 - $jawaban_kosong }}</div>
                </div>
                <div class="row">
                    <div class="col-4">Belum Dijawab</div>
                    <div class="col-8">: &nbsp; {{ $jawaban_kosong }}</div>
                </div>
                <div class="row">
                    <div class="col-4">Sisa Waktu</div>
                    <div class="col-8 text-danger time"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn-cancel" data-dismiss="modal">Batal</button>
                <form id="form-destroy">
                    <button 
                        type="submit" 
                        data-id="{{ Auth::guard('peserta-skb')->user()->id }}"
                        data-delete="{{ route('ujian-skb.destroy', ['peserta' => Auth::guard('peserta-skb')->user()->id]) }}"
                        data-dismiss="modal"
                        class="btn btn-danger" 
                        id="btn-finish">
                        <i class="fa fa-exclamation-triangle"></i> Selesai Ujian
                    </button>
                </form>
            </div>
      </div>
    </div>
  </div>
@endsection

@push('ajax')
    <script>
        $('.btn-group a').click(function(event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let url = $(this).data('soal');

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    $('#app').html(response.view);
                },
                error: function (xhr) {
                    var res = xhr.responseJSON; console.log(res);
                }
            });
        });

        $('#btn-skip').click(function(event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let url = $(this).data('url');

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    $('#app').html(response.view);
                },
                error: function (xhr) {
                    var res = xhr.responseJSON; console.log(res);
                }
            });
        });

        $('#btn-save').click(function(event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let url = $(this).data('url');
            let urlNext = $(this).data('next');
            let urlMax = "{{ route('ujian-skb.show', 100) }}";

            $.ajax({
                url: url,
                type: 'POST',
                dataType:  'json',
                data: $('#form-save').serialize(),
                success: function(data) {
                    if (data.error) {
                        location.reload();
                    } else {
                        // jika posisi soal di nomor 100
                        if (data.max) {
                            $.ajax({
                                url: urlMax,
                                type: "GET",
                                success: function(response) {
                                    $('#app').html(response.view);
                                },
                                error: function (xhr) {
                                    var res = xhr.responseJSON; console.log(res);
                                }
                            });
                        } else {
                            $.ajax({
                                url: urlNext,
                                type: "GET",
                                success: function(response) {
                                    $('#app').html(response.view);
                                },
                                error: function (xhr) {
                                    var res = xhr.responseJSON; console.log(res);
                                }
                            });
                        }
                    }
                },
                error: function (xhr) {
                    var res = xhr.responseJSON; console.log(res);
                }
            });
        });

        $('#btn-finish').click(function(event) {
            event.preventDefault();
            let url = $(this).data('delete');
            let csrf_token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },
                success: function(response) {
                    $('#app').html(response.view);
                },
                error: function (xhr) {
                    var res = xhr.responseJSON; console.log(res);
                }
            });
        });
    </script>
@endpush

@push('time')
    <script>
        var waktuJS = new Date({{$waktu}} * 1000).getTime();
        // var waktuJS = <?php echo $waktu ?> * 1000;
        // var now = <?php echo time() ?> * 1000;
	    var waktuJS = waktuJS + 5400000;

        // Update the count down every 1 second
        var x = setInterval(function() {
            // Get todays date and time
            // 1. JavaScript
            var now = new Date().getTime();
            // 2. PHP
            // now = now + 1000;

            // Find the distance between now an the count down date
            var distance = waktuJS - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            $('.time').html(('0' + hours).slice(-2) + " : " + ('0' + minutes).slice(-2) + " : " + ('0' + seconds).slice(-2) + "");

            // If the count down is over, write some text 
            if (distance < 0) {
                clearInterval(x);
                $('.time').html('Waktu Habis');
                $('#modal-finish').modal('show');
                $('#btn-cancel').remove();
            }
        }, 1000);
    </script>
@endpush
