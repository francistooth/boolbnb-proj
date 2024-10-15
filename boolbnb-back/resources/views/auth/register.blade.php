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

                            <div class="mb-4 row align-items-center">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Data di Nascita') }}</label>


                                <div class="col-md-6">
                                    <div class="row g-2">
                                        <!-- select giorni -->
                                        <div class="col">
                                            <select name="year" id="year"
                                                class="form-select @error('year') is-invalid @enderror">
                                                <option value="" disabled selected>Anno</option>
                                            </select>

                                            @error('year')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <!-- select mesi -->
                                        <div class="col">
                                            <select name="month" id="month"
                                                class="form-select @error('month') is-invalid @enderror">
                                                <option value="" disabled selected>Mese</option>
                                                <option value="1">Gennaio</option>
                                                <option value="2">Febbraio</option>
                                                <option value="3">Marzo</option>
                                                <option value="4">Aprile</option>
                                                <option value="5">Maggio</option>
                                                <option value="6">Giugno</option>
                                                <option value="7">Luglio</option>
                                                <option value="8">Agosto</option>
                                                <option value="9">Settembre</option>
                                                <option value="10">Ottobre</option>
                                                <option value="11">Novembre</option>
                                                <option value="12">Dicembre</option>
                                            </select>

                                            @error('month')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <!-- select anni -->
                                        <div class="col">
                                            <select name="day" id="day"
                                                class="form-select @error('day') is-invalid @enderror">
                                                <option value="" disabled selected>Giorno</option>
                                            </select>

                                            @error('day')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
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
                const emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;

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
                            daysInMonth = (year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0)) ? 29 : 28;
                            break;
                        case 4:
                        case 6:
                        case 9:
                        case 11: // aprile, giugno, settembre, novembre
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
