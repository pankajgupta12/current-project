

<input type="button" value="Modify" class="<?php if($_REQUEST['task']=="edit_real_estate"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='real_staff_details.php?task=edit_real_estate&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;">



<input type="button" value="Docs Files" class="<?php if($_REQUEST['task']=="real_estate_docs"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='real_staff_details.php?task=real_estate_docs&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;">

<input type="button" value="Payment Details" class="<?php if($_REQUEST['task']=="real_estate_payment"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='real_staff_details.php?task=real_estate_payment&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;">

