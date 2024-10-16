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

            <form class="d-flex flex-column gap-4" method="POST" action="{{ route('admin.apartments.store') }}">
                @csrf

                <div class="form-group">
                    <label for="title">Titolo:</label>
                    <input value="{{ old('title') }}" type="text" id="title" name="title" class="form-control"
                        required>

                    @error('title')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Descrizione:</label>
                    <textarea id="description" name="description" class="form-control" required>{{ old('description') }}</textarea>

                    @error('description')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="room">Numero stanze:</label>
                    <input value="{{ old('room') }}" type="number" id="room" name="room" class="form-control"
                        required>

                    @error('room')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bathroom">Numero di bagni</label>
                    <input value="{{ old('bathroom') }}" type="number" id="bathroom" name="bathroom" class="form-control"
                        required>

                    @error('bathroom')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bed">Numero di letti</label>
                    <input value="{{ old('bed') }}" type="number" id="bed" name="bed" class="form-control"
                        required>

                    @error('bed')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sqm">Metri quadrati:</label>
                    <input value="{{ old('sqm') }}" type="number" id="sqm" name="sqm" class="form-control"
                        required>

                    @error('sqm')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Indirizzo:</label>
                    <input value="{{ old('address') }}" type="text" id="address" name="address" class="form-control"
                        required>

                    {{-- risultati chiamata API --}}
                    <div id="address-suggestions" class="list-group" style="position: absolute; z-index: 100;">
                    </div>

                    @error('address')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="services" class="form-label d-block">Servizi disponibili:</label>

                    <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">

                        @foreach ($services as $service)
                            <input value="{{ $service->id }}" name="services[]" type="checkbox" class="btn-check"
                                id="service-{{ $service->id }}" autocomplete="off"
                                @if (in_array($service->id, old('services', []))) checked @endif>

                            <label class="btn btn-outline-primary"
                                for="service-{{ $service->id }}">{{ $service->name }}</label>
                        @endforeach

                    </div>
                </div>

                <div class="form-group">
                    <label for="img_path">Immagine:</label>
                    <input type="file" id="img_path" name="img_path" class="form-control mb-4">
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
            const apiKey = 'PmDZl7vx3YsaUvAjiu8WRKIDvd4SGoNG';

            // Funzione per fare la chiamata all'API TomTom
            function fetchAddressSuggestions(query) {
                const apiUrl =
                    `https://api.tomtom.com/search/2/geocode/${encodeURIComponent(query)}.json?key=${apiKey}`;

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
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
                    fetchAddressSuggestions(query);
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
        });
    </script>
@endsection
