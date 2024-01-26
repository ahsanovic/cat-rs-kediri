@extends('layouts.app')

@section('content')

    <div class="container p-3 mx-auto flex-column text-center" style="max-width: 42em; margin-top: 2rem">
 
    <img class="mb-4" src="{{ asset('logo.png') }}" alt="Logo-Jatim" width="113" height="158">

      <main role="main" class="inner cover">
        <h1 >Selamat Datang di CBT BKD</h1>
        <p class="lead">Computer Based Test Badan Kepegawaian Daerah Provinsi Jawa Timur ini dipergunakan sebagai Tes Kompetensi Dasar (TKD) secara online.</p><br>
        @if(Auth::guest())
        <p class="lead">
          <a href="{{ route('login-form') }}" class="btn btn-outline-primary mr-sm-1">Login</a>
        </p>
        @endif
      </main>

    
    </div>
@endsection