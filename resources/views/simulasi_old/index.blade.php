@extends('layouts.app-sim')

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card" id="card">
                <div class="card-header alert-secondary text-center h5"><strong>INFORMASI PESERTA DAN TES</strong></div>            
                <div class="card-body">
                    <div class="row">
                        <div class="col-4"><strong>Nama Lengkap</strong></div>
                        <div class="col-8">: &nbsp; {{ Auth::guard('peserta-sim')->user()->nama }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4"><strong>Email / Username</strong></div>
                        <div class="col-8">: &nbsp; {{ Auth::guard('peserta-sim')->user()->email . ' / ' . Auth::guard('peserta-sim')->user()->username }}</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-4"><strong>Jumlah Soal</strong></div>
                        <div class="col-8">: &nbsp; 100</div>
                    </div>
                    <div class="row">
                        <div class="col-4"><strong>Waktu</strong></div>
                        <div class="col-8">: &nbsp; 90 menit</div>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <form method="POST" action="{{ route('logout-sim') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger mr-2">Logout</button>
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
            url = "{{ route('ujian-sim.store') }}";

        $.ajax({
            url: url,
            type: type,
            dataType: 'json',
            success: function(data) {
                $('#card').hide();
                $('#loading').show();
                // window.location.assign("/simulasi/ujian/1");
                $.ajax({
                    url: "{{ route('ujian-sim.show', 1) }}",
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
            
