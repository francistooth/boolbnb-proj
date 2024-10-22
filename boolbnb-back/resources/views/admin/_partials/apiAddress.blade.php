<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addressInput = document.getElementById('address');
        const suggestionsBox = document.getElementById('address-suggestions');
        const apartmentForm = document.getElementById('apartmentForm');
        const errorMessage = document.getElementById('address-error'); // Elemento per l'errore
        const apiKey = 'PmDZl7vx3YsaUvAjiu8WRKIDvd4SGoNG';
        let suggestionsArray = []; // Array per memorizzare i risultati dell'API
        const initialAddressValue = addressInput.value; // Memorizza il valore iniziale

        // Pulisce il contenuto del campo address al caricamento della pagina
        addressInput.value = '';

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
            if (!suggestionsArray.includes(addressInput.value)) {
                event.preventDefault(); // Blocca l'invio del form
                errorMessage.textContent =
                    'Indirizzo non valido. Seleziona un indirizzo dalla lista.'; // Mostra l'errore
            }
        });
    });
</script>
