@extends('layouts.app-skb')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card" id="card">
            <div class="card-header alert-secondary text-center h5"><strong>HASIL NILAI TES</strong></div>
            <div class="card-body">
                <div class="row" style="padding-left: 2em;">
                    <div class="col-8">
                        <ul class="list-unstyled text-left" style="font-weight: 500;">
                            <li>Uji Kompetensi Perangkat Desa</li>
                        </ul>
                    </div>
                    <div class="col-1">
                        <ul class="list-unstyled text-left">
                            <li>:</li>
                        </ul>
                    </div>
                    <div class="col-2">
                        <ul class="list-unstyled text-right">
                            <li>{{ $hasil->nilai ?? 0 }}</li>
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
                            <li>{{ $hasil->nilai ?? 0 }}</li>
                        </ul>
                    </div>
                </div>
                <div class="row justify-content-center mt-4">
                    <form method="POST" action="{{ route('logout-skb') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger mr-2">Logout</button>
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

@push('modal')
    <script>
        $('.modal-backdrop').remove();
    </script>
@endpush
