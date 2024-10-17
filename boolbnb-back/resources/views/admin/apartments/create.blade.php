@extends('layouts.app')

@section('content')
    <div class="container">

        <h2> Inserisci appartamento</h2>
        <h6> Proprietario: {{ Auth::user()->name }} {{ Auth::user()->surname }} </h6>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mt-4">

            <form id="apartmentForm" class="d-flex flex-column gap-4" method="POST"
                action="{{ route('admin.apartments.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title">Titolo: <strong class="text-danger">*</strong></label>
                    <input value="{{ old('title') }}" type="text" id="title" name="title"
                        class="form-control @error('title') is-invalid @enderror" required>

                    @error('title')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Descrizione: <strong class="text-danger">*</strong></label>
                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>

                    @error('description')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="room">Numero stanze: <strong class="text-danger">*</strong></label>
                    <input value="{{ old('room') }}" type="number" id="room" name="room"
                        class="form-control @error('room') is-invalid @enderror" required
                        onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">

                    @error('room')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bathroom">Numero di bagni: <strong class="text-danger">*</strong></label>
                    <input value="{{ old('bathroom') }}" type="number" id="bathroom" name="bathroom"
                        class="form-control @error('bathroom') is-invalid @enderror" required
                        onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">

                    @error('bathroom')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bed">Numero di letti: <strong class="text-danger">*</strong></label>
                    <input value="{{ old('bed') }}" type="number" id="bed" name="bed"
                        class="form-control @error('bed') is-invalid @enderror" required
                        onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">

                    @error('bed')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sqm">Metri quadrati: <strong class="text-danger">*</strong></label>
                    <input value="{{ old('sqm') }}" type="number" id="sqm" name="sqm"
                        class="form-control @error('sqm') is-invalid @enderror" required min="0"
                        onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">

                    @error('sqm')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <!-- LABEL -->
                    <label for="address">
                        Indirizzo: <strong class="text-danger">*</strong>
                    </label>

                    <!-- USER INPUT -->
                    <input type="text" id="address" name="address"
                        class="form-control @error('address') is-invalid @enderror"
                        placeholder="Es: Via del Corso 73, 00186 Roma" required autocomplete="off">

                    <!-- RISULTATI API -->
                    <div id="address-suggestions" class="list-group"></div>

                    <!-- MESSAGGIO DI ERRORE -->
                    <small id="address-error" class="text-danger"></small>

                    @error('address')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="services" class="form-label d-block">Servizi disponibili: <strong
                            class="text-danger">*</strong></label>
                    <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                        @foreach ($services as $service)
                            <input value="{{ $service->id }}" name="services[]" type="checkbox" class="btn-check"
                                id="service-{{ $service->id }}" autocomplete="off"
                                @if (in_array($service->id, old('services', []))) checked @endif>

                            <label class="btn btn-outline-primary"
                                for="service-{{ $service->id }}">{{ $service->name }}</label>
                        @endforeach
                    </div>

                    @error('services')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="img_path">Immagine:</label>
                    <input type="file" id="img_path" name="img_path" class="form-control mb-4"
                        onchange="Preview(event)">
                    <img value='{{ old('img_path') }}' src="\img\default-image.jpg" id="thumb"
                        class="img-thumbnail w-25 mt-2">
                    @error('img_path')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="form-check form-switch">
                        <input type="hidden" name="is_visible" value="0">
                        <input name="is_visible" class="form-check-input" type="checkbox" role="switch" value="1"
                            id="is_visible" checked>
                        <label class="form-check-label" for="is_visible">Appartamento visibile al pubblico</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Crea Appartamento</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addressInput = document.getElementById('address');
            const suggestionsBox = document.getElementById('address-suggestions');
            const apartmentForm = document.getElementById('apartmentForm');
            const errorMessage = document.getElementById('address-error'); // Elemento per l'errore
            const apiKey = 'PmDZl7vx3YsaUvAjiu8WRKIDvd4SGoNG';
            let suggestionsArray = []; // Array per memorizzare i risultati dell'API

            // Funzione per fare la chiamata all'API TomTom
            function apiCall(query) {
                const apiUrl =
                    `https://api.tomtom.com/search/2/geocode/${encodeURIComponent(query)}.json?key=${apiKey}`;

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        suggestionsArray = data.results.map(result => result.address
                            .freeformAddress); // Salva i risultati nel array
                        showSuggestions(data.results);
                    })
                    .catch(error => {
                        console.error('Errore nella chiamata API TomTom:', error);
                    });
            }

            // Funzione per mostrare i suggerimenti nella tendina
            function showSuggestions(results) {
                suggestionsBox.innerHTML = ''; // Pulire i vecchi suggerimenti
                if (results && results.length > 0) {
                    results.forEach(result => {
                        const suggestionItem = document.createElement('a');
                        suggestionItem.classList.add('list-group-item', 'list-group-item-action');
                        suggestionItem.textContent = result.address.freeformAddress;

                        // Gestisci clic sull'indirizzo suggerito
                        suggestionItem.addEventListener('click', function() {
                            addressInput.value = result.address.freeformAddress;
                            suggestionsBox.innerHTML =
                                ''; // Nascondi i suggerimenti dopo aver selezionato
                            errorMessage.textContent =
                                ''; // Rimuovi l'errore se selezionato un indirizzo valido
                        });

                        suggestionsBox.appendChild(suggestionItem);
                    });
                } else {
                    const noResult = document.createElement('a');
                    noResult.classList.add('list-group-item', 'list-group-item-action');
                    noResult.textContent = 'Nessun risultato trovato';
                    suggestionsBox.appendChild(noResult);
                }
            }

            // Ascolta l'input dell'utente e attiva la ricerca
            addressInput.addEventListener('input', function() {
                const query = addressInput.value.trim();
                if (query.length > 2) { // Inizia a cercare dopo che l'utente ha digitato almeno 3 caratteri
                    apiCall(query);
                } else {
                    suggestionsBox.innerHTML = ''; // Nascondi la tendina se l'input è troppo breve
                }
            });

            // Nascondi i suggerimenti se l'utente clicca altrove
            document.addEventListener('click', function(event) {
                if (!suggestionsBox.contains(event.target) && event.target !== addressInput) {
                    suggestionsBox.innerHTML = ''; // Nascondi i suggerimenti
                }
            });

            // Verifica se l'indirizzo inserito è valido prima di inviare il form
            apartmentForm.addEventListener('submit', function(event) {
                if (!suggestionsArray.includes(addressInput.value)) {
                    event.preventDefault(); // Blocca l'invio del form
                    errorMessage.textContent =
                        'Indirizzo non valido. Seleziona un indirizzo dalla lista.'; // Mostra l'errore
                }
            });
        });

        function Preview(event) {
            const thumb = document.getElementById('thumb');
            thumb.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection
