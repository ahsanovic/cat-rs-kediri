@extends('layouts.app-tes')

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
                            <li>{{ $hasil->nilaitwk ?? 0 }}</li>
                            <li>{{ $hasil->nilaitiu ?? 0 }}</li>
                            <li>{{ $hasil->nilaitkp ?? 0 }}</li>
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
                            <li>{{ $hasil->nilai_total ?? 0 }}</li>
                        </ul>
                    </div>
                </div>
                <div class="row justify-content-center mt-4">
                    <form method="POST" action="{{ route('ujian.logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger mr-2">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modal')
    <script>
        $('.modal-backdrop').remove();
    </script>
@endpush
