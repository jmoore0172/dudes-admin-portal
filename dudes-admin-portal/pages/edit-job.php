<?php
function shortcode_admin_edit_job_form( $atts ){
	global $the_dudes, $job_type, $device_type, $general_form_error_msg;
	ob_start();
	$submitted = isset($_REQUEST['job_id']);
	
	if (!$submitted) {
		$jobs = get_jobs('open');
		
		if ($jobs && !empty($jobs)) {
			echo '<ul>';
			
			foreach($jobs as $job) {
				$customer = get_customer($job['CustomerID']);
				?>
				<li>
					<a href="<?php echo get_bloginfo('url'); ?>/manage/jobs/edit/?job_id=<?php echo $job['JobID']; ?>">Edit</a> &nbsp;|&nbsp;
					<a href="<?php echo get_bloginfo('url'); ?>/manage/jobs/finish/?job_id=<?php echo $job['JobID']; ?>">Finish</a> &mdash;
					<strong><?php echo $customer['CustomerName']; ?></strong> : <?php echo $job['JobType']; ?>
				</li>
			<?php }
			
			echo '</ul>';
		} else {
			echo '<p>No open jobs found. <a href="'.get_bloginfo('url').'/manage/jobs/start/">Start a Job &gt;</a></p>';
		}
		
	} else {
	
		$job = get_jobs($_REQUEST['job_id']);
		
		if (!$job) {
			die('Job not found.');
		}
		
		if (!isset($_REQUEST['JobType'])) {
			$customer = get_customer($job['CustomerID']);
?>

<div class="Form-Handle">
	<h2>Editing Job for: <?php echo $customer['CustomerName']; ?></h2>
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