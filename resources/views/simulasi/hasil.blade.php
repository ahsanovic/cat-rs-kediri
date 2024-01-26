@extends('layouts.app-sim')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card" id="card">
            <div class="card-header alert-secondary text-center h5"><strong>HASIL TES</strong></div>            
            <div class="card-body">
                <div class="row" style="padding-left: 2em;">
                    <div class="col-8">
                        <ul class="list-unstyled text-left" style="font-weight: 500;">
                            <li>Tes Wawasan Kebangsaan</li>
                            <li>Tes Intelegensia Umum</li>
                            <li>Tes Karakteristik Pribadi</li>
                        </ul>
                    </div>
                    <div class="col-1">
                        <ul class="list-unstyled text-left">
                            <li>:</li>
                            <li>:</li>
                            <li>:</li>
                        </ul>
                    </div>
                    <div class="col-2">
                        <ul class="list-unstyled text-right">
                            <li>{{ $hasil->nilaitwk }}</li>
                            <li>{{ $hasil->nilaitiu }}</li>
                            <li>{{ $hasil->nilaitkp }}</li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="row" style="padding-left: 2em;">
                    <div class="col-8">
                        <ul class="list-unstyled text-left" style="font-weight: 500;">
                            <li>Total Nilai</li>
                        </ul>
                    </div>
                    <div class="col-1">
                        <ul class="list-unstyled text-left" style="font-weight: 500;">
                            <li>:</li>
                        </ul>
                    </div>
                    <div class="col-2">
                        <ul class="list-unstyled text-right">
                            <li>{{ $hasil->nilaitwk + $hasil->nilaitiu + $hasil->nilaitkp }}</li>
                        </ul>
                    </div>
                </div>
                <div class="row justify-content-center mt-4">
                    <form method="POST" action="{{ route('logout-sim') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger mr-2">Logout</button>
                    </form>
                    <form id="form">
                        <button type="submit" class="btn btn-primary" id="btn-start">Coba Lagi</button>
                    </form>
		    <a href="{{ route('history') }}" target="_blank" class="btn btn-success ml-2">History Nilai</a>
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

@push('modal')
    <script>
        $('.modal-backdrop').remove();
    </script>
@endpush
