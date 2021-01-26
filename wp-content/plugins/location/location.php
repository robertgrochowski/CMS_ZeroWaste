<?php
/**
 * @author            Robert Grochowski, Marek Parr, Anna Żak, Katarzyna Jasica
 * @license           GPL-2.0-or-later
 *
 * Plugin Name:       Location
 * Description:       Add geolocation information to products.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.0
 * Author:            Robert Grochowski, Marek Parr, Anna Żak, Katarzyna Jasica
 */

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_activation_hook( __FILE__, 'register_activation' );
function register_activation() {
    disable_new_product_popup();
}


function disable_new_product_popup() {
    global $wpdb;
    $popup_enabled = '"disable_product_popup";s:3:"off"';
    $popup_disabled = '"disable_product_popup";s:2:"on"';

    $selling_options = $wpdb->get_row("SELECT option_value FROM wp_options WHERE option_name LIKE 'dokan_selling'");
    if (strpos($selling_options->option_value, $popup_enabled)) {
        $value = str_replace($popup_enabled, $popup_disabled, $selling_options->option_value);
        $wpdb->update('wp_options', array('column' => 'option_value', 'field' => $value), array('option_name' => 'dokan_selling'));
    }
}

register_uninstall_hook(__FILE__, 'register_deactivation');
function register_deactivation() {
    enable_new_product_popup();
}

function enable_new_product_popup() {
    global $wpdb;
    $popup_enabled = '"disable_product_popup";s:3:"off"';
    $popup_disabled = '"disable_product_popup";s:2:"on"';

    $selling_options = $wpdb->get_row("SELECT option_value FROM wp_options WHERE option_name LIKE 'dokan_selling'");
    if (strpos($selling_options->option_value, $popup_disabled)) {
        $value = str_replace($popup_disabled, $popup_enabled, $selling_options->option_value);
        $wpdb->update('wp_options', array('column' => 'option_value', 'field' => $value), array('option_name' => 'dokan_selling'));
    }
}

add_action('woocommerce_after_single_product_summary', 'show_map');
function show_map() {
    include("templates/show_map.php");
}

add_action('dokan_new_product_after_product_tags', 'add_map', 10);
function add_map() {
    include("templates/add_map.php");
}

add_action('dokan_new_product_added', 'save_add_product_meta', 10, 2);
add_action( 'dokan_product_updated', 'save_add_product_meta', 10, 2 );

function save_add_product_meta($product_id, $postdata){
    if (!dokan_is_user_seller( get_current_user_id()) || empty( $postdata['latitude']) || empty( $postdata['longitude'])) {
        return;
    }

    update_post_meta( $product_id, 'latitude', wc_float_to_string($postdata['latitude']));
    update_post_meta( $product_id, 'longitude', wc_float_to_string($postdata['longitude']));
}

add_action('dokan_product_edit_after_product_tags','edit_map',99,2);
function edit_map($post, $post_id) {
    $latitude = get_post_meta($post_id, 'latitude', true);
    $longitude = get_post_meta($post_id, 'longitude', true);

    ?>
    <style>
        #map {
            height: 300px;
            width: 100%;
        }
    </style>
    <div class="dokan-form-group">
        <input id="latitude" name="latitude" type="hidden" value="<?php echo esc_attr($latitude) ?>" />
        <input id="longitude" name="longitude" type="hidden" value="<?php echo esc_attr($longitude) ?>" />
    </div>
    <div id="map"></div>
    <script id="map_script" defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgFb65StJaH_YvREznt-NzWfM1JicH0k8&callback=initMap">
    </script>

    <script id="init_map_script">
        let pos;
        let marker;
        let lat = document.getElementById('latitude').value ?
            parseFloat(document.getElementById('latitude').value) : 52.232222;
        let long = document.getElementById('longitude').value ?
            parseFloat(document.getElementById('longitude').value) : 21.008333;

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: new google.maps.LatLng(lat, long),
                zoom: 15
            });
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };
                        map.setCenter(pos);
                    }
                );
            }
            pos = new google.maps.LatLng(lat, long);
            marker = new google.maps.Marker({
                position: pos,
                map: map
            })
            google.maps.event.addListener(map, 'click', function(event) {
                move_marker(event.latLng)
            });
        }

        function move_marker(location) {
            marker.setPosition(location);
            document.getElementById("latitude").value = location.lat();
            document.getElementById("longitude").value = location.lng();
        }
    </script>
    <?php
}
