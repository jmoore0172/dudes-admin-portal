<?php
function shortcode_admin_finish_job_form( $atts ){
	global $the_dudes, $job_type, $device_type, $general_form_error_msg;
	ob_start();
	if (!isset($_REQUEST['job_id'])) {
		die('No Job ID specified.');
	}
	if (!isset($_REQUEST['JobStart'])) {
		$job = db_query('SELECT * FROM `JobInfo` WHERE JobID = \''.$_REQUEST['job_id'].'\'');
		$job = $job[0];
		$customer = db_query('SELECT * FROM `CustomerInfo` WHERE CustomerID = \''.$job['CustomerID'].'\'');
?>

<div class="Form-Handle">
	<h2>Finishing Job for: <?php echo $customer[0]['CustomerName']; ?></h2>
    <form action="" method="POST">
        <input type="hidden" value="<?php echo $_REQUEST['job_id']; ?>" />
        <p>
        	End Date: <input name="EndDate" type="text" class="datepicker" value="<?php echo date('Y-m-d'); ?>" />
        </p>
        <p>
        	Dude Rate: <input name="DudeRate" type="text" />
        </p>
        <p>
            <input type="submit" value="Finish Job" />
        </p>
    </form>
</div>

<?php
	} else {
		$sql = 'INSERT INTO `JobInfo` (CustomerID, JobType, StartDate, DudeID, DeviceType) VALUES (\''.$_REQUEST['customer_id'].'\', \''.$_REQUEST['JobType'].'\', \''.$_REQUEST['JobStart'].'\', \''.$_REQUEST['JobDude'].'\', \''.$_REQUEST['DeviceType'].'\')';
		
		$id = db_query($sql);
		
		if ($id) {
			echo '<p>Job Added Successfully.</p><p><a href="/manage/jobs/edit/?job_id='.$id.'">Edit Job &gt;</a> &nbsp; <a href="/manage/jobs/finish/?job_id='.$id.'">Finish Job &gt;</a></p>';
		} else {
			echo $general_form_error_msg;
		}

	}
	return ob_get_clean();
}

add_shortcode( 'admin-finish-job-form', 'shortcode_admin_finish_job_form' );
?>