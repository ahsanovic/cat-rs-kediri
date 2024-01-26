<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    {{-- <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Datatables -->
    {{-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}

    <!-- Fontawesome -->
    <link href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Sweetalert2 -->
    {{-- <link href="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"> --}}

    <!-- Select2 -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @livewireStyles

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="#">
                    {{ config('app.name') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                        @else
                            <li class="nav-item {{ (Request::is('admin') ? 'active' : '') }}">
                                <a class="nav-link" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item {{ (Request::is('admin/setting-ujian') ? 'active' : '') }}">
                                <a class="nav-link" href="{{ route('setting-ujian') }}"><i class="icon-gear"></i> Setting Ujian SKB</a>
                            </li>
                            <li class="nav-item dropdown 
                                {{ (Request::is('admin/bidang') or 
                                    Request::is('admin/subbidang') or 
                                    Request::is('admin/jenis-soal') or 
                                    Request::is('admin/rumpun') or
                                    Request::is('admin/jabatan')
                                    ) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-hdd"></i> Data Master</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('jenis-soal') }}">SKD</a>
                                    <a class="dropdown-item" href="{{ route('rumpun') }}">SKB</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown 
                                {{ (Request::is('admin/user') or 
                                    Request::is('admin/peserta') or 
                                    Request::is('admin/peserta-sim') or
                                    Request::is('admin/peserta-skb')
                                    ) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"><i class="icon-group"></i> Peserta/User</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('peserta-sim') }}">Peserta Simulasi SKD</a>
                                    <a class="dropdown-item" href="{{ route('peserta') }}">Peserta SKD</a>
                                    <a class="dropdown-item" href="{{ route('peserta-skb') }}">Peserta SKB</a>
                                    <a class="dropdown-item" href="{{ route('user') }}">User</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown {{ (Request::is('admin/soal-sim') or Request::is('admin/soal') or Request::is('admin/soal-skb')) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"><i class="icon-file"></i> Soal</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('soal-sim') }}">Soal Simulasi SKD</a>
                                    <a class="dropdown-item" href="{{ route('soal') }}">Soal SKD</a>
                                    <a class="dropdown-item" href="{{ route('soal-skb') }}">Soal SKB</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown {{ (Request::is('admin/live-sim') or Request::is('admin/live') or Request::is('admin/live-skb')) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"><i class="fa fa-list-ol"></i> Livescore</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('live-sim') }}">Livescore Simulasi SKD</a>
                                    <a class="dropdown-item" href="{{ route('live') }}">Livescore SKD</a>
                                    <a class="dropdown-item" href="{{ route('live-skb') }}">Livescore SKB</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown {{ (Request::is('admin/hasil-sim') or Request::is('admin/hasil') or Request::is('admin/hasil-skb')) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"><i class="fa fa-graduation-cap"></i> Hasil Tes</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('hasil-sim') }}">Hasil Tes Simulasi SKD</a>
                                    <a class="dropdown-item" href="{{ route('hasil') }}">Hasil Tes SKD</a>
                                    <a class="dropdown-item" href="{{ route('hasil-skb') }}">Hasil Tes SKB</a>
                                </div>
                            </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Hi, {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out-alt"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
        
        <footer class="fixed-bottom">
            <div class="text-right">
                <small>Copyright &copy; <?= date('Y') ?> <a href="http://bkd.jatimprov.go.id" class="text-dark" target="_blank">BKD Jatim</a></small>
            </div>
        </footer>
    </div>
    
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <!-- Datatables -->
    {{-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}

    <!-- Select2 -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> --}}
    <!-- Sweetalert2 -->
    {{-- <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script> --}}

    <script>
        $('[data-toggle="tooltip"]').tooltip()
        // $('.select2').select2();
    </script>
    @stack('ckeditor')
    @stack('scroll')
    {{-- @stack('datatable') --}}
    @stack('script')
    @stack('autoscroll')
    @livewireScripts

</body>
</html>
