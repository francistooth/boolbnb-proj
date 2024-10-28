@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row flex-nowrap">

            <!-- Barra laterale con comportamento responsive -->
            <nav class="col-1 col-lg-2 px-sm-2 px-0 aside collapse show vh-100" id="sidebarMenu">
                <div class="row flex-column justify-content-center align-items-sm-start px-3 pt-2 text-white sidenav">
                    <span class="fs-5 py-4 d-none d-lg-inline">
                        {{ Auth::user()->name }} {{ Auth::user()->surname }}
                    </span>

                    <ul class="nav nav-pills flex-column mb-auto mb-0 align-items-center align-items-sm-start" id="menu">
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
                        <i class="fs-5 p-1 fa-solid fa-arrow-right-from-bracket"></i>
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
