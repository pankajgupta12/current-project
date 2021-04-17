

<input type="button" value="App Details" class="<?php if($_REQUEST['task']=="appl"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='application_popup.php?task=appl&appl_id=<?php echo $_REQUEST['appl_id']; ?>';" style="float:left; margin-right:10px;">

<input type="button" value="Doc Upload" class="<?php if($_REQUEST['task']=="doc_upload"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='application_popup.php?task=doc_upload&appl_id=<?php echo $_REQUEST['appl_id']; ?>';" style="float:left; margin-right:10px;">

<input type="button" value="Appl Notes" class="<?php if($_REQUEST['task']=="appl_notes"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='application_popup.php?task=appl_notes&appl_id=<?php echo $_REQUEST['appl_id']; ?>';" style="float:left; margin-right:10px;">


<input type="button" value="Document File" class="<?php if($_REQUEST['task']=="application_doc_file"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='application_popup.php?task=application_doc_file&appl_id=<?php echo $_REQUEST['appl_id']; ?>';" style="float:left; margin-right:10px;">

<?php  

$sql1 =   mysql_query("SELECT * FROM `staff` WHERE application_id =".$_GET['appl_id']);
$Countresult1 = mysql_num_rows($sql1);

$applicationStatus = get_rs_value("staff_applications","step_status",$_GET['appl_id']);
//echo $applicationStatus;
if($applicationStatus == 5) {
?>
<input type="button" value="<?php  if($Countresult1 == 1) { ?> Staff Added<?php  }else {  echo "Add Staff"; }?>"  class="<?php if($_REQUEST['task']=="add_new_staff"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='application_popup.php?task=add_new_staff&appl_id=<?php echo $_REQUEST['appl_id']; ?>';" style="float:left; margin-right:10px;">

<?php  } ?>

<input type="button" value="Emails" class="<?php if($_REQUEST['task']=="email"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='application_popup.php?task=email&appl_id=<?php echo $_REQUEST['appl_id']; ?>';" style="float:left; margin-right:10px;">
