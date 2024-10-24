@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 aside">
                <div
                    class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100 sidenav">
                    {{-- User Name --}}

                    <span class="fs-5 py-4 d-none d-sm-inline">
                        {{ Auth::user()->name }} {{ Auth::user()->surname }}
                    </span>

                    {{-- Action list: Home, Appartments, Messages --}}

                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">

                        {{-- home button --}}

                        <li class="nav-item">
                            <a href="http://localhost:5174" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house">
                                </i>
                                <span class="ms-1 d-none d-sm-inline">
                                    {{ __('Vai al sito') }}
                                </span>
                            </a>
                        </li>

                        {{-- appartments button --}}

                        <li class="nav-item">
                            <a href="{{ route('admin.apartments.index') }}" class="nav-link align-middle px-0">
                                <i class="p-1 fs-5 fa-solid fa-table-list"></i> <span
                                    class="ms-1 d-none d-sm-inline">{{ __('Appartamenti') }}</span>
                            </a>
                        </li>

                        {{-- messages button --}}

                        <li class="nav-item">
                            <a href="{{ route('admin.message.index', Auth::id()) }}" class="nav-link align-middle px-0">
                                <i class="p-1 fs-5 fa-regular fa-envelope"></i> <span
                                    class="ms-1 d-none d-sm-inline">{{ __('Messaggi') }}</span>
                            </a>
                        </li>
                    </ul>


                    <a href="http://localhost:5174" class="nav-link align-middle px-0 py-3"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fs-5 p-1 fa-solid fa-arrow-right-from-bracket">

                        </i>
                        <span class="ms-1 d-none d-sm-inline">
                            {{ __('Logout') }}
                        </span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
            <div class="col py-3">
                @yield('user')
            </div>
        </div>
    </div>
@endsection
