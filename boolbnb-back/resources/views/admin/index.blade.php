@extends('layouts.app')
{{-- da spedire al front  --}}
@section('content')
<nav-bar :is-guest="{{ json_encode(auth()->guest()) }}"></nav-bar>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="/"
                        class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">
                        <li class="nav-item">
                            <a href="http://localhost:5174" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span
                                    class="ms-1 d-none d-sm-inline">{{ __('Home') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.user.show', Auth::id()) }}" class="nav-link align-middle px-0">
                                <i class="p-1 fs-5 fa-regular fa-user"></i><span
                                    class="ms-1 d-none d-sm-inline">{{ __('User') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.apartments.index') }}" class="nav-link align-middle px-0">
                                <i class="p-1 fs-5 fa-solid fa-table-list"></i> <span
                                    class="ms-1 d-none d-sm-inline">{{ __('Appartamenti') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.message.index', Auth::id()) }}" class="nav-link align-middle px-0">
                                <i class="p-1 fs-5 fa-regular fa-envelope"></i> <span
                                    class="ms-1 d-none d-sm-inline">{{ __('Messaggi') }}</span>
                            </a>
                        </li>
                    </ul>


                    <a href="{{ route('logout') }}" class="nav-link align-middle px-0"
                        onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                        <i class="fs-5 p-1 fa-solid fa-arrow-right-from-bracket"></i><span
                            class="ms-1 d-none d-sm-inline">{{ __('Logout') }}</span>
                    </a>
                </div>
            </div>
            <div class="col py-3 background">
                @yield('user')
            </div>
        </div>
    </div>
@endsection
