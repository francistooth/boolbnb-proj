<div class="form-group mb-3">
    <!-- LABEL -->
    <label for="address">
        Indirizzo: <strong class="text-danger">*</strong>
    </label>

    <!-- USER INPUT -->
    <input type="text" id="address" value="{{ $old }}" name="address"
        class="form-control @error('address') is-invalid @enderror" placeholder="Es: Via del Corso 73, 00186 Roma"
        required autocomplete="off">

    <!-- RISULTATI API -->
    <div id="address-suggestions" class="list-group"></div>

    <!-- MESSAGGIO DI ERRORE -->
    <small id="address-error" class="text-danger"></small>

    @error('address')
        <small class="text-danger">
            *{{ $message }}
            <br>
            Consigliamo di selezionare un risultato dalla lista dei suggerimenti
        </small>
    @enderror
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
                `https://api.tomtom.com/search/2/geocode/${encodeURIComponent(query)}.json?key=${apiKey}&limit=5&countrySet=IT`;

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    suggestionsArray = data.results.map(result => result.address
                        .freeformAddress); // Salva i risultati nell'array
                    showSuggestions(data.results);
                })
                .catch(error => {
                    console.error('Errore nella chiamata API TomTom:', error);
                });
        }

        // Funzione per mostrare i suggerimenti nella tendina
        function showSuggestions(results) {
            suggestionsBox.innerHTML = ''; // Pulisci i vecchi suggerimenti
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

        // Funzione per verificare l'input iniziale (se c'è un valore da old())
        function checkInitialInput() {
            const initialValue = addressInput.value.trim();
            if (initialValue.length > 2) {
                apiCall(initialValue); // Esegui la chiamata API per ripopolare suggestionsArray
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

        // Esegui il controllo iniziale dell'input quando la pagina è caricata
        checkInitialInput();
    });
</script>
