@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row flex-nowrap">

            <!-- Barra laterale con comportamento responsive -->
            <nav class="col-1 col-lg-2 aside vh-100" id="sidebarMenu">
                <div class="row flex-column align-items-sm-start px-lg-3 pt-2 text-white sidenav">
                    <span class="fs-5 py-4 px-1 d-none d-lg-inline">
                        {{ Auth::user()->name }} {{ Auth::user()->surname }}
                    </span>

                    <span class="fs-5 py-4 px-0 d-lg-none">
                        {{ substr(Auth::user()->name, 0, 1) }}{{ substr(Auth::user()->surname, 0, 1) }}
                    </span>

                    <ul class="nav flex-column mb-auto pe-0" id="menu">
                        <li class="nav-item">
                            <a href="http://localhost:5174" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i>
                                <span class="ms-1 d-none d-lg-inline">{{ __('Vai al sito') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.apartments.index') }}" class="nav-link align-middle px-0">
                                <i class="p-1 fs-5 fa-solid fa-table-list"></i>
                                <span class="ms-1 d-none d-lg-inline">{{ __('Appartamenti') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.message.index', Auth::id()) }}" class="nav-link align-middle px-0">
                                <i class="p-1 fs-5 fa-regular fa-envelope"></i>
                                <span class="ms-1 d-none d-lg-inline">{{ __('Messaggi') }}</span>
                            </a>
                        </li>
                    </ul>

                    <a href="http://localhost:5173" class="nav-link align-middle px-0 py-3"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fs-5 fa-solid fa-arrow-right-from-bracket"></i>
                        <span class="ms-1 d-none d-lg-inline">{{ __('Logout') }}</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </nav>

            <!-- Contenuto principale -->
            <div class="col-11 col-lg-10 py-3 vh-100 overflow-y-auto">
                @yield('user')
            </div>
        </div>
    </div>
@endsection
