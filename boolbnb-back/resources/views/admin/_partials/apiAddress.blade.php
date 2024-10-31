<div class="form-group mb-3">
    <!-- LABEL -->
    <label for="address">
        Indirizzo: <strong class="text-danger">*</strong>
    </label>

    <!-- USER INPUT -->
    <input type="text" id="address" value="{{ $old }}" name="address"
        class="form-control @error('address') is-invalid @enderror" placeholder="Es: Via del Corso 73, 00186 Roma"
        required autocomplete="off" data-bs-toggle="tooltip" data-bs-placement="top"
        data-bs-title="L'indirizzo deve essere del formato: 'Via o Piazza ecc.. NomeVia Civico, CAP Città'"
        data-bs-custom-class="custom-tooltip">

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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    document.addEventListener('DOMContentLoaded', function() {
        const addressInput = document.getElementById('address');
        const suggestionsBox = document.getElementById('address-suggestions');
        const apartmentForm = document.getElementById('apartmentForm');
        const errorMessage = document.getElementById('address-error'); // Elemento per l'errore
        const apiKey = 'PmDZl7vx3YsaUvAjiu8WRKIDvd4SGoNG';
        let suggestionsArray = []; // Array per memorizzare i risultati dell'API
        const initialAddressValue = addressInput.value; // Memorizza il valore iniziale

        // Funzione per fare la chiamata all'API TomTom
        function apiCall(query) {
            const apiUrl =
                `https://api.tomtom.com/search/2/geocode/${encodeURIComponent(query)}.json?key=${apiKey}&limit=5&countrySet=IT`;

            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    suggestionsArray = data.results.map(result => result.address
                        .freeformAddress); // Salva i risultati nell'array
                    showSuggestions(data.results);
                    // Controlla se il valore iniziale è valido
                    if (initialAddressValue && suggestionsArray.includes(initialAddressValue)) {
                        errorMessage.textContent = ''; // Rimuovi eventuali messaggi di errore
                    }
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

        // Ascolta l'input dell'utente e attiva la ricerca
        addressInput.addEventListener('input', function() {
            const query = addressInput.value.trim();

            // Mostra i suggerimenti solo se il valore è stato cambiato dall'utente
            if (query.length > 2 && query !== initialAddressValue) {
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
            const addressValue = addressInput.value;

            // Se l'input è precompilato, verifica se corrisponde ai risultati API
            if (suggestionsArray.length === 0 || !suggestionsArray.includes(addressValue)) {
                event.preventDefault(); // Blocca l'invio del form
                errorMessage.textContent =
                    'Indirizzo non valido. Seleziona un indirizzo dalla lista.'; // Mostra l'errore
            }
        });

        // Fai la chiamata API iniziale con il valore precompilato
        if (initialAddressValue) {
            apiCall(initialAddressValue); // Controlla se il valore iniziale è valido
        }
    });
</script>
