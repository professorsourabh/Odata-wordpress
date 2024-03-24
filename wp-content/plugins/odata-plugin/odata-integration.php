<?php
/*
Plugin Name: OData Integration
Description: Plugin for integrating OData API with WordPress
Version: 1.0
Author: Sandeep Singh
Author URI:https://sandeep-portfolio-06.vercel.app
*/


function odata_enqueue_scripts()
{

    wp_enqueue_script('chartjs', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js', array(), '3.7.0', true);
    wp_enqueue_style('odata-custom-styles', plugins_url('styles.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'odata_enqueue_scripts');

//for displaying pie chart of people
function odata_pie_chart_shortcode()
{

    $api_url = 'https://services.odata.org/TripPinRESTierService/People';
    $response = wp_remote_get($api_url);
    $data = json_decode(wp_remote_retrieve_body($response), true);


    $regions = array();
    foreach ($data['value'] as $person) {
        if (isset($person['AddressInfo'][0]['City']['Region'])) {
            $region = $person['AddressInfo'][0]['City']['Region'];
            if (!isset($regions[$region])) {
                $regions[$region] = 1;
            } else {
                $regions[$region]++;
            }
        }
    }

    $chart_data = array(
        'labels' => array_keys($regions),
        'data' => array_values($regions)
    );

    $chart_data_json = json_encode($chart_data);
    ob_start();
?>
    <canvas id="odata-pie-chart" width="400" height="400"></canvas>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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



//for displaying list of people
function odata_people_list_shortcode()
{

    $api_url = 'https://services.odata.org/TripPinRESTierService/People';
    $response = wp_remote_get($api_url);
    $data = json_decode(wp_remote_retrieve_body($response), true);

    ob_start(); ?>
    <div class="odata-people-list">

        <table class="people table table-striped">
            <thead>
                <tr>
                    <th>Sno</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Region</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($data['value']) && is_array($data['value'])) {
                    $sno = 1;
                    foreach ($data['value'] as $person) {
                        $firstName = $person['FirstName'];
                        $lastName = $person['LastName'];
                        $gender = $person['Gender'];
                        $region = isset($person['AddressInfo'][0]['City']['Region']) ? $person['AddressInfo'][0]['City']['Region'] : 'N/A';
                ?>
                        <tr>
                            <td><?php echo $sno; ?></td>
                            <td><?php echo $firstName; ?></td>
                            <td><?php echo $lastName; ?></td>
                            <td><?php echo $gender; ?></td>
                            <td><?php echo $region; ?></td>
                        </tr>
                <?php
                        $sno++;
                    }
                } else {
                    echo '<tr><td colspan="5">No data available</td></tr>';
                }
                ?>
            </tbody>
        </table>

    </div>
<?php
    return ob_get_clean();
}
add_shortcode('odata_people_list', 'odata_people_list_shortcode');
