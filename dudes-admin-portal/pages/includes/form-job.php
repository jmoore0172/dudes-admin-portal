<?php if (isset($adding_job)) : ?>
<p>Job Start Date
    <input type="text" name="JobStart" class="datepicker" value="<?php echo date('Y-m-d'); ?>">
</p>
<?php elseif (isset($job['StartDate'])):
	echo'<h3>Start Date: '.$job['StartDate'].'</h3>';
endif;

$job_type=array(
	"Computer Repair",
	"IT Support",
	"Web Design",
	"Networking",
	"Other"
);

$device_type = array(
	"Laptop-PC",
    "Desktop-PC",
    "Tablet",
    "Printer",
    "Phone",
    "Network",
    "Other"
);
?>
<p>Job Type:
    <select name="JobType">
        <option value="NULL">(Select)</option>
        
        <?php foreach($job_type as $type) : ?>
			<option<?php echo form_selected_state($job['JobType'], $type); ?>><?php echo $type; ?></option>
        <?php endforeach; ?>
    </select>
</p>
<p>Dude:
    <select name="JobDude">
        <option value="NULL">(Select)</option>
        <option value="1"<?php echo form_selected_state($job['DudeID'], 1); ?>>Justin Moore</option>
        <option value="2"<?php echo form_selected_state($job['DudeID'], 2); ?>>Jason Osborne</option>
    </select>
</p>
<p>Device Type:
    <select name="DeviceType">
        <option value="NULL">(Select)</option>
        <?php foreach($device_type as $type) : ?>
			<option<?php echo form_selected_state($job['DeviceType'], $type); ?>><?php echo $type; ?></option>
        <?php endforeach; ?>
    </select>
</p>