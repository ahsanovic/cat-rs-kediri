@extends('layouts.app')

@section('content')
<h4>Tampilan Soal</h4>
<div class="card bg-light border-primary mt-2">
    <div class="card-body">
        <div class="row">
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
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="opsi" id="opsi1">
                    <label class="form-check-label" for="opsi1">
                        @if (preg_match("/<img/i", $soal->opsi1))
                            A. {!!$soal->opsi1!!}
                        @else 
                            A. {{ strip_tags(html_entity_decode($soal->opsi1)) }}
                        @endif
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="opsi" id="opsi2">
                    <label class="form-check-label" for="opsi2">
                        @if (preg_match("/<img/i", $soal->opsi2))
                            B. {!!$soal->opsi2!!}
                        @else 
                            B. {{ strip_tags(html_entity_decode($soal->opsi2)) }}
                        @endif
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="opsi" id="opsi3">
                    <label class="form-check-label" for="opsi3">
                        @if (preg_match("/<img/i", $soal->opsi3))
                            C. {!!$soal->opsi3!!}
                        @else 
                            C. {{ strip_tags(html_entity_decode($soal->opsi3)) }}
                        @endif
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="opsi" id="opsi4">
                    <label class="form-check-label" for="opsi4">
                        @if (preg_match("/<img/i", $soal->opsi4))
                            D. {!!$soal->opsi4!!}
                        @else 
                            D. {{ strip_tags(html_entity_decode($soal->opsi4)) }}
                        @endif
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="opsi" id="opsi5">
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
    </div>
</div>
@endsection
