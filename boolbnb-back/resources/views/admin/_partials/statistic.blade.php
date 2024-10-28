<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart.js</title>
    <!-- Includi Bootstrap per utilizzare la modale -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- Grafico per visite appartamenti -->
    <div class="mt-4 text-center">
        <h3>Le visite al tuo appartamento</h3>

        <!-- Selezione dell'intervallo di tempo -->
        <div class="mt-2">
            <label for="startDate">Data Inizio:</label>
            <input type="date" id="startDate" name="startDate">
            <br>
            <label for="endDate">Data Fine:</label>
            <input type="date" id="endDate" name="endDate">
            <br>

            <button onclick="filterData()">Ricerca</button>
            <button onclick="resetData()">Reset</button>
        </div>

        <!-- Grafico delle visite annuali -->
        <div class="mx-auto" style="width: 70%">
            <canvas id="yearlyVisit"></canvas>
        </div>
    </div>

    <!-- Modale di avviso per errore nella ricerca -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attenzione Errore!</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Le date inserite non sono valide</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        // Dati di esempio per le visite mensili
        const monthlyData = [12, 19, 3, 5, 2, 3, 4, 15, 19, 22, 14, 9];
        const labels = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];

        // Logica per inizializzare il grafico
        var ctx = document.getElementById('yearlyVisit').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: '# Visite registrate',
                    data: monthlyData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Funzione per filtrare i dati in base all'intervallo di date
        function filterData() {
            const startDate = new Date(document.getElementById('startDate').value);
            const endDate = new Date(document.getElementById('endDate').value);

            // Validazione delle date
            if (!startDate || !endDate || startDate > endDate) {
                // Mostra la modale di errore
                $('#errorModal').modal('show');
                return;
            }

            // Filtro i dati in base alle date selezionate
            const startMonth = startDate.getMonth();
            const endMonth = endDate.getMonth();
            const filteredData = monthlyData.slice(startMonth, endMonth + 1);

            // Aggiornamento grafico con i nuovi dati inseriti
            myChart.data.labels = labels.slice(startMonth, endMonth + 1);
            myChart.data.datasets[0].data = filteredData;
            myChart.update();
        }

        // Funzione per resettare il grafico ai dati iniziali
        function resetData() {
            // Reset delle date input
            document.getElementById('startDate').value = '';
            document.getElementById('endDate').value = '';

            // Ripristina i dati originali nel grafico
            myChart.data.labels = labels;
            myChart.data.datasets[0].data = monthlyData;
            myChart.update();
        }
    </script>
</body>
</html>
