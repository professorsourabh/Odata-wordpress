<?php
/*
Plugin Name: OData Integration
Description: Plugin for integrating OData API with WordPress
Version: 1.0
Author: Sandeep Singh
Author URI:https://sandeep-portfolio-06.vercel.app
*/

// Enqueue scripts and styles
function odata_enqueue_scripts() {
   if (!function_exists('wp_enqueue_script')) {
        return;
    }

    wp_enqueue_script('chartjs', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js', array(), '3.7.0', true);
    wp_enqueue_style('odata-styles', plugins_url('style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'odata_enqueue_scripts');

// Shortcode for displaying pie chart
function odata_pie_chart_shortcode() {
    // Retrieve data from OData API
    $api_url = 'https://services.odata.org/TripPinRESTierService/People';
    $response = wp_remote_get($api_url);
    $data = json_decode(wp_remote_retrieve_body($response), true);

    // Process data to extract region information
    $regions = array();
    foreach ($data['value'] as $person) {
        $city = $person['AddressInfo'][0]['City']['Name'];
        if (!isset($regions[$city])) {
            $regions[$city] = 1;
        } else {
            $regions[$city]++;
        }
    }

    // Generate data for Chart.js pie chart
    $chart_data = array(
        'labels' => array_keys($regions),
        'data' => array_values($regions)
    );

    // Convert data to JSON format
    $chart_data_json = json_encode($chart_data);

    // Return HTML markup for displaying the chart
    ob_start(); ?>
    <canvas id="odata-pie-chart" width="400" height="400"></canvas>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('odata-pie-chart').getContext('2d');
            var chartData = <?php echo $chart_data_json; ?>;
            var myPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        data: chartData.data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)',
                            'rgba(255, 99, 132, 0.7)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('odata_pie_chart', 'odata_pie_chart_shortcode');


// Shortcode for displaying list of people
function odata_people_list_shortcode() {
    // Retrieve data from OData API
    $api_url = 'https://services.odata.org/TripPinRESTierService/People';
    $response = wp_remote_get($api_url);
    $data = json_decode(wp_remote_retrieve_body($response), true);

    // Display list of people
    ob_start(); ?>
    <div class="odata-people-list">
        <h3>Users List</h3>
        <ul class="people">
            <?php foreach ($data['value'] as $person) : ?>
                <li class="person">
                    <p><strong>Name:</strong> <?php echo $person['FirstName'] . ' ' . $person['LastName']; ?></p>
                    <p><strong>City:</strong> <?php echo $person['AddressInfo'][0]['City']['Name']; ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('odata_people_list', 'odata_people_list_shortcode');
