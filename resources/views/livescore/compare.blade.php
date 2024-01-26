@extends('layouts.app-compare')

@section('content')
    <div class="row">
        <div class="col">
            <h5 class="text-center">Compare</h5>
            <div class="contain">
                <table class="table table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="2%"><center>No.</center></th>
                            <th><center>Kunci</th>
                            <th><center>Jawaban</th>
                            <th><center>Benar/Salah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                            $no = 1;
                        @endphp
                        @foreach ($kunci as $key => $ujian)
                        <tr id="<?= ++$key ?>">
                            <td>{{ $no++ }}</td>
                            <td>
                                @php
                                    echo $ujian;
                                @endphp
                            </td>
                            <td>
                                @php
                                    echo $jawaban[$i];
                                @endphp
                            </td>
                            <td>
                                @php
                                    if ($ujian == $jawaban[$i]) {
                                        echo 'Benar';
                                    } else {
                                        echo 'Salah';
                                    }
                                    $i++;
                                @endphp
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
