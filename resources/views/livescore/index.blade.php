@extends('layouts.app-live')

@section('content')
    <div class="row">
        <div class="col">
            <h5 class="text-center">Livescore TKD (Tes Kemampuan Dasar) Uji Kompetensi Perangkat Desa Kabupaten Sidoarjo</h5>
            <div class="contain">
                <table class="table table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="2%"><center>No.</center></th>
                            <th><center>Nama / Jabatan Dilamar</center></th>
                            {{-- <th width="15%"><center>NIK</center></th> --}}
                            {{-- <th width="25%"><center>NIPTT-PK</center></th> --}}
                            <th><center>TWK</th>
                            <th><center>TIU</th>
                            <th><center>TKP</center></th>
                            <th><center>Total Nilai</center></th>
                            <th width="4%"><center>Status</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($live as $key => $ujian)
                        <tr id="<?= ++$key ?>">
                            <td>{{ $key++ }}</td>
                            <td>{{ $ujian->peserta->nama }}</td>
                            {{-- <td>{{ $ujian->peserta->nik }}</td> --}}
                            {{-- <td>{{ $ujian->peserta->nip }}</td> --}}
                            <td>{{ $ujian->nilaitwk }}</td>
                            <td>{{ $ujian->nilaitiu }}</td>
                            <td>{{ $ujian->nilaitkp }}</td>
                            <td>{{ $ujian->nilai_total }}</td>
			    <td>{{ $ujian->status == 0 ? 'UJIAN' : 'SELESAI' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('autoscroll')
    <script src="{{ asset('assets/js/jquery-scroll.js') }}"></script>
    <script>
        // var div = $('.scroll');
        // setInterval(function(){
        //     var pos = div.scrollTop();
        //     div.scrollTop(pos + 2);
        // }, 200)
        jQuery.fn.extend({
	        pic_scroll:function () {
	            $(this).each(function() {
	                var _this = $(this);
	                var ul = _this.find("table");
	                var li = ul.find("tbody");
	                var w = li.size()*li.outerHeight();
	                li.clone().prependTo(ul);
	                var i = 1,l;
	                _this.hover(function(){i = 0},function(){i = 1});
	                function autoScroll() {
	                	l = _this.scrollTop();
	                	if (l >= w) {
	                		_this.scrollTop(0);
	                	} else {
	                		_this.scrollTop(l + i);
	                	}
	                }
                    var scrolling = setInterval(autoScroll, 50);
	            });
	        }
	    });

	$(function() {
            $(".contain").pic_scroll();
	    setTimeout(function(){
                location.reload();
            }, 30000);
        });
    </script>
@endpush
