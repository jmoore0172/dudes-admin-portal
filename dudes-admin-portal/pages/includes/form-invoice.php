<style>
.invoice-template .rightalign { text-align: right; }
.invoice-template th { white-space: nowrap; }
.invoice-template td,
.invoice-template th { padding: 4px; }
.invoice-template .invoice-total { text-align: right; font-weight: bold; }
</style>

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
	
	<script>
	(function($) {
		$('[name="DueDateSelect"]').on('change', function() {
			if ($(this).val() === 'custom') {
				$('[name=DueDate]').val('').focus();
			} else {
				$('[name=DueDate]').val($(this).val());
			}
		}).trigger('change');
	})(jQuery);
	</script>
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
		</td>
		<td>
			<?= $job['JobHours'] ?>
		</td>
		<td>
			<?= format_cash($job['InvoiceRate']) ?>
		</td>
		<td class="rightalign">
			<?= format_cash($job['InvoiceTotal']) ?>
		</td>
	</tr>
</table>

<div class="invoice-total">
	Invoice Total: &nbsp; <?= format_cash($job['InvoiceTotal']) ?>
	<input type="hidden" name="InvoiceTotal" value="<?= $job['InvoiceTotal'] ?>" />
</div>	

<?= $invoice_footer_msg ?>

<input type="hidden" name="CustomerID" value="<?= $customer['CustomerID'] ?>" />
<input type="hidden" name="JobID" value="<?= $job['JobID'] ?>" />

<?php endif; ?>