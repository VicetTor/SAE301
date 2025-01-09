@extends('Base')

@section('title', 'Graphique des formations') <!-- French: Training Chart -->

@section('content')

<h1 class="my-4">Graphique des formations</h1> <!-- French: Training Chart -->

<!-- Canvas element where the chart will be rendered -->
<canvas id="trainingChart" width="400" height="200"></canvas>

<!-- Include the Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // This script runs when the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function () {
        // Get the context of the canvas element
        const ctx = document.getElementById('trainingChart').getContext('2d');
        
        // Fetch the training data passed from the backend
        const data = @json($data); 

        // Extract unique years from the data to be used as labels on the X-axis
        const labels = [...new Set(data.map(item => item.ANNU_YEAR))];

        // Extract unique training IDs to create datasets for each training
        const trainings = [...new Set(data.map(item => item.TRAIN_ID))];

        // Create a dataset for each training
        const datasets = trainings.map(training => {
            return {
                label: `Formation ${training}`, // Label for the dataset
                data: labels.map(year => {
                    // Find the corresponding entry for the given year and training
                    const entry = data.find(item => item.ANNU_YEAR === year && item.TRAIN_ID === training);
                    // If an entry is found, return the total registrations, otherwise 0
                    return entry ? entry.total_inscriptions : 0;
                }),
                borderColor: `#${Math.floor(Math.random()*16777215).toString(16)}`, // Generate a random color for each dataset
                fill: false // Do not fill the area under the line
            };
        });

        // Initialize the chart using Chart.js
        new Chart(ctx, {
            type: 'line', // Specify that this is a line chart
            data: {
                labels: labels, // X-axis labels (years)
                datasets: datasets // The datasets to display (trainings)
            },
            options: {
                responsive: true, // Make the chart responsive to window resizing
                scales: {
                    x: {
                        title: {
                            display: true, // Display title on the X-axis
                            text: 'Année' // French: Year
                        }
                    },
                    y: {
                        title: {
                            display: true, // Display title on the Y-axis
                            text: 'Nombre d\'inscriptions' // French: Number of Registrations
                        }
                    }
                }
            }
        });
    });
</script>

@endsection
