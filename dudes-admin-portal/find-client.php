<?php
	if( isset($_POST['CustomerName']) ) {
		$CustomerName = $_POST['CustomerName'];
		$sql ="SELECT * FROM `CustomerInfo` WHERE `CustomerName`=$CustomerName";
		db_connect($sql)
		db_query($sql);
		$result = mysql_query($sql);
		my_var_dump($result);
	}
?>