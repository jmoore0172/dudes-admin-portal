<?php
function shortcode_admin_add_invoice_form( $atts ){
	global $general_form_error_msg, $invoice_footer_msg, $the_dudes;
	ob_start();
	$submitted = !empty($_POST);
	$job_selected = isset($_REQUEST['job_id']);
	
	if (!$submitted) {
?>
<div class="Form-Handle invoice-template">
	<form action="" method="<?php echo ($job_selected) ? 'POST' : 'GET'; ?>">
	
		<?php if (!$job_selected) {
			$jobs = get_jobs('finished'); ?>
		
			<p>Select Job: 
				<select name="job_id">
					<option value="NULL">(Select)</option>
		        
			        <?php foreach($jobs as $job) :
			        	$customer = get_customer($job['CustomerID']); ?>
			        	
						<option<?php echo isset($_REQUEST['job_id']) ? form_selected_state($job['JobID'], $_REQUEST['job_id']) : ''; ?> value="<?php echo $job['JobID']; ?>">
							<?php echo $customer['CustomerName']; ?></strong> : <?php echo $job['JobType']; ?>
						</option>
			        <?php endforeach; ?>
				</select>
			</p>
		<?php } else {
			include('includes/form-invoice.php');
		} ?>

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

add_shortcode( 'admin-add-invoice-form', 'shortcode_admin_add_invoice_form' );
?>