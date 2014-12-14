<?php
/**
 * Plugin Name: PC Dudes Agent Portal
 * Plugin URI: 
 * Description: 
 * Version: 1.0
 * Author: PC Dudes
 * Author URI: 
 * Text Domain: 
 * Domain Path: 
 * Network: 
 * License:
 */

function check_if_logged_in() {
	if (!is_user_logged_in() && (strpos($_SERVER['REQUEST_URI'],'wp-admin') === false) && (strpos($_SERVER['REQUEST_URI'],'wp-login') === false)) {
		die('No content found here.');
	}	
}
add_action( 'wp_loaded', 'check_if_logged_in' );

include('config.php');
include('database.php');
include('functions.php');

include('pages/customer-type.php');
include('pages/add-client.php');
include('pages/find-client.php');
include('pages/select-device.php');
include('pages/add-job.php');
?>