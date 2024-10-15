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
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                        value="{{ old('surname') }}" required autocomplete="surname" autofocus>

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
                                            <label for="day" class="form-label">Giorno</label>
                                            <select name="day" id="day" class="form-select">
                                                <option value="" disabled selected>Giorno</option>
                                                <!-- JavaScript will populate days -->
                                            </select>
                                        </div>

                                        <!-- Month Select -->
                                        <div class="col">
                                            <label for="month" class="form-label">Mese</label>
                                            <select name="month" id="month" class="form-select">
                                                <option value="" disabled selected>Mese</option>
                                                <option value="01">Gennaio</option>
                                                <option value="02">Febbraio</option>
                                                <option value="03">Marzo</option>
                                                <option value="04">Aprile</option>
                                                <option value="05">Maggio</option>
                                                <option value="06">Giugno</option>
                                                <option value="07">Luglio</option>
                                                <option value="08">Agosto</option>
                                                <option value="09">Settembre</option>
                                                <option value="10">Ottobre</option>
                                                <option value="11">Novembre</option>
                                                <option value="12">Dicembre</option>
                                            </select>
                                        </div>

                                        <!-- Year Select -->
                                        <div class="col">
                                            <label for="year" class="form-label">Anno</label>
                                            <select name="year" id="year" class="form-select">
                                                <option value="" disabled selected>Anno</option>
                                                <!-- JavaScript will populate years -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

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
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

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
                                    class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
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
                //select month
                const monthSelect = document.getElementById('month');
                // Populate days (1-31)
                const daySelect = document.getElementById('day');

                for (let i = 1; i <= 31; i++) {
                    let option = document.createElement('option');
                    option.value = i;
                    option.text = i;
                    daySelect.appendChild(option);
                }

                // Populate years (from current year to 100 years ago)
                const yearSelect = document.getElementById('year');
                const currentYear = new Date().getFullYear() - 17;
                for (let i = currentYear; i >= currentYear - 100; i--) {
                    let option = document.createElement('option');
                    option.value = i;
                    option.text = i;
                    yearSelect.appendChild(option);
                }
            };
        </script>

    </div>
@endsection
