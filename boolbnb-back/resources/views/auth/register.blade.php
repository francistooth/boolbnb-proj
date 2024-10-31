@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center text-light" style="background-color: #144172">
                        {{ __('Registrazione') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-4 row text-center">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}
                                    <strong class="text-danger">*</strong></label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row text-center">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}
                                    <strong class="text-danger">*</strong>
                                </label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password" data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        data-bs-title="La password deve contenere almeno 8 caratteri con una lettera minuscola, una lettera maiuscola, un numero e un carattere speciale."
                                        data-bs-custom-class="custom-tooltip">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row text-center">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password') }} <strong
                                        class="text-danger">*</strong></label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>


                                <div class="mt-2 row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="password-error-messages text-danger"></div>
                                    </div>
                                </div>
                            </div>


                            <div class="mb-4 row text-center">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row text-center">
                                <label for="surname"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Cognome') }}</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text"
                                        class="form-control @error('surname') is-invalid @enderror" name="surname"
                                        value="{{ old('surname') }}" autocomplete="surname" autofocus>

                                    @error('surname')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row text-center">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Data di Nascita') }}</label>


                                <div class="col-md-6">
                                    <input type="date" id="date_birth" name="date_birth" value="" min="1935-01-01"
                                        max="2006-12-31" class="form-control" />
                                </div>

                            </div>


                            <div class="mb-4 row mb-0 justify-content-center">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Registrati') }}
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4 row mb-0">
                                <a class="btn btn-link" href="{{ route('login') }}">
                                    {{ __('Hai gia un account? Effettua il login') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))


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

            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('form');
                const passwordInput = document.getElementById('password');
                const passwordConfirmInput = document.getElementById('password-confirm');

                form.addEventListener('submit', function(event) {
                    let errorMessages = [];

                    if (passwordInput.value.startsWith(' ')) {
                        errorMessages.push('La password non può iniziare con uno spazio');
                    }

                    if (passwordInput.value !== passwordConfirmInput.value) {
                        errorMessages.push('Le password non corrispondono');
                    }

                    if (errorMessages.length > 0) {
                        event.preventDefault();

                        const errorContainer = document.querySelector('.password-error-messages');
                        if (!errorContainer) {
                            const errorDiv = document.createElement('div');
                            errorDiv.classList.add('password-error-messages', 'text-danger', 'mt-2');
                            form.querySelector('.mb-4.row.mb-0').prepend(errorDiv);
                        }

                        document.querySelector('.password-error-messages').innerHTML = errorMessages.join(
                            '<br>');
                    }
                });
            });
        </script>
    </div>
@endsection
