@extends('layouts.app-sim')

@section('content')
    <div>
        <div>
            <h4>History Nilai Simulasi - {{ Auth::guard('peserta-sim')->user()->nama }}</h4>
            <div class="row mt-3">
                <table class="table table-hover" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Nilai TWK</th>
                            <th class="text-center">Nilai TIU</th>
                            <th class="text-center">Nilai TKP</th>
                            <th class="text-center">Nilai Total</th>
                            <th class="text-center">Tanggal Simulasi</th>
                            <th class="text-center">Kunci Jawaban</th>
                        </tr>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($nilai as $row)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $row->nilaitwk }}</td>
                                <td class="text-center">{{ $row->nilaitiu }}</td>
                                <td class="text-center">{{ $row->nilaitkp }}</td>
                                <td class="text-center">{{ $row->nilai_total }}</td>
                                <td class="text-center">{{ $row->created_at->format('d M Y H:i') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('kunci', ['id' => 1, 'ujian' => $row->ujian_id]) }}" target="_blank" class="btn btn-sm btn-success">Lihat</a>
                                </td>
                            </tr>
                        @endforeach
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection