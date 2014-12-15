<?php
function shortcode_admin_view_invoice( $atts ){
	global $general_form_error_msg, $invoice_footer_msg, $the_dudes;
	ob_start();
	$job_selected = isset($_REQUEST['job_id']);
	$viewing_invoice = true;
	
?>
<div class="Form-Handle invoice-template">
	<?php include('includes/form-invoice.php'); ?>
</div>
<?php
	return ob_get_clean();
}

add_shortcode( 'admin-view-invoice', 'shortcode_admin_view_invoice' );
?>