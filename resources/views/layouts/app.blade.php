<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Boolbnb Log-in</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@300;400;700;900&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg_grey shadow-sm">
            
            <div class="container-fluid">
                <div>
                    <a class="navbar-brand p-1 text-dark" href="{{ url('/') }}">Boolbnb</a>
                    <!-- /logo -->
                </div>
                
                <div>
                    @auth
                        <h4 class="navbar-brand mb-0 text-dark">Bentornato {{ Auth::user()->name ?? '' }}</h4>
                    @endauth 
                </div>
                
                <div>
                    <!-- /name user -->
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <!-- /btn to drowdown -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('login') }}">Accedi</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="{{ route('register') }}">Registrati</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="black" class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path fill-rule="evenodd"
                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                </svg>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item text-dark" href="{{ route('admin.home') }}">Admin</a></li>
                                <li><a class="dropdown-item text-dark" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Esci</a>
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
                
            </div>
        </nav>
        <!-- /navbar -->

        <div class="row no-gutter full_screen" id="edit_query">
            <div class="col-12 col-sm-12 col-lg-3 bg_secondary p-4 ">
                <h5 class="text-light">Esplora tutte le funzionalità</h5>
                <aside class="w-100">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active text-light px-2" aria-current="page" href="{{ route('admin.apartment.index') }}">
                                <span data-feather="home" class="align-text-bottom text-light"></span>
                                &bullet; Appartamenti
                            </a>
                        </li>
                        <!-- /Apartments -->
                    </ul>
                </aside>
            </div>
            <!-- /.col sx-->
            <div class="col bg_primary p-5 full_screen">
                <main>
                    @yield('content')
                </main>
            </div>
            <!-- /.col dx-->
        </div>
    </div>
</body>

</html>
