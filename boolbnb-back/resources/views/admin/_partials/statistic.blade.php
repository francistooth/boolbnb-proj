<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart.js</title>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
</head>

<body>

    <div class="mt-4 text-center">
        <h3>Le visite al tuo appartamento</h3>

        <div class="mt-2">
            <label class="text-uppercase" for="startDate" >Data Inizio:</label>
            <input class="mb-2" type="date" value="{{$dateEndGraph->format('Y-m-d')}}" id="startDate" name="startDate" >
            <br>
            <label class="text-uppercase" for="endDate">Data Fine:</label>
            <input class="mb-2" type="date" value="{{$currentlyDate->format('Y-m-d')}}" id="endDate" name="endDate">
            <br>
            <button class="btn btn-secondary" onclick="filterData()">Ricerca</button>
            <button class="btn btn-danger" onclick="resetData()">Annulla</button>
        </div>

        <div class="mx-auto">
            <canvas id="yearlyVisit"></canvas>
        </div>
    </div>

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
       
        // Trasformo le visite in un file json in modo che javascript lo possa interpretare
        const visitsData = @json($visits);

        // Converto le date in Mese/Anno
        function getMonthName(dateString) {
            const date = new Date(dateString);
            const monthNames = ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno",
                "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"
            ];
            return `${monthNames[date.getMonth()]} ${date.getFullYear()}`;
        }

        // Aggregazione dei dati per mese
        const monthlyVisits = visitsData.reduce((acc, visit) => {
            const monthYear = getMonthName(visit.date);
            if (!acc[monthYear]) {
                acc[monthYear] = 0;
            }
            acc[monthYear] += visit.count;
            return acc;
        }, {});

        // Estrazione delle etichette e dei dati aggregati
        const labels = Object.keys(monthlyVisits);
        const data = Object.values(monthlyVisits);

        // Configurazione del grafico
        var ctx = document.getElementById('yearlyVisit').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: '# Visite registrate',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Funzione per filtrare i dati in base all'intervallo di date
        function filterData() {

            // Controllo che le date siano inserite 
            const startDateValue = document.getElementById('startDate').value;
            const endDateValue = document.getElementById('endDate').value;
                if (!startDateValue || !endDateValue) {
                $('#errorModal').modal('show');
                return;
            }

            // Controllo che la data d'inizio non sia maggiore di quella di fine 
            const startDate = new Date(startDateValue);
            const endDate = new Date(endDateValue);

            if(startDate > endDate){
                $('#errorModal').modal('show');
                return;
            }


            const filteredData = visitsData.filter(visit => {
                const visitDate = new Date(visit.date);
                return visitDate >= startDate && visitDate <= endDate;
            });

            // Aggregazione dei dati filtrati
            const filteredMonthlyVisits = filteredData.reduce((acc, visit) => {
                const monthYear = getMonthName(visit.date);
                if (!acc[monthYear]) {
                    acc[monthYear] = 0;
                }
                acc[monthYear] += visit.count;
                return acc;
            }, {});

            myChart.data.labels = Object.keys(filteredMonthlyVisits);
            myChart.data.datasets[0].data = Object.values(filteredMonthlyVisits);
            myChart.update();
        }

        // Funzione per resettare il grafico ai dati iniziali
        function resetData() {
            document.getElementById('startDate').value = '{{$dateEndGraph->format('Y-m-d')}}';
            document.getElementById('endDate').value = '{{$currentlyDate->format('Y-m-d')}}';

            myChart.data.labels = labels;
            myChart.data.datasets[0].data = data;
            myChart.update();
        }
    </script>
</body>

</html>
