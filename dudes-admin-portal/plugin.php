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
	include('config.php');
	include('database.php');
	include('functions.php');
	switch(getslug()){ 
		case 'functions':
			include('customer-type.php');
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
