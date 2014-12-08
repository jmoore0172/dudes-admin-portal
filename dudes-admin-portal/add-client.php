<?php


if(isset($_POST)) {
		$CustomerName = $_POST['CustomerName'];
		$CustomerCompany = $_POST['CustomerCompany'];
		$CustomerAddress = $_POST['CustomerAddress'];
		$CustomerCity = $_POST['CustomerCity'];
		$CustomerZip = $_POST['CustomerZip'];
		$CustomerState = $_POST['CustomerState'];
		$CustomerPhone = $_POST['CustomerPhone'];
		$CustomerEmail = $_POST['CustomerEmail'];
		$CustomerType = $_POST['CustomerType'];


my_var_dump(db_query("INSERT INTO `CustomerInfo` (CustomerName, CustomerCompany, CustomerAddress, CustomerCity, CustomerZip, CustomerState, CustomerPhone, CustomerEmail, CustomerType) VALUES($CustomerName, $CustomerCompany, $CustomerAddress, $CustomerCity, $CustomerZip, $CustomerState, $CustomerPhone, $CustomerEmail, $CustomerType)"));


}
?>