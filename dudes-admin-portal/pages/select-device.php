<?php
function shortcode_admin_select_device( $atts ){
	ob_start();
?>
<form id="SelectDeviceType" action="" method="POST">
	<p><select name="DeviceType" form="SelectDeviceType">
		<option value="Laptop">Laptop - PC</option>
		<option value="Desktop">Desktop - PC</option>
		<option value="Tablet">Tablet</option>
		<option value="Printer">Printer</option>
		<option value="Phone">Phone</option>
		<option value="Other">Other</option>
	</select></p>
	<p><input type="submit" value="Select"></p>
</form>
<?php
	return ob_get_clean();
}

add_shortcode( 'admin-select-device-form', 'shortcode_admin_select_device' );
?>