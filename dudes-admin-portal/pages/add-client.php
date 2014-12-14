<?php
function shortcode_admin_add_client_form( $atts ){
	ob_start();
	
	if( !isset($_REQUEST['CustomerName']) ) {
		
?>
<div class="Form-Handle">
<form action="" method="GET">
	Name:<input type="text" name="CustomerName"><br /><br />
	Company:<input type="text" name="CustomerCompany"><br /><br />
	Address:<input type="text" name="CustomerAddress"><br /><br />
	City:<input type="text" name="CustomerCity"><br /><br />
	State:<input type="text" name="CustomerState"><br /><br />
	Zip Code:<input type="text" name="CustomerZip"><br /><br />
	Phone:<input type="text" name="CustomerPhone"><br /><br />
	Email:<input type="text" name="CustomerEmail"><br /><br />
        <input type="radio" name="CustomerType" value="Business">&nbsp;&nbsp;Business<br/>
        <input type="radio" name="CustomerType" value="Residential">&nbsp;&nbsp;Residential<br/><br/>
	<p><input type="submit" value="Add" id="Add" name="add"></p>

</form>
</div>
<?php
	} else {
		$CustomerName = $_REQUEST['CustomerName'];
		$CustomerCompany = $_REQUEST['CustomerCompany'];
		$CustomerAddress = $_REQUEST['CustomerAddress'];
		$CustomerCity = $_REQUEST['CustomerCity'];
		$CustomerZip = $_REQUEST['CustomerZip'];
		$CustomerState = $_REQUEST['CustomerState'];
		$CustomerPhone = $_REQUEST['CustomerPhone'];
		$CustomerEmail = $_REQUEST['CustomerEmail'];
		$CustomerType = $_REQUEST['CustomerType'];
	
		$sql = "INSERT INTO `CustomerInfo` (CustomerName, CustomerCompany, CustomerAddress, CustomerCity, CustomerZip, CustomerState, CustomerPhone, CustomerEmail, CustomerType) VALUES('".$CustomerName."', '".$CustomerCompany."', '".$CustomerAddress."', '".$CustomerCity."', '".$CustomerZip."', '".$CustomerState."', '".$CustomerPhone."', '".$CustomerEmail."', '".$CustomerType."')";
		
		$id = db_query($sql);
		if ($id) {
			echo '<p>Successfully added customer.</p><p><a href="'.get_bloginfo('url').'/jobs/add/?customer_id='.$id.'">Start Job &gt;</a></p>';
		} else {
			echo '<p>Failed to add customer.</p>';
		}
	}

	return ob_get_clean();
}

add_shortcode( 'admin-add-client-form', 'shortcode_admin_add_client_form' );
?>