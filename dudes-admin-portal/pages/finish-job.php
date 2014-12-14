<?php
function shortcode_admin_finish_job_form( $atts ){
	global $the_dudes, $job_type, $device_type, $general_form_error_msg;
	ob_start();
	$submitted = !empty($_POST);
	
	if (!isset($_REQUEST['job_id'])) {
		echo '<script>window.location.href = "'.get_bloginfo('url').'/manage/jobs/edit'.'";</script>';
		
	} elseif (!$submitted) {
		$job = get_jobs($_REQUEST['job_id']);
		$customer = get_customer($job['CustomerID']);
		foreach($the_dudes as $dude) {
			if ($job['DudeID'] == $dude['wordpress_id']) {
				$this_dude = $dude;
				break;
			}
		}
		
?>
<div class="Form-Handle">
	<h2>Finishing Job for: <?php echo $customer['CustomerName']; ?></h2>
	<h3>The Dude: <?php echo $this_dude['name']; ?></h3>
    <form action="" method="POST">
        <input type="hidden" value="<?php echo $_REQUEST['job_id']; ?>" name="JobID" />
        <p>
        	End Date: <input name="EndDate" type="text" class="datepicker" value="<?php echo date('Y-m-d'); ?>" />
        </p>
        <p>
        	Dude Rate ($/hour): <input type="text" value="<?php echo $this_dude['rate']; ?>" disabled="disabled" />
        						<input name="DudeRate" type="hidden" value="<?php echo $this_dude['rate']; ?>" />
        </p>
        <p>
        	Hours on the Job: <input name="JobHours" type="text" />
        </p>
        <p>
        	Job Notes (visible to client): <textarea name="JobNotes"></textarea>
        </p>
        <p>
        	Job Notes (private): <textarea name="JobNotesPriv"></textarea>
        </p>
        <p>
            <input type="submit" value="Finish Job" />
        </p>
    </form>
</div>

<?php
	} else {
		
		if (isset($_REQUEST['EndDate'])) {
			$data = array(
				'EndDate'		=> $_REQUEST['EndDate'],
				'DudeRate'		=> floatval($_REQUEST['DudeRate']),
				'InvoiceRate'	=> floatval($the_dudes[0]['rate']),
				'JobHours'		=> floatval($_REQUEST['JobHours']),
				'DudeTotal'		=> floatval($_REQUEST['DudeRate']) * floatval($_REQUEST['JobHours']),
				'InvoiceTotal'	=> floatval($the_dudes[0]['rate']) * floatval($_REQUEST['JobHours']),
				'JobNotes'		=> $_REQUEST['JobNotes'],
				'JobNotesPriv'	=> $_REQUEST['JobNotesPriv'],
				'LastModifiedBy'=> get_current_user_id()
			);
			
			if ( db_update('JobInfo', $data, "JobID=".$_REQUEST['job_id']) ) {
				echo '<p>Job Finished Successfully.</p>';
			} else {
				echo $general_form_error_msg;
			}
		} else {
			echo $general_form_error_msg;
		}
	}
	return ob_get_clean();
}

add_shortcode( 'admin-finish-job-form', 'shortcode_admin_finish_job_form' );
?>