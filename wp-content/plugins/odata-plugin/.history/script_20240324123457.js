// JavaScript code for generating pie chart using Chart.js
document.addEventListener('DOMContentLoaded', function () {
    // Retrieve data from OData API
    fetch('https://services.odata.org/TripPinRESTierService/People')
        .then(response => response.json())
        .then(data => {
            // Process data to extract region information
            const regionsData = {};
            data.value.forEach(person => {
                const region = person.AddressInfo[0].City.Region;
                if (regionsData[region]) {
                    regionsData[region]++;
                } else {
                    regionsData[region] = 1;
                }
            });

            // Extract labels and data for the chart
            const labels = Object.keys(regionsData);
            const counts = Object.values(regionsData);

            // Create pie chart using Chart.js
            const ctx = document.getElementById('pie-chart').getContext('2d');
            const pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Regions',
                        data: counts,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    title: {
                        display: true,
                        text: 'Distribution of People by Region'
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});
