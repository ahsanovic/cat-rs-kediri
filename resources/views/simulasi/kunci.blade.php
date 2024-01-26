@extends('layouts.app-sim-tes')

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
                    href="{{ route('kunci', ['ujian' => $ujianId, 'id' => $nomor_soal]) }}"
                    id="btn-soal<?= $nomor_soal ?>"
                    {{-- data-soal="{{ route('kunci', ['ujianId' => $ujianId, 'id' => $nomor_soal]) }}" --}}
                    class="btn btn-success text-white btn-block" style="width: 40px;">{{ $nomor_soal++ }}
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
                        <h5 class="text-muted">Simulasi CAT BKD</h5>
                        <small>{{ Auth::guard('peserta-sim')->user()->nama .' - '. Auth::guard('peserta-sim')->user()->email}}</small>
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
                    <h5 class="text-danger">
                        Jawaban Anda: 
                        @php
                            if ($jawaban[$nomor_sekarang-1] == '0') {
                                echo '-';
                            } else {
                                echo $jawaban[$nomor_sekarang-1];
                            }
                        @endphp
                    </h5>
                </div>
            </div>
            <div class="row">
                <div class="col md-6 lg-12 d-flex">
                    <?php
                        if ($soal->jenis_id == 3) { ?>
                            <h5 class="text-success">Jawaban Benar (Poin 5-4-3-2-1): {{ $kunci[$nomor_sekarang-1] }}</h5>
                    <?php 
                        } else { ?>
                            <h5 class="text-success">Jawaban Benar: {{ $kunci[$nomor_sekarang-1] }}</h5>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection