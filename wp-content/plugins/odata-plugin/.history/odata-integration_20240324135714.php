<?php
/*
Plugin Name: OData Integration
Description: Plugin for integrating OData API with WordPress
Version: 1.0
*/

// Enqueue scripts and styles
function odata_enqueue_scripts() {
    // Ensure WordPress functions are available
    if (!function_exists('wp_enqueue_script')) {
        return;
    }

    wp_enqueue_script('chartjs', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js', array(), '3.7.0', true);
    wp_enqueue_script('odata-scripts', plugins_url('scripts.js', __FILE__), array('jquery'), null, true);
    wp_enqueue_style('odata-styles', plugins_url('styles.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'odata_enqueue_scripts');

// Shortcode for displaying pie chart
function odata_pie_chart_shortcode() {
    // Retrieve data from OData API
    $api_url = 'https://services.odata.org/TripPinRESTierService/People';
    $response = wp_remote_get($api_url);
    $data = json_decode(wp_remote_retrieve_body($response), true);

   
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
