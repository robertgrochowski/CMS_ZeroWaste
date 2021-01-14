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

$STATUS_TRANSLATION = array(
    'opened'=>'w trakcie rozpatrywania',
    'closed'=>'zakończone');

// Add complaint or show that it was already submitted in Order Details
add_action('woocommerce_order_details_after_customer_details', 'add_complaint_section_in_order_details');
function add_complaint_section_in_order_details()
{

    global $wpdb;
    $user = wp_get_current_user();
    $exp = explode("/", $_SERVER["REQUEST_URI"]);
    $order_id = $wpdb->_real_escape($exp[3]);

    if(!is_numeric($order_id))
    {
        echo "Invalid URL!";
        return;
    }

    if(isset($_POST) && isset($_POST["title"]) && isset($_POST["description"]))
    {
        $wpdb->insert("{$wpdb->prefix}cs_complaints",
            array('reporter_id' => $user->ID,
                'order_id' => $order_id,
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'status' => 'opened',
                'timestamp' => time()));

        show_success_msg("Pomyślnie złożono skargę");
    }

    //check if complaint is already submitted
    $results = $wpdb->get_results("SELECT id, status FROM {$wpdb->prefix}cs_complaints WHERE order_id={$order_id}", OBJECT);

    if (empty($results)) {
        //stworz complaint
        include('templates/complaint_form.php');
    }
    else {
        global $STATUS_TRANSLATION;
        $status = $STATUS_TRANSLATION[$results[0]->status];
        $complain_id = $results[0]->id;
        include('templates/complaint_already_submitted.php');
    }

}

add_filter('woocommerce_account_menu_items', 'complaints_menu_link', 40);
function complaints_menu_link($menu_links)
{

    $menu_links = array_slice($menu_links, 0, 5, true)
        + array('complaints' => 'Complaints')
        + array_slice($menu_links, 5, NULL, true);

    return $menu_links;

}

add_action('init', 'complaints_menu_endpoint');
function complaints_menu_endpoint()
{

    // WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
    add_rewrite_endpoint('complaints', EP_PAGES);

}

add_action('woocommerce_account_complaints_endpoint', 'complaints_menu_content');
function complaints_menu_content()
{
    global $wpdb;
    $user = wp_get_current_user();
    $admin = in_array("administrator", (array) $user->roles);

    $exp = explode("/", $_SERVER["REQUEST_URI"]);
    // We are on endpoint with complaint ID
    if(isset($exp[3]) && !empty($exp[3])) {
        $complaint_id = $wpdb->_real_escape($exp[3]);
        show_complaint($complaint_id, $admin);
        return;
    }

    // we are on endpoint with no ID
    $query = "SELECT cs.id, cs.order_id, cs.title, cs.description, cs.status, cs.reporter_id, cs.timestamp, usr.display_name 
              FROM {$wpdb->prefix}cs_complaints cs
              INNER JOIN wp_users usr ON usr.ID = cs.reporter_id";
    if(!$admin)
        $query .= " WHERE reporter_id={$user->ID}";

    $complaints = $wpdb->get_results($query, OBJECT);
    include("templates/complaint_list.php");
}

function show_complaint($id, $admin){
    global $wpdb;
    global $STATUS_TRANSLATION;

    if(isset($_POST) && isset($_POST['status']))
    {
        if(isset($STATUS_TRANSLATION[$_POST['status']])) {
            $wpdb->query("UPDATE {$wpdb->prefix}cs_complaints SET status='{$_POST['status']}' WHERE id='$id'");
        }
        else {
            echo $_POST['status'].' is invalid!';
        }
    }

    $complaint = $wpdb->get_results("SELECT title, description, status, reporter_id, timestamp, id, order_id
                                        FROM {$wpdb->prefix}cs_complaints 
                                        WHERE id={$id}", OBJECT)[0];
    $user = wp_get_current_user();
    if(isset($_POST) && isset($_POST['message'])) {
        $admin = $complaint->reporter_id == $user->ID ? 0 : 1;
        $wpdb->insert("{$wpdb->prefix}cs_messages",
            array('message' => $_POST['message'],
                'user_id' => $user->ID,
                'is_admin' => $admin,
                'complaint_id' => $id,
                'timestamp' => time()));

        show_success_msg("Dodano wiadomość pomyślnie!");
    }

    $messages = $wpdb->get_results("SELECT m.message, m.timestamp, m.user_id, m.is_admin, usr.display_name
                                        FROM {$wpdb->prefix}cs_messages m
                                        INNER JOIN {$wpdb->prefix}users usr ON usr.ID = m.user_id
                                        WHERE complaint_id={$id}", OBJECT);

    // of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
    include("templates/complaint_ticket.php");
}

function show_success_msg($msg) {
    echo '<div class="woocommerce-message" role="alert">'. $msg.'</div>';
}

?>

