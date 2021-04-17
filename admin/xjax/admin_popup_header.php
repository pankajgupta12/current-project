

<input type="button" value="Admin" class="<?php if($_REQUEST['task']=="edit_admin"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='admin_popup.php?task=edit_admin&action=modify&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;">

<!--<input type="button" value="Weekly Working " class="<?php if($_REQUEST['task']=="weekly_working"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='admin_popup.php?task=weekly_working&action=modify&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;">-->

<input type="button" value="Weekly Working " class="<?php if($_REQUEST['task']=="weekly_upcoming_work"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='admin_popup.php?task=weekly_upcoming_work&action=modify&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;">


<input type="button" value="Admin Fault Notes" class="<?php if($_REQUEST['task']=="admin_fault_notes_list"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='admin_popup.php?task=admin_fault_notes_list&action=modify&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;">

<input type="button" value="Admin Roster " class="<?php if($_REQUEST['task']=="admin_roster"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='admin_popup.php?task=admin_roster&action=modify&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;">

<input type="button" value="Staff Attendance" class="<?php if($_REQUEST['task']=="staff_attendance"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='admin_popup.php?task=staff_attendance&action=modify&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;">

