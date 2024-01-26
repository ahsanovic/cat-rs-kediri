@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Dashboard</h4>
    <div class="row">        
        <div class="col-md-3">
            <h5>SKD</h5>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3 mb-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h4 class="font-weight-bold">{{ $soal }}</h4>
                    <div class="mr-5">Soal</div>
                </div>
                <a href="{{ route('soal') }}">
                    <div class="card-footer clearfix small z-1">
                        <span class="float-left">Lihat Soal</span>
                        <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h4 class="font-weight-bold">{{ $peserta }}</h4>
                    <div class="mr-5">Peserta</div>
                </div>
                <a href="{{ route('peserta') }}">
                    <div class="card-footer clearfix small z-1">
                        <span class="float-left">Lihat Peserta</span>
                        <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h4 class="font-weight-bold">{{ $ujian }}</h4>
                    <div class="mr-5">Ujian Berlangsung</div>
                </div>
                <a href="{{ route('live') }}">
                    <div class="card-footer clearfix small z-1">
                        <span class="float-left">Lihat Nilai</span>
                        <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h4 class="font-weight-bold">{{ $hasil }}</h4>
                    <div class="mr-5">Ujian Selesai</div>
                </div>
                <a href="{{ route('hasil') }}">
                    <div class="card-footer clearfix small z-1">
                        <span class="float-left">Lihat Hasil Tes</span>
                        <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">        
        <div class="col-md-3">
            <h5>Simulasi SKD</h5>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3 mb-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h4 class="font-weight-bold">{{ $soal_sim }}</h4>
                    <div class="mr-5">Soal</div>
                </div>
                <a href="{{ route('soal-sim') }}">
                    <div class="card-footer clearfix small z-1">
                        <span class="float-left">Lihat Soal</span>
                        <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h4 class="font-weight-bold">{{ $peserta_sim }}</h4>
                    <div class="mr-5">Peserta</div>
                </div>
                <a href="{{ route('peserta-sim') }}">
                    <div class="card-footer clearfix small z-1">
                        <span class="float-left">Lihat Peserta</span>
                        <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h4 class="font-weight-bold">{{ $ujian_sim }}</h4>
                    <div class="mr-5">Ujian Berlangsung</div>
                </div>
                <a href="{{ route('live-sim') }}">
                    <div class="card-footer clearfix small z-1">
                        <span class="float-left">Lihat Nilai</span>
                        <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h4 class="font-weight-bold">{{ $hasil_sim }}</h4>
                    <div class="mr-5">Ujian Selesai</div>
                </div>
                <a href="{{ route('hasil-sim') }}">
                    <div class="card-footer clearfix small z-1">
                        <span class="float-left">Lihat Hasil Tes</span>
                        <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">        
        <div class="col-md-3">
            <h5>SKB</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h4 class="font-weight-bold">{{ $soal_skb }}</h4>
                    <div class="mr-5">Soal</div>
                </div>
                <a href="{{ route('soal-skb') }}">
                    <div class="card-footer clearfix small z-1">
                        <span class="float-left">Lihat Soal</span>
                        <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h4 class="font-weight-bold">{{ $peserta_skb }}</h4>
                    <div class="mr-5">Peserta</div>
                </div>
                <a href="{{ route('peserta-skb') }}">
                    <div class="card-footer clearfix small z-1">
                        <span class="float-left">Lihat Peserta</span>
                        <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h4 class="font-weight-bold">{{ $ujian_skb }}</h4>
                    <div class="mr-5">Ujian Berlangsung</div>
                </div>
                <a href="{{ route('live-skb') }}">
                    <div class="card-footer clearfix small z-1">
                        <span class="float-left">Lihat Nilai</span>
                        <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h4 class="font-weight-bold">{{ $hasil_skb }}</h4>
                    <div class="mr-5">Ujian Selesai</div>
                </div>
                <a href="{{ route('hasil-skb') }}">
                    <div class="card-footer clearfix small z-1">
                        <span class="float-left">Lihat Hasil Tes</span>
                        <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
