<?php
function shortcode_admin_edit_invoice_form( $atts ){
	global $general_form_error_msg, $invoice_footer_msg, $the_dudes;
	ob_start();
	$submitted = !empty($_POST);
	$job_selected = isset($_REQUEST['job_id']);
	
	if (!$submitted) {
?>
<div class="Form-Handle invoice-template">
	<form action="" method="<?php echo ($job_selected) ? 'POST' : 'GET'; ?>">
	    <?php include('includes/form-invoice.php'); ?>
	    <p>
	        <input type="submit" value="Create Invoice" />
	    </p>
	</form>
</div>
<?php
	} else {
		$data = array(
			'CustomerID' 	=> $_REQUEST['CustomerID'],
			'JobID' 		=> $_REQUEST['JobID'],
			'LineItems' 	=> $_REQUEST['LineItems'],
			'IssueDate'		=> $_REQUEST['IssueDate'],
			'DueDate'		=> $_REQUEST['DueDate'],
			'Notes'			=> $_REQUEST['Notes'],
			'InvoiceTotal'	=> $_REQUEST['InvoiceTotal']
		);
		$id = db_insert('InvoiceInfo', $data);
		
		if ($id) {
			echo '<p>Invoice created successfully.</p>';
			echo '<p><a href="'.get_bloginfo('url').'/invoice/edit/?invoice_id='.$id.'">Edit Invoice &gt;</a> &nbsp; ';
			echo '<a href="'.get_bloginfo('url').'/invoice/send/?invoice_id='.$id.'">Send Invoice &gt;</a></p>';
		} else {
			echo $general_form_error_msg;
		}

	}
	return ob_get_clean();
}

add_shortcode( 'admin-edit-invoice-form', 'shortcode_admin_edit_invoice_form' );
?>