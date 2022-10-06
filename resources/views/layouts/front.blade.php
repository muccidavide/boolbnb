<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Titolo pagina -->
    <title>Boolbnb</title>

    <!-- Scripts JS -->
    <script src="{{ asset('js/front.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@300;400;700;900&display=swap"
        rel="stylesheet">

    <!-- Link CSS -->
    <link href="{{ asset('css/front.css') }}" rel="stylesheet">

</head>

<body>

    <header id="site_header_front">
        <nav class="navbar navbar-expand-sm navbar-light bg-light">
            <div class="container">
                <a href="{{ route('front.home') }}">
                    <img style="width:100px" src="{{ asset('img/logo.png') }}" alt="">
                </a>
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav me-auto w-100 justify-content-between">
                        <li class="left">
                            <ul class="d-flex flex-column flex-sm-row" id="costum-a">
                                <li class="nav-item active" >
                                    <a  class="nav-link" href="{{ route('front.home') }}">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/search') }}">Ricerca avanzata</a>
                                </li>
                            </ul>
                        </li>
                        <li class="right">
                            <ul>
                                @guest
                                    <ul class="d-flex flex-column flex-sm-row">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('login') }}">Accedi</a>
                                        </li>
                                        @if (Route::has('register'))
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('register') }}">Registrati</a>
                                            </li>
                                        @endif
                                    </ul>
                                @else
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="dropdownId"
                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">{{ Auth::user()->name ?? '' }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                                <path fill-rule="evenodd"
                                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                            </svg>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownId">
                                            <li><a class="dropdown-item" href="{{ route('admin.home') }}">Admin</a></li>
                                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Esci</a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                </form>

                                        </ul>
                                    </li>
                                @endguest
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        {{-- <nav class="navbar navbar-expand-md shadow">
            <div class="container">
                <div class="row w_100 align-items-center">
                    <div class="col">
                        <a href="{{ url('/') }}">
                            <img style="width:100px" src="{{asset('img/logo.png')}}" alt="">
                        </a>
                    </div>
                    <!-- /.col sx -->
                    <div class="col d-flex justify-content-center">
                        <a href="{{ url('/search') }}">
                            Ricerca avanzata
                        </a>
                    </div>
                    <!-- /.col central-->
                    <div class="col d-flex justify-content-end">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <!-- /btn to drowdown -->
                        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto">
                                @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Accedi</a>
                                </li>
                                @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Registrati</a>
                                </li>
                                @endif
                                @else
                                <li class="nav-item dropdown d-flex align-items-center">
                                    <h4 class="navbar-brand mb-0">Bentornato {{ Auth::user()->name ?? '' }}</h4>
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                        </svg>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="{{ route('admin.home') }}">Admin</a></li>
                                        <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Esci</a>
                                        </li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </ul>
                                </li>
                                @endguest
                            </ul>
                        </div>
                        <!-- /authentication Links -->
                    </div>
                    <!-- /.col dx -->
                </div>
            </div>
        </nav> --}}

        <!-- /Nav UP -->
    </header>
    <!-- /#site_header_front -->

    <main id="site_main_front">

        @yield('content')

    </main>
    <!-- /#site_main_front -->
    @if (auth()->check())
        <script>
            window.User = {!! auth()->user() !!}
        </script>
    @endif
</body>

</html>
