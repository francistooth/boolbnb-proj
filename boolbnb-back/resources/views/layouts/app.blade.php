<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BoolBnB</title>


    <link rel="icon" type="image/x-icon" href="../img/favicon.png">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])

    {{-- font awesome cdn --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
</head>

<body>
    <div id="app">
        {{--  <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="http://localhost:5174">
                    <img style="width: 50px" src="../img/favicon.png" alt="logo-boolbnb">
                    {{-- config('app.name', 'Laravel')
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">  --}}
        <!-- Left Side Of Navbar -->
        {{--   <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost:5174">{{ __('Home') }}</a>
                </li>
            </ul> --}}

        <!-- Right Side Of Navbar -->
        {{-- <ul class="navbar-nav ml-auto"> --}}
        <!-- Authentication Links -->
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Accedi') }}</a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registrati') }}</a>
                </li>
            @endif
        @else
            {{-- < li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"> --}} {{-- <a class="dropdown-item" href="{{ route('admin.home') }}">{{ __('Dashboard') }}</a> --}} {{-- <a class="dropdown-item" href="{{ route('admin.apartments.index') }}">I miei
                                appartamenti</a>
                            <a class="dropdown-item" href="{{ route('admin.user.show', Auth::id()) }}">Il mio
                                account</a> --}} {{-- <a class="dropdown-item" href="{{ route('admin.apartments.trash', Auth::id()) }}">il
                                        mio cestino degli appartamenti</a> --}} {{--  <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li> --}}
        @endguest {{--      </ul>
        </div>
    </div>
    </nav>   --}} <main>
            @yield('content')
        </main>
    </div>
</body>

</html>
