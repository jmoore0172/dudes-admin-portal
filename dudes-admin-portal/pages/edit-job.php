<?php
function shortcode_admin_edit_job_form( $atts ){
	ob_start();
	
	if (!isset($_REQUEST['job_id'])) {
		die('Error: No Job ID specified.');
	} else {
	
		$job = db_query('SELECT * FROM `JobInfo` WHERE JobID = \''.$_REQUEST['job_id'].'\'');
		
		if (!isset($job) || empty($job)) {
			die('Job not found.');
		} else {
			$job = $job[0];
		}
		
		if (!isset($_REQUEST['JobType'])) {
			$customer = db_query('SELECT CustomerName FROM `CustomerInfo` WHERE CustomerID = \''.$job['CustomerID'].'\'');
?>

<div class="Form-Handle">
	<h2>Editing Job for: <?php echo $customer[0]['CustomerName']; ?></h2>
    <form action="" method="POST">
        <?php include('includes/form-job.php'); ?>
        <p>
            <input type="submit" value="Save Job" />
        </p>
    </form>
</div>

<?php
		} else {
			$sql = 'UPDATE `JobInfo` SET JobType=\''.$_REQUEST['JobType'].'\', DudeID=\''.$_REQUEST['JobDude'].'\', DeviceType=\''.$_REQUEST['DeviceType'].'\' WHERE JobID='.$job['JobID'];
			$id = db_query($sql);
			
			if (isset($id)) {
				echo '<p>Job Edited Successfully.</p><p><a href="/manage/jobs/edit/?job_id='.$_REQUEST['job_id'].'">Edit Job Again &gt;</a> &nbsp; <a href="/manage/jobs/finish/?job_id='.$_REQUEST['job_id'].'">Finish Job &gt;</a></p>';
			} else {
				echo '<p>WTF Mate, fill out form correctly.</p>';
			}
		}
		return ob_get_clean();
	}
}

add_shortcode( 'admin-edit-job-form', 'shortcode_admin_edit_job_form' );
?>