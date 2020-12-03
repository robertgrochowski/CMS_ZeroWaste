<?php
/**
 * Plugin Name: Disable woocommerce logout confirmation
 * Plugin URI: http://hemthapa.com?ref=woodisdowmenu
 * Description: This lightweight plugin disables the woocommerce logout confirmation!
 * Version: 1.2
 * Author: Hem Thapa
 * Author URI: https://hemthapa.com/
 * WC tested up to: 4.4.1
 */

function disable_wc_logout_confirmation(){

	global $wp;

    if(isset($wp->query_vars['customer-logout'])){
        $home_url  = apply_filters("wplr_home_url",home_url( '/' ));
        wp_safe_redirect( str_replace( '&amp;', '&', wp_logout_url( $home_url ) ) );
        exit;
    }
}

add_action('template_redirect', 'disable_wc_logout_confirmation');

?>