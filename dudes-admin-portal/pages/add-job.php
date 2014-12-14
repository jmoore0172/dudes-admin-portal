<?php
function shortcode_admin_add_job_form( $atts ){
	ob_start();
	if (!isset($_REQUEST['JobStart'])) {
?>

<div class="Form-Handle">
    <form action="" method="POST">
        <p>Job Start Date
            <input type="text" name="JobStart" class="datepicker" value="<?php echo date('Y-m-d'); ?>">
        </p>
        <p>Job Type:
            <select name="JobType">
                <option value="NULL">(Select)</option>
                <option>Computer Repair</option>
                <option>IT Support</option>
                <option>Web Design</option>
                <option>Networking</option>
                <option>Other</option>
            </select>
        </p>
        <p>Dude:
            <select name="JobDude">
                <option value="NULL">(Select)</option>
                <option value="1">Justin Moore</option>
                <option value="2">Jason Osborne</option>
            </select>
        </p>
        <p>Device Type:
            <select name="DeviceType">
                <option value="NULL">(Select)</option>
                <option>Laptop-PC</option>
                <option>Desktop-PC</option>
                <option>Tablet</option>
                <option>Printer</option>
                <option>Phone</option>
                <option>Network</option>
                <option>Other</option>
            </select>
        </p>
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
			echo '<p>Job Added</p>';
		} else {
			echo '<p>WTF Mate, fill out form correctly.</p>';
		}

	}
	return ob_get_clean();
}

add_shortcode( 'admin-add-job-form', 'shortcode_admin_add_job_form' );
?>