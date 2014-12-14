<?php if (isset($adding_job)) : ?>
<p>Job Start Date
    <input type="text" name="JobStart" class="datepicker" value="<?php echo date('Y-m-d'); ?>" />
</p>
<?php elseif (isset($job['StartDate'])):
	echo'<h3>Start Date: '.$job['StartDate'].'</h3>';
endif;
?>
<p>Job Type:
    <select name="JobType">
        <option value="NULL">(Select)</option>
        
        <?php foreach($job_type as $type) : ?>
			<option<?php echo isset($job) ? form_selected_state($job['JobType'], $type) : ''; ?>><?php echo $type; ?></option>
        <?php endforeach; ?>
    </select>
</p>
<p>Dude:
    <select name="JobDude">
        <option value="NULL">(Select)</option>
        <?php foreach($the_dudes as $dude) : ?>
	        <option value="<?php echo $dude['wordpress_id']; ?>"<?php echo isset($job) ? form_selected_state($job['DudeID'], $dude['wordpress_id']) : ''; ?>><?php echo $dude['name']; ?></option>
        <?php endforeach; ?>
    </select>
</p>
<p>Device Type:
    <select name="DeviceType">
        <option value="NULL">(Select)</option>
        <?php foreach($device_type as $type) : ?>
			<option<?php echo isset($job) ? form_selected_state($job['DeviceType'], $type) : ''; ?>><?php echo $type; ?></option>
        <?php endforeach; ?>
    </select>
</p>

<?php if (!isset($adding_job)) : ?>
<p>
	<label><input type="checkbox" name="HideJob" value="1" <?php if ($job['HideJob'] == 1) { echo ' checked="checked"'; } ?> /> Hide Job</label>
</p>
<?php endif; ?>