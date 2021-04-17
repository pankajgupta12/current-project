<input type="button" value="BR Quote" class="<?php if($_REQUEST['task']=="br_quote"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='view_br_quote.php?task=br_quote&quote_id=<?php echo $_REQUEST['quote_id']; ?>';" style="float:left; margin-right:10px;">

<input type="button" value="Inventory Notes" class="<?php if($_REQUEST['task']=="inventory_details_notes"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='view_br_quote.php?task=inventory_details_notes&quote_id=<?php echo $_REQUEST['quote_id']; ?>';" style="float:left; margin-right:10px;">

<input type="button" value="Inventory Chart list" class="<?php if($_REQUEST['task']=="inventory_chart_list"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='view_br_quote.php?task=inventory_chart_list&quote_id=<?php echo $_REQUEST['quote_id']; ?>';" style="float:left; margin-right:10px;">

<?php  
$booking_id = get_rs_value("quote_new","booking_id",$_REQUEST['quote_id']);
 if($booking_id != 0) {
?>
<input type="button" value="Job Details" class="<?php if($_REQUEST['task']=="inventory_details_notes"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=jobs&job_id=<?php echo $booking_id; ?>';" style="float:left; margin-right:10px;">
<?php  } ?>