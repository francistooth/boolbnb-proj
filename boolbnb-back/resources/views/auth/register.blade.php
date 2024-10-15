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
                                    <strong class="text-danger">*</strong></label>

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
                                        <!-- Day Select -->
                                        <div class="col">
                                            <select id="year" class="form-select">
                                                <option value="" disabled selected>Anno</option>
                                                <!-- JavaScript popolerà gli anni -->
                                            </select>
                                        </div>

                                        <!-- Month Select -->
                                        <div class="col">
                                            <select id="month" class="form-select">
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
                                        </div>

                                        <!-- Year Select -->
                                        <div class="col">
                                            <select id="day" class="form-select">
                                                <option value="" disabled selected>Giorno</option>
                                                <!-- JavaScript popolerà i giorni -->
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 row mb-0">
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

        <!-- Bootstrap JS and Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <!-- JavaScript to populate day and year -->
        <script>
            window.onload = function() {
                const daySelect = document.getElementById('day');
                const monthSelect = document.getElementById('month');
                const yearSelect = document.getElementById('year');

                // Popolare gli anni (dall'anno corrente fino a 100 anni fa)
                const currentYear = new Date().getFullYear() - 17;
                for (let i = currentYear; i >= currentYear - 100; i--) {
                    let option = document.createElement('option');
                    option.value = i;
                    option.text = i;
                    yearSelect.appendChild(option);
                }

                // Funzione per popolare i giorni in base al mese e all'anno
                function populateDays(month, year) {
                    // Cancella i giorni attualmente esistenti
                    daySelect.innerHTML = '<option value="" disabled selected>Giorno</option>';

                    let daysInMonth;
                    switch (month) {
                        case 2: // Febbraio
                            // Controlla se l'anno è bisestile
                            daysInMonth = (year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0)) ? 29 : 28;
                            break;
                        case 4:
                        case 6:
                        case 9:
                        case 11: // Aprile, Giugno, Settembre, Novembre
                            daysInMonth = 30;
                            break;
                        default: // Altri mesi
                            daysInMonth = 31;
                            break;
                    }

                    // Popola la selezione dei giorni
                    for (let i = 1; i <= daysInMonth; i++) {
                        let option = document.createElement('option');
                        option.value = i;
                        option.text = i;
                        daySelect.appendChild(option);
                    }
                }

                // Quando il mese cambia, aggiorna i giorni
                monthSelect.addEventListener('change', function() {
                    const selectedMonth = parseInt(monthSelect.value);
                    const selectedYear = parseInt(yearSelect.value) ||
                        currentYear; // Se l'anno non è selezionato, usa l'anno corrente
                    populateDays(selectedMonth, selectedYear);
                });

                // Quando l'anno cambia, aggiorna i giorni (per verificare gli anni bisestili)
                yearSelect.addEventListener('change', function() {
                    const selectedMonth = parseInt(monthSelect.value) ||
                        1; // Se il mese non è selezionato, usa gennaio
                    const selectedYear = parseInt(yearSelect.value);
                    populateDays(selectedMonth, selectedYear);
                });
            };
        </script>
    </div>
@endsection
