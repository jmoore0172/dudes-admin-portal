<?php
function getslug() {
	    $url = explode('/',rtrim($_SERVER['REQUEST_URI'],'/'));
        return $url[count($url)-1];
}

function modify_content($oldcontent) {
        global $output_addcontent;
        return $oldcontent . $output_addcontent;
}

function output_content($addcontent) {
        global $output_addcontent;
        $output_addcontent = $addcontent;
        add_filter('the_content','modify_content');
}
function my_var_dump($var, $echo=false) {
        $output = "<pre style='color: white; background-color: black; padding: 1em;'>";
        $output .= var_export($var, true);
        $output .= "</pre>";
        if (function_exists("view_add_output") && ($echo === false)) {
                view_add_output($output);
        } else {
                echo $output;
        }
}
function form_selected_state($val1, $val2) {
	return (isset($val1) && isset($val2) && ($val1 == $val2)) ? ' selected="selected"' : '';
}

function format_cash($num) {
	return '$' . number_format($num, 2);
}

function get_customer($id) {
	$customer = db_query("SELECT * FROM CustomerInfo WHERE CustomerID = ".$id);
	return isset($customer[0]) ? $customer[0] : false;
}

function get_jobs($slug) {
	if (is_numeric($slug)) {
		$sql = "SELECT * FROM JobInfo WHERE JobID = ".$slug;
		$result = db_query($sql);
		return (isset($result) && !empty($result)) ? $result[0] : false;
	} else {
		switch($slug) {
			case "open":
				$sql = "SELECT * FROM JobInfo WHERE EndDate IS NULL AND (HideJob <> '1' OR HideJob IS NULL) ORDER BY JobID DESC";
				break;
			case "finished":
				$sql = "SELECT * FROM JobInfo WHERE EndDate IS NOT NULL AND (HideJob <> '1' OR HideJob IS NULL) ORDER BY JobID DESC";
				break;
			case "archived":
				$sql = "SELECT * FROM JobInfo WHERE HideJob = 1 ORDER BY JobID DESC";
				break;
		}
		$result = db_query($sql);
		return (isset($result) && !empty($result)) ? $result : false;
	}
}

function invoice_add_line_item_json($item, $object=NULL) {
	if (!isset($object)) {
		$object = array();
	} elseif (is_string($object)) {
		$object = json_decode($object);
	}
	$object []= $item;
	
	return $object;
}
?>