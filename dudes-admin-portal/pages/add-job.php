<?php
function shortcode_admin_add_job_form( $atts ){
	ob_start();
?>
<div class="Form-Handle">
<form action="" method="POST">
  <p>Client ID<input type="text" name="ClientID">
  <p><input type="checkbox" name="JobStart" value="Today">&nbsp;Started Today</p>
  <p><input type="checkbox" name="JobFinish" value="Later">&nbsp;Finished Today</p>
    <p><select>
      <option value="SelectType">...Select Job Type</option>
      <option value="ComputerRepair">Computer Repair</option>
      <option value="ITSupport">IT Support</option>
      <option value="WebDesign">Web Design</option>
      <option value="Networking">Networking</option>
      <option value="Other">Other</option>
      <!--<option value=""></option> an extra for expansion-->
    </select></p>
    <p><select name="JobDude">
      <option value="">...Select Dude</option>
      <option value="JustinMoore">Justin Moore</option>
      <option value="JasonOsborne">Jason Osborne</option>
    </select></p>
    <p><select name="DeviceType">
      <option value="">...Select Configuration</option>
      <option value="Laptop-PC">Laptop-PC</option>
      <option value="Desktop-PC">Desktop-PC</option>
      <option value="Tablet">Tablet</option>
      <option value="Printer">Printer</option>
      <option value="Phone">Phone</option>
      <option value="Network">Network</option>
      <option value="Other">Other</option>
    </select></p>


  <!--<p>JobClient</p><input type="text" name="JobClient">-->


</form>
</div>



<?php
	return ob_get_clean();
}

add_shortcode( 'admin-add-job-form', 'shortcode_admin_add_job_form' );
?>