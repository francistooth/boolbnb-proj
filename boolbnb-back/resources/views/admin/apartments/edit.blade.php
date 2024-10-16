@extends('layouts.app')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <h4>Attenzione!</h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container mt-4">

        <h2>Modifica appartamento: {{ $apartment->title }}</h2>

        <form action="{{ route('admin.apartments.update', $apartment) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="title" class="form-label">Titolo appartamento:</label>
                <input value="{{ old('title', $apartment->title) }}" name="title" type="text"
                    class="form-control @error('title') is-invalid @enderror" id="title">
                @error('title')
                    <small class="text-danger">*{{ $message }}</small>
                @enderror

            </div>

            <div class="form-group mb-3">
                <label for="description" class="form-label">Descrizione:</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                    placeholder="add description">{{ old('description', $apartment->description) }}</textarea>
            </div>


            <div class="form-group mb-3">
                <label for="room">Numero stanze:</label>
                <input value="{{ old('room', $apartment->room) }}" type="number" id="room" name="room"
                    class="form-control @error('room') is-invalid @enderror" required>

                @error('room')
                    <small class="text-danger">*{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="bathroom">Numero di bagni</label>
                <input value="{{ old('bathroom', $apartment->bathroom) }}" type="number" id="bathroom" name="bathroom"
                    class="form-control @error('bathroom') is-invalid @enderror" required>

                @error('bathroom')
                    <small class="text-danger">*{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="bed">Numero di letti</label>
                <input value="{{ old('bed', $apartment->bed) }}" type="number" id="bed" name="bed"
                    class="form-control @error('bed') is-invalid @enderror" required>

                @error('bed')
                    <small class="text-danger">*{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="sqm">Metri quadrati:</label>
                <input value="{{ old('sqm', $apartment->sqm) }}" type="number" id="sqm" name="sqm"
                    class="form-control @error('sqm') is-invalid @enderror" required>

                @error('sqm')
                    <small class="text-danger">*{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="address">Indirizzo:</label>
                <input value="{{ old('address', $apartment->address) }}" type="text" id="address" name="address"
                    class="form-control" required>

                {{-- risultati chiamata API --}}
                <div id="address-suggestions" class="list-group" style="position: absolute; z-index: 100;">
                </div>

                @error('address')
                    <small class="text-danger">*{{ $message }}</small>
                @enderror
            </div>

            {{-- <div class="form-group mb-3">
                <label for="img_path" class="form-label">Immagine</label>
                <input id="img_path" class="form-control" name="img_path" type="file" onchange="showImage(event)">
                @error('img_path')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <img id="thumb" class="thumb pt-1" src="{{ asset('storage/' . $apartment->img_path) }}"
                    onerror="this.src='/img/no-image.jpg'">
            </div> --}}

            <div class="form-group mb-3">
                <label for="technologies" class="form-label d-block">Tecnologia utilizzata:</label>

                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">

                    @foreach ($services as $services)
                        <input value="{{ $services->id }}" name="services[]" type="checkbox" class="btn-check"
                            id="services-{{ $services->id }}" autocomplete="off"
                            @if (
                                ($errors->any() && in_array($services->id, old('services', []))) ||
                                    (!$errors->any() && $apartment->services->contains($services))) checked @endif>

                        <label class="btn btn-outline-primary"
                            for="services-{{ $services->id }}">{{ $services->name }}</label>
                    @endforeach

                </div>
            </div>

            <div class="form-group mb-3">
                <div class="form-check form-switch">
                    <input type="hidden" name="is_visible" value="0">
                    <input name="is_visible" class="form-check-input" type="checkbox" role="switch" value="1"
                        id="is_visible" checked>
                    <label class="form-check-label" for="is_visible">Appartamento visibile al pubblico</label>
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" href="#" class="btn btn-success">Modifica</button>
                <button type="reset" href="#" class="btn btn-danger">Annulla</button>
            </div>

        </form>

    </div>

    <script>
        function showImage(event) {
            const thumb = document.getElementById('thumb');
            thumb.src = URL.createObjectURL(event.target.files[0]);
        }


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
