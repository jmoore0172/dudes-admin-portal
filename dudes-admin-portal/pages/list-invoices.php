<?php
function shortcode_admin_list_invoices() {
	$invoices = db_query("SELECT * FROM InvoiceInfo ORDER BY InvoiceID DESC");
	ob_start();
	echo '<ul>';
	foreach($invoices as $invoice) : ?>
	
		<li>
			<a href="<?= get_bloginfo('url') ?>/invoice/view/?invoice_id=<?= $invoice['InvoiceID'] ?>">View</a> |
			<a href="<?= get_bloginfo('url') ?>/invoice/edit/?invoice_id=<?= $invoice['InvoiceID'] ?>">Edit</a>
			
			&mdash; Invoice #<?= $invoice['InvoiceID'] ?>
		</li>
	
	<?php endforeach; echo '</ul>'; return ob_get_clean();
}

add_shortcode( 'admin-list-invoices', 'shortcode_admin_list_invoices' );
?>