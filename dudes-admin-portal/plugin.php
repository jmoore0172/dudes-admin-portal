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
	switch(getslug()){ 
		case 'functions':
			include('customer-type.php');
			break;
		case 'add-client':
			include('add-client.php');
			break;
		case 'find-client':
			include('find-client.php');
			break;
		case 'select-device':
			include('select-device.php');
			break;
		case 'select-job':
			include('select-job.php');
			break;
 	}

?>