<?php
function shortcode_admin_find_client( $atts ){
	ob_start();
?>
<div class="Form-Handle">
	<form action="<?php echo get_bloginfo('url').'/manage/jobs/add/' ?>" method="GET">Customers:
		<p><select name="customer_id">
			<?php
				$result = db_query("SELECT * FROM `CustomerInfo`");
				foreach($result as $customer) {
					echo '<option value="'.$customer['CustomerID'].'"">'.$customer['CustomerName'].'</option>';
				}
			?>
		</select></p>
		<p><input type="submit" name="go" value="Select Customer" /></p>
	</form>
</div>
<?php
	return ob_get_clean();
}

// add_action( 'wp_loaded', 'redirect_check', 100 );

// function redirect_check() {
// 	if (isset($_POST['customer_id'])) {
// 		wp_redirect( ?customer_id='.$_POST['customer_id'] );
// 	}
// }

add_shortcode( 'admin-find-client-form', 'shortcode_admin_find_client' );
?>