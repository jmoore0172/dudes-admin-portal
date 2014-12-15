<?php
	if (isset($_REQUEST['invoice_id'])) {
		$invoice = db_query("SELECT * FROM InvoiceInfo WHERE InvoiceID = ".$_REQUEST['invoice_id']);
		$invoice = $invoice[0];
		$job = get_jobs($invoice['JobID']);
		
		$line_items = json_decode($invoice['LineItems'], true);
	} else {
		$job = get_jobs($_REQUEST['job_id']);
		
		$line_items = invoice_add_line_item_json(array(
			"description" => $job['JobType'] . ' - ' . $job['DeviceType'],
			"hours" => $job['JobHours'],
			"rate" => $job['InvoiceRate'],
			"total" => $job['InvoiceTotal']
		));
	}
	$customer = get_customer($job['CustomerID']);
	
	$total = isset($invoice['InvoiceTotal']) ? $invoice['InvoiceTotal'] : $job['InvoiceTotal'];
?>

	
	<p><img src="<?= get_bloginfo('url') ?>/wp-content/uploads/2014/12/pc-dudes-logo.png" /></p>
	
	<div class="clearfix addresses">
		<p class="alignleft">		
			<small>From:</small><br />
			PC Dudes<br />
			19593 North For River Rd<br />
			Abingdon, VA 24210
		</p>
		
		<p class="alignright">
			<small>Invoice for:</small><br />
			<?php echo $customer['CustomerName']; ?><br />
			<?php echo $customer['CustomerAddress']; ?><br />
			<?php echo $customer['CustomerCity']; ?>, <?php echo $customer['CustomerState']; ?>, <?php echo $customer['CustomerZip']; ?> 
		</p>
		
		<div style="clear: both;"></div>
	</div>
	
	<hr />
	
	<p>Issue date: <input type="text" name="IssueDate" class="datepicker" value="<?php echo date('Y-m-d'); ?>" /></p>
	
	<p>
		Due date:
		<select name="DueDateSelect">
			<option value="<?php echo date('Y-m-d', strtotime("+30 days")); ?>">Net 30</option>
			<option value="<?php echo date('Y-m-d', strtotime("+15 days")); ?>">Net 15</option>
			<option value="custom">Custom</option>
		</select>
	
		<input type="text" name="DueDate" class="datepicker"  value="<?php echo date('Y-m-d', strtotime("+30 days")); ?>" />
		<div style="clear: both;"></div>
	</p>
	
	<hr />
	
	<table class="line-items">
		<tr>
			<th style="width: 70%">Description</th>
			<th>Qty</th>
			<th>Unit Price</th>
			<th class="rightalign">Amount</th>
		</tr>
		
		<?php foreach($line_items as $item) : ?>
		
		<tr>
			<td>
				<?= $item['description'] ?>
				<input type="hidden" name="description[<?= $job['JobID'] ?>]" value="<?= $item['description'] ?>" />
			</td>
			<td>
				<?= $item['hours'] ?>
				<input type="hidden" name="hours[<?= $job['JobID'] ?>]" value="<?= $item['hours'] ?>" data-default="1" />
			</td>
			<td>
				<?= format_cash($item['rate']) ?>
				<input type="hidden" name="rate[<?= $job['JobID'] ?>]" value="<?= $item['rate'] ?>" data-default="<?= $the_dudes[0]['rate'] ?>" />
			</td>
			<td class="rightalign">
				<?= format_cash($item['total']) ?>
				<input type="hidden" name="total[<?= $job['JobID'] ?>]" value="<?= $job['InvoiceTotal'] ?>" />
			</td>
		</tr>
		
		<?php endforeach; ?>
	</table>
	
	<?php if (isset($editing_invoice)) : ?>
		<button class="add-item">Add Work Item</button>
	<?php endif; ?>
	
	<div class="invoice-total">
		Invoice Total: &nbsp; <span class="dynamic-display"><?= format_cash($total) ?></span>
		<input type="hidden" name="InvoiceTotal" value="<?= $total ?>" />
	</div>	
	
	<?= $invoice_footer_msg ?>
	
	<p class="notes">
		Notes:
		<textarea name="Notes"></textarea>
		<div style="clear: both;"></div>
	</p>
	
	<input type="hidden" name="CustomerID" value="<?= $customer['CustomerID'] ?>" />
	<input type="hidden" name="JobID" value="<?= $job['JobID'] ?>" />
	<input type="hidden" name="LineItems" value='<?= json_encode($line_items) ?>' />