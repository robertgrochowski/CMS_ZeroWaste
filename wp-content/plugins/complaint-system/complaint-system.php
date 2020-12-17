 <?php
 /**
 * Plugin Name
 *
 * @author            Robert Grochowski, Marek Parr, Anna Żak, Katarzyna Jasica
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Complaint system
 * Description:       Description of the plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.0
 * Author:            Robert Grochowski, Marek Parr, Anna Żak, Katarzyna Jasica
*/


 add_action('woocommerce_order_details_after_customer_details', 'add_complaint_section_in_order_details');
 function add_complaint_section_in_order_details() {

    global $wpdb;
    $exp = explode("/", $_SERVER["REQUEST_URI"]);
    $order_id = $exp[3];

    //TODO: sql injection
    $results = $wpdb->get_results( "SELECT id, status FROM {$wpdb->prefix}cs_complaints WHERE order_id={$order_id}", OBJECT );

    if(empty($results))
        include('templates/complaint_form.php');
    else {
        $status = $results[0]->status;
        $complain_id = $results[0]->id;
        include('templates/complaint_already_submitted.php');
    }

}

 add_filter ( 'woocommerce_account_menu_items', 'complaints_menu_link', 40 );
 function complaints_menu_link( $menu_links ){

	 $menu_links = array_slice( $menu_links, 0, 5, true )
		 + array( 'complaints' => 'Complaints' )
		 + array_slice( $menu_links, 5, NULL, true );

	 return $menu_links;

 }

 add_action( 'init', 'complaints_menu_endpoint' );
 function complaints_menu_endpoint() {

	 // WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
	 add_rewrite_endpoint( 'complaints', EP_PAGES );

 }

 add_action( 'woocommerce_account_complaints_endpoint', 'complaints_menu_content' );
 function complaints_menu_content() {

	 // of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
     include("templates/complaint_ticket.php");
 }
?>

