<?php
if ( isset($_POST['CustomerType']) ) {
    $filename = $_POST['CustomerType'];
    header("Location: http://.$filename"); 
}
?>