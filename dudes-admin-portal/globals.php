<?php
$general_form_error_msg = '<p>WTF Mate, Uz musta done sumptin wrong, yo.</p> <p><a href="javascript:window.history.go(-1);">&lt; Go Back and Fix Them Shiz</a></p>';
$invoice_footer_msg = '<p><small>Please make checks payable to Justin Moore.</small></p>';

$job_type = array(
	"Computer Repair",
	"IT Support",
	"Web Design",
	"Networking",
	"Other"
);

$device_type = array(
	"Laptop-PC",
    "Desktop-PC",
    "Tablet",
    "Printer",
    "Phone",
    "Network",
    "Other"
);

$the_dudes = array(
	array(
		"superuser" => true,
		"wordpress_id" => 1,
		"rate" => 35,
		"name" => "Justin Moore"
	),
	array(
		"superuser" => false,
		"wordpress_id" => 2,
		"rate" => 20,
		"name" => "Jason Osborne"
	)
);
?>