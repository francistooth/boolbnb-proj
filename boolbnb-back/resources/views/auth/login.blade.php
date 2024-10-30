@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center text-light" style="background-color: #144172">{{ __('Accedi') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-4 row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right text-center">{{ __('Indirizzo E-Mail') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right text-center">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <div class="form-check d-flex justify-content-center gap-1">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label me-5" for="remember">
                                        {{ __('Ricordami') }}
                                    </label>

                                    <input class="form-check-input" type="checkbox" name="pwd" id="pwd"
                                        onclick="togglePwd()">

                                    <label class="form-check-label" for="pwd">Mostra la password</label>
                                </div>
                            </div>

                            <div class="mb-4 row mb-0 text-center">
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Accedi') }}
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4 row mb-0">
                                <a class="btn btn-link" href="{{ route('register') }}">
                                    {{ __('Non hai un account? Registrati') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePwd() {
            const pwd = document.getElementById("password");
            if (pwd.type === "password") {
                pwd.type = "text";
            } else {
                pwd.type = "password";
            }
        }

        document.getElementById('email').addEventListener('input', function() {
            const emailInput = this;
            const emailValue = emailInput.value;
            const emailPattern = /^[a-z0-9._-]+@[a-z0-9.-]+\.[a-z]{2,}$/;

            if (emailPattern.test(emailValue)) {
                emailInput.classList.remove('is-invalid');
            } else {
                emailInput.classList.add('is-invalid');
            }
        });
    </script>
@endsection
