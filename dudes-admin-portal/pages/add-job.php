<?php
function shortcode_admin_add_job_form( $atts ){
	ob_start();
	if (!isset($_REQUEST['JobStart'])) {
		$customer = db_query('SELECT CustomerName FROM `CustomerInfo` WHERE CustomerID = \''.$_REQUEST['customer_id'].'\'');
?>

<div class="Form-Handle">
	<h2>Adding Job for: <?php echo $customer[0]['CustomerName']; ?></h2>
    <form action="" method="POST">
        <?php $adding_job = true; include('includes/form-job.php'); ?>
        <p>
            <input type="submit" value="Add Job" />
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
			echo '<p>WTF Mate, fill out form correctly.</p>';
		}

	}
	return ob_get_clean();
}

add_shortcode( 'admin-add-job-form', 'shortcode_admin_add_job_form' );
?>