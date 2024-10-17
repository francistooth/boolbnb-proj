@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Registrati') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-4 row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}
                                    <strong class="text-danger">*</strong></label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}
                                    <strong class="text-danger">*</strong>
                                </label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password') }} <strong
                                        class="text-danger">*</strong></label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>


                            <div class="mb-4 row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="surname"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Cognome') }}</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text"
                                        class="form-control @error('surname') is-invalid @enderror" name="surname"
                                        value="{{ old('surname') }}" autocomplete="surname" autofocus>

                                    @error('surname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Data di Nascita') }}</label>


                                <div class="col-md-6">
                                    <input type="date" id="date_birth" name="date_birth" value="2018-07-22"
                                        min="1935-01-01" max="2006-12-31" class="form-control" />
                                </div>

                            </div>

                            <div class="mb-4 row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <div class="password-error-messages text-danger"></div>
                                </div>
                            </div>

                            <div class="mb-4 row mb-0 justify-content-center">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Registrati') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <script>
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
                        errorMessages.push('Le password devono combaciare');
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

            // JavaScript per selezione data nascita
            window.onload = function() {
                const daySelect = document.getElementById('day');
                const monthSelect = document.getElementById('month');
                const yearSelect = document.getElementById('year');

                // popola gli anni (dall'anno corrente -17 anni fino a 100 anni fa)
                const currentYear = new Date().getFullYear() - 17;
                for (let i = currentYear; i >= currentYear - 100; i--) {
                    let option = document.createElement('option');
                    option.value = i;
                    option.text = i;
                    yearSelect.appendChild(option);
                }

                // popola i giorni in base al mese e all'anno
                function populateDays(month, year) {
                    // cancella i giorni attualmente esistenti
                    daySelect.innerHTML = '<option value="" disabled selected>Giorno</option>';

                    let daysInMonth;
                    switch (month) {
                        case 2: // febbraio
                            // controlla se l'anno è bisestile
                            daysInMonth = year % 4 === 0 ? 29 : 28;
                            break;
                        case 4, 6, 9, 11: // aprile, giugno, settembre, novembre
                            daysInMonth = 30;
                            break;
                        default: // altri mesi
                            daysInMonth = 31;
                            break;
                    }

                    // popola la selezione dei giorni
                    for (let i = 1; i <= daysInMonth; i++) {
                        let option = document.createElement('option');
                        option.value = i;
                        option.text = i;
                        daySelect.appendChild(option);
                    }
                }

                // quando il mese cambia, aggiorna i giorni
                monthSelect.addEventListener('change', function() {
                    const selectedMonth = parseInt(monthSelect.value);
                    const selectedYear = parseInt(yearSelect.value) ||
                        currentYear; // Se l'anno non è selezionato, usa l'anno corrente
                    populateDays(selectedMonth, selectedYear);
                });

                // quando l'anno cambia, aggiorna i giorni (per verificare gli anni bisestili)
                yearSelect.addEventListener('change', function() {
                    const selectedMonth = parseInt(monthSelect.value) ||
                        1; // se il mese non è selezionato, usa gennaio
                    const selectedYear = parseInt(yearSelect.value);
                    populateDays(selectedMonth, selectedYear);
                });
            };
        </script>
    </div>
@endsection
