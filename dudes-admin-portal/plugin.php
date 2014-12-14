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

function admin_onload() {
	if (!is_user_logged_in() && (strpos($_SERVER['REQUEST_URI'],'wp-admin') === false) && (strpos($_SERVER['REQUEST_URI'],'wp-login') === false)) {
		die('No content found here.');
	}
	

	wp_enqueue_style( 'jquery-ui-css', plugins_url('/js/jquery-ui-1.11.2.custom/jquery-ui.min.css', __FILE__));
	wp_enqueue_style( 'jquery-ui-theme', plugins_url('/js/jquery-ui-1.11.2.custom/jquery-ui.theme.min.css', __FILE__));
	
	wp_enqueue_script( 'jquery-ui-custom', plugins_url('/js/jquery-ui-1.11.2.custom/jquery-ui.min.js', __FILE__), array('jquery'));
	wp_enqueue_script( 'pc-dudes-admin', plugins_url('/js/init.js', __FILE__), array('jquery-ui-custom'));
	
	include('config.php');
	include('database.php');
	include('functions.php');
	
	include('pages/customer-type.php');
	include('pages/add-client.php');
	include('pages/find-client.php');
	include('pages/select-device.php');
	include('pages/add-job.php');
	include('pages/edit-job.php');
}

add_action( 'wp_loaded', 'admin_onload' );
?>