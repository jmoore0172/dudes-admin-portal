<?php
function shortcode_admin_archived_jobs( $atts ){
	global $the_dudes, $job_type, $device_type, $general_form_error_msg;
	ob_start();
	$jobs = db_query("SELECT * FROM JobInfo WHERE HideJob = 1 ORDER BY JobID DESC");
		
	if ($jobs && !empty($jobs)) {
		
		foreach($jobs as $job) {
			$customer = db_query("SELECT * FROM CustomerInfo WHERE CustomerID = ".$job['CustomerID']);
			$customer = $customer[0];
			?>
			<li>
				<a href="<?php echo get_bloginfo('url'); ?>/manage/jobs/edit/?job_id=<?php echo $job['JobID']; ?>">Edit</a> &mdash;
				<strong><?php echo $customer['CustomerName']; ?></strong> : <?php echo $job['JobType']; ?>
			</li>
		<?php }
		
		echo '</ul>';
	} else {
		echo '<p>No archived jobs found. <a href="'.get_bloginfo('url').'/manage/jobs/edit/">Edit a Job &gt;</a></p>';
	}
	return ob_get_clean();
}

add_shortcode( 'admin-archived-jobs', 'shortcode_admin_archived_jobs' );
?>