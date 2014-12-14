<?php
function shortcode_admin_finished_jobs( $atts ){
	global $the_dudes, $job_type, $device_type, $general_form_error_msg;
	ob_start();
	$jobs = get_jobs('finished');
		
	if ($jobs && !empty($jobs)) {
		
		foreach($jobs as $job) {
			$customer = get_customer($job['CustomerID']); ?>
			<li>
				<a href="<?php echo get_bloginfo('url'); ?>/manage/jobs/view/?job_id=<?php echo $job['JobID']; ?>">View</a> &mdash;
				<strong><?php echo $customer['CustomerName']; ?></strong> : <?php echo $job['JobType']; ?>
			</li>
		<?php }
		
		echo '</ul>';
	} else {
		echo '<p>No finished jobs found. <a href="'.get_bloginfo('url').'/manage/jobs/start/">Start a Job &gt;</a></p>';
	}
	return ob_get_clean();
}

add_shortcode( 'admin-finished-jobs', 'shortcode_admin_finished_jobs' );
?>