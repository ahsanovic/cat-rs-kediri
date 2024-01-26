@extends('layouts.app-skb')

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card" id="card">
                <div class="card-header alert-secondary text-center h5"><strong>INFORMASI PESERTA DAN TES</strong></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4"><strong>Nama Lengkap</strong></div>
                        <div class="col-8">: &nbsp; {{ Auth::guard('peserta-skb')->user()->nama }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4"><strong>NIK</strong></div>
                        <div class="col-8">: &nbsp; {{ Auth::guard('peserta-skb')->user()->nik }}</div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-4"><strong>NIPTT-PK</strong></div>
                        <div class="col-8">: &nbsp; {{ Auth::guard('peserta-skb')->user()->nip }}</div>
                    </div> -->
                    <div class="row">
                        <div class="col-4"><strong>Sesi</strong></div>
                        <div class="col-8">: &nbsp; {{ Auth::guard('peserta-skb')->user()->sesi }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4"><strong>Jabatan Dilamar</strong></div>
                        <div class="col-8">: &nbsp; {{ $peserta->jabatan->nama_jabatan }}</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-4"><strong>Jumlah Soal</strong></div>
                        <div class="col-8">: &nbsp; {{ $setting->jumlah_soal }} soal</div>
                    </div>
                    <div class="row">
                        <div class="col-4"><strong>Waktu</strong></div>
                        <div class="col-8">: &nbsp; {{ $setting->waktu }} menit</div>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <form method="POST" action="{{ route('logout-skb') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger mr-2" id="btn-logout">Logout</button>
                        </form>
                        <form id="form">
                            <button type="submit" class="btn btn-primary" id="btn-start">Mulai</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 justify-content-center" id="loading" style="display: none;">
            <img class="mx-auto d-block" src="/storage/img/loader.gif" />
        </div>
    </div>
@endsection

@push('ajax')
<script>
    $('#btn-start').click(function(event) {
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var type = 'POST',
            url = "{{ route('ujian-skb.store') }}";

        $.ajax({
            url: url,
            type: type,
            dataType: 'json',
	    beforeSend: function() {
                $('#btn-start').prop('disabled', true);
            },
            success: function(data) {
                $('#card').hide();
                $('#loading').show();
                // window.location.assign("/simulasi/ujian/1");
                $.ajax({
                    url: "{{ route('ujian-skb.show', 1) }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#loading').hide();
                        $('#app').html(response.view);
                    },
                    error: function (xhr) {
                        var res = xhr.responseJSON; console.log(res);
                    }
                });
            },
            error: function (xhr) {
                var res = xhr.responseJSON; console.log(res);
            }
        });
    });
</script>
@endpush

