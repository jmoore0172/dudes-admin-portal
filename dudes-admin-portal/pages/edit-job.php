<?php
function shortcode_admin_edit_job_form( $atts ){
	global $the_dudes, $job_type, $device_type, $general_form_error_msg;
	ob_start();
	
	if (!isset($_REQUEST['job_id'])) {
		$jobs = db_query("SELECT * FROM JobInfo WHERE EndDate IS NULL AND (HideJob <> '1' OR HideJob IS NULL) ORDER BY JobID DESC");
		
		if ($jobs && !empty($jobs)) {
			echo '<ul>';
			
			foreach($jobs as $job) {
				$customer = db_query("SELECT * FROM CustomerInfo WHERE CustomerID = ".$job['CustomerID']);
				$customer = $customer[0];
				?>
				<li>
					<a href="<?php echo get_bloginfo('url'); ?>/manage/jobs/edit/?job_id=<?php echo $job['JobID']; ?>">Edit</a> &nbsp;|&nbsp;
					<a href="<?php echo get_bloginfo('url'); ?>/manage/jobs/finish/?job_id=<?php echo $job['JobID']; ?>">Finish</a> &mdash;
					<strong><?php echo $customer['CustomerName']; ?></strong> : <?php echo $job['JobType']; ?>
				</li>
			<?php }
			
			echo '</ul>';
		}
		
	} else {
	
		$job = db_query("SELECT * FROM JobInfo WHERE JobID = ".$_REQUEST['job_id']);
		
		if (!isset($job) || empty($job)) {
			die('Job not found.');
		} else {
			$job = $job[0];
		}
		
		if (!isset($_REQUEST['JobType'])) {
			$customer = db_query("SELECT CustomerName FROM CustomerInfo WHERE CustomerID = ".$job['CustomerID']);
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
			$data = array(
				'JobType' 		=> $_REQUEST['JobType'],
				'DudeID' 		=> $_REQUEST['JobDude'],
				'DeviceType' 	=> $_REQUEST['DeviceType'],
				'HideJob'		=> isset($_REQUEST['HideJob']) ? $_REQUEST['HideJob'] : '0',
				'LastModifiedBy'=> get_current_user_id()
			);
			$result = db_update('JobInfo', $data, "JobID=".$_REQUEST['job_id']);
			
			if (isset($result)) { ?>
				<p>Job Edited Successfully.</p>
				<p>
					<a href="<?php echo get_bloginfo('url'); ?>/manage/jobs/edit/?job_id=<?php echo $_REQUEST['job_id']; ?>">Edit Job Again &gt;</a> &nbsp;
					<a href="<?php echo get_bloginfo('url'); ?>/manage/jobs/finish/?job_id=<?php echo $_REQUEST['job_id']; ?>">Finish Job &gt;</a> &nbsp;
					<a href="<?php echo get_bloginfo('url'); ?>/manage/jobs/edit/">Edit Other Jobs &gt;</a>
				</p>
			<?php } else {
				echo $general_form_error_msg;
			}
		}
		return ob_get_clean();
	}
}

add_shortcode( 'admin-edit-job-form', 'shortcode_admin_edit_job_form' );
?>