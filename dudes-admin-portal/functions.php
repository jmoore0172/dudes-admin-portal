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
?>