@extends('Base')

@section('title', 'Graphique des formations')

@section('content')

<h1 class="my-4">Graphique des formations</h1>

<canvas id="trainingChart" width="400" height="200"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('trainingChart').getContext('2d');
        const data = @json($data);

        const labels = [...new Set(data.map(item => item.ANNU_YEAR))];
        const trainings = [...new Set(data.map(item => item.TRAIN_ID))];

        const datasets = trainings.map(training => {
            return {
                label: `Formation ${training}`,
                data: labels.map(year => {
                    const entry = data.find(item => item.ANNU_YEAR === year && item.TRAIN_ID === training);
                    return entry ? entry.total_inscriptions : 0;
                }),
                borderColor: `#${Math.floor(Math.random()*16777215).toString(16)}`,
                fill: false
            };
        });

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Année'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Nombre d\'inscriptions'
                        }
                    }
                }
            }
        });
    });
</script>

@endsection