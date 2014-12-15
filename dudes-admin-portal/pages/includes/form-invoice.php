<?php if (!$job_selected) :
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

<?php else: $job = get_jobs($_REQUEST['job_id']); $customer = get_customer($job['CustomerID']); ?>


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
		<?php echo $customer['CustomerCity']; ?>, <?php echo $customer['CustomerState']; ?>,  <?php echo $customer['CustomerZip']; ?> 
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
	<tr>
		<td>
			<?= $job['JobType'] ?> - <?= $job['DeviceType'] ?>
			<input type="hidden" name="description[<?= $job['JobID'] ?>]" value="<?= $job['JobType'] ?> - <?= $job['DeviceType'] ?>" />
		</td>
		<td>
			<?= $job['JobHours'] ?>
			<input type="hidden" name="hours[<?= $job['JobID'] ?>]" value="<?= $job['JobHours'] ?>" data-default="1" />
		</td>
		<td>
			<?= format_cash($job['InvoiceRate']) ?>
			<input type="hidden" name="rate[<?= $job['JobID'] ?>]" value="<?= $job['InvoiceRate'] ?>" data-default="<?= $the_dudes[0]['rate'] ?>" />
		</td>
		<td class="rightalign">
			<?= format_cash($job['InvoiceTotal']) ?>
			<input type="hidden" name="total[<?= $job['JobID'] ?>]" value="<?= $job['InvoiceTotal'] ?>" />
		</td>
	</tr>
</table>

<button class="add-item">Add Work Item</button>

<div class="invoice-total">
	Invoice Total: &nbsp; <span class="dynamic-display"><?= format_cash($job['InvoiceTotal']) ?></span>
	<input type="hidden" name="InvoiceTotal" value="<?= $job['InvoiceTotal'] ?>" />
</div>	

<?= $invoice_footer_msg ?>

<input type="hidden" name="CustomerID" value="<?= $customer['CustomerID'] ?>" />
<input type="hidden" name="JobID" value="<?= $job['JobID'] ?>" />

<?php endif; ?>