

<input type="button" value="Modify" class="<?php if($_REQUEST['task']=="edit_staff"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='staff_details.php?task=edit_staff&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;">

<input type="button" value="Staff Roster" class="<?php if($_REQUEST['task']=="staff_roster"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='staff_details.php?task=staff_roster&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;">

<input type="button" value="Staff Files" class="<?php if($_REQUEST['task']=="staff_docs"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='staff_details.php?task=staff_docs&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;">

<input type="button" value="Staff Post Code" class="<?php if($_REQUEST['task']=="staff_add_postcode"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='staff_details.php?task=staff_add_postcode&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;">

<input type="button" value="Staff Location" class="<?php if($_REQUEST['task']=="staff_location"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='staff_details.php?task=staff_location&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;">


<input type="button" value="Staff Invoice" class="<?php if($_REQUEST['task']=="staff_invoice"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='staff_details.php?task=staff_invoice&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;">


<input type="button" value="Cleaner Notes" class="<?php if($_REQUEST['task']=="staff_notes"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='staff_details.php?task=staff_notes&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;"/>


<input type="button" value="BBC Lead Setting" class="<?php if($_REQUEST['task']=="lead_setting"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='staff_details.php?task=lead_setting&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;"/>

<input type="button" value="Staff Review" class="<?php if($_REQUEST['task']=="staff_review"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='staff_details.php?task=staff_review&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;"/>

<!--<input type="button" value="Job Assigned" class="<?php if($_REQUEST['task']=="job_assigned"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='staff_details.php?task=job_assigned&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;"/>-->

<input type="button" value="Job Offered" class="<?php if($_REQUEST['task']=="job_offered_details"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='staff_details.php?task=job_offered_details&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;"/>

<input type="button" value="Staff Job Report" class="<?php if($_REQUEST['task']=="staff_job_report"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='staff_details.php?task=staff_job_report&page=1&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;"/>

<input type="button" value="Complaints Report" class="<?php if($_REQUEST['task']=="job_complaints_list"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='staff_details.php?task=job_complaints_list&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;"/>

<input type="button" value="Staff Activity" class="<?php if($_REQUEST['task']=="staff_activity"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='staff_details.php?task=staff_activity&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;"/>

<!---<input type="button" value="Sub Staff List" class="<?php if($_REQUEST['task']=="sub_staff_list"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='staff_details.php?task1=sub_staff_list&task=16&action=list&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;">-->
