<style>
@charset "UTF-8";
#cssmenu {border:none;border:0px;margin:0px;padding:0px;font-family:verdana, geneva, arial, helvetica, sans-serif;font-size:14px;font-weight:bold;color:#8e8e8e;width:auto;}
#cssmenu > ul {margin-top: 6px !important;}
#cssmenu ul{height: 27px;list-style:none;margin:0;padding:0;}
#cssmenu ul ul{box-shadow: none;}
#cssmenu ul ul a{line-height: 43px;}
#cssmenu ul ul ul{left: -100%;top:0px;}
#cssmenu li{float:left;padding: 0px 3px 0px 3px;position:relative;}
#cssmenu li a{color:#fff;font-size:12px;display:block;line-height:30px;padding:0px 25px;text-align:center;
text-decoration:none;}
#cssmenu li a:hover {color:#000000;text-decoration:none;}
#cssmenu li ul {background:#00b8d4;display:none;height:auto;filter:alpha(opacity=95);opacity:0.95;
position:absolute;width:120px;z-index:200;top:100%;left:0;}
#cssmenu li:hover > ul {display: block;}
#cssmenu li li {display:block;float:none;padding:0px;position:relative;}
#cssmenu li ul a {display:block;font-size:10px;font-style:normal;padding:0px 10px 0px 15px;text-align: left;font-weight:300;}
#cssmenu li ul a:hover {color:#fff;text-decoration:underline;}
#cssmenu p {clear:left;}
#cssmenu .active > a {background: #a80329;-webkit-box-shadow: 0 -4px 0 #a80329, 0 -5px 0 #b81c40, 0 -6px 0 #a80329;-moz-box-shadow: 0 -4px 0 #a80329, 0 -5px 0 #b81c40, 0 -6px 0 #a80329;box-shadow:0 -4px 0 #a80329, 0 -5px 0 #b81c40, 0 -6px 0 #a80329;color: #ffffff;}
#cssmenu .active > a:hover {color:white;}
</style>

<div id='cssmenu'>
<ul>
<!--1. Quote Menu Start-->
<li>
<input type="button" value="Quote" class="<?php if($_REQUEST['task']=="edit_quote"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=edit_quote&job_id=<?php echo $_REQUEST['job_id']; ?>';" style="float:left;">
</li>
<!--Quote Menu End-->
<!--2. Job Details Menu Start-->
<li>
<input type="button" value="Job Details" class="<?php if($_REQUEST['task']=="jobs"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=jobs&job_id=<?php echo $_REQUEST['job_id']; ?>';" style="float:left;">
</li>
<!--Job Details Menu End--> 
<!--3. Job Type Menu Start-->
<li>
<input type="button" value="Job Types" class="<?php if($_REQUEST['task']=="job_type"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=job_type&job_id=<?php echo $_REQUEST['job_id']; ?>';" style="float:left;">
<?php //$jobStatus = getJob_Status($_REQUEST['job_id']);  
$checkValue = checkRecleanJob($_REQUEST['job_id']); ?>
</li>
<!--Job Type Menu End--> 
<!--4. Job Re-Clean Start--> 
<li>
<input type="button" id="reclean_tab" <?php if($checkValue > 0) { ?> style="float:left; margin-right:10px;background: #e49494cc;" <?php  }else { ?> style="float:left;" <?php  } ?> value="Job Re-Clean" <?php /* if($jobStatus != 5) { ?>  disabled="disabled" style="cursor:not-allowed; background: #a9c0c3;float:left; margin-right:10px;"<?php }else { ?> style="float:left; margin-right:10px;"  <?php  }  */?> class="<?php if($_REQUEST['task']=="job_reclean"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=job_reclean&job_id=<?php echo $_REQUEST['job_id']; ?>';" >
</li>
<!--Job Re-Clean End-->  
<!--5.Payment Start--> 
<li>
<input type="button" value="Payment" class="<?php if($_REQUEST['task']=="payment"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=payment&job_id=<?php echo $_REQUEST['job_id']; ?>';" style="float:left;">
</li>
<!--Payment End--> 
<!--6. Email Client Start--> 
<li>
<input type="button" value="Email Client" class="<?php if($_REQUEST['task']=="email"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=email&job_id=<?php echo $_REQUEST['job_id']; ?>';" style="float:left;">
</li>
<!--Email Client--> 
<!--7. Send SMS / Notification Start--> 
<li>
<input type="button" value="Send SMS / Notification" class="<?php if($_REQUEST['task']=="sms"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=sms&job_id=<?php echo $_REQUEST['job_id']; ?>';" style="float:left;">
</li>
<!--Send SMS / Notification End--> 
<!--8. View Invoice Start--> 
<li>
<input type="button" value="View Invoice" class="<?php if($_REQUEST['task']=="invoice"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=invoice&job_id=<?php echo $_REQUEST['job_id']; ?>';" style="float:left;">
</li>
<!--View Invoice End--> 
<!--9. View Emails Start--> 
<li>
<input type="button" value="View Emails" class="<?php if($_REQUEST['task']=="view_job_emails"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=view_job_emails&job_id=<?php echo $_REQUEST['job_id']; ?>';" style="float:left;">
</li>
<!--View Emails End--> 
<!--10. Upload Image Start--> 
<li>
<input type="button" value="Upload Image" class="<?php if($_REQUEST['task']=="Image"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=Image&job_id=<?php echo $_REQUEST['job_id']; ?>';" style="float:left;">
</li>
<!--Upload Image End--> 
<!--11. Client Signature Start--> 

	<li>
		<?php 
		$checkquotetype  = checkQuoteType($_REQUEST['job_id']);
		if($checkquotetype > 0) {
		$signatureImg = checkSignatureImg($_REQUEST['job_id']);
		?>
		<input type="button" value="Client Signature" class="<?php if($_REQUEST['task']=="staff_signature"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=staff_signature&job_id=<?php echo $_REQUEST['job_id']; ?>';" <?php   if($signatureImg > 0) { ?> style="float:left;background: #e49494cc;" <?php  } else { ?> style="float:left;"  <?php  }  ?>   >
		<?php  }  //else { $totalImage  = checkStaffUploadedImage($_REQUEST['job_id']);  ?>
	</li>
<!--Client Signature End--> 
<!--12. Staff work image Start--> 
<li class='has-sub'>
<input type="button" value="Staff work image" class="<?php if($_REQUEST['task']=="staff_work_image"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?> openClientImage cimageShow" onclick="javascript:window.location='popup.php?task=staff_work_image&img_type=before&imgtype=1&jobstatus=job&job_id=<?php echo $_REQUEST['job_id']; ?>';" <?php  if($totalImage > 0) { ?> style="float:left; margin-right:10px;background: #e49494cc;display:inline-block" <?php  } else { ?> style="float:left;display:inline-block"  <?php  } ?> >
<ul>
<li class='has-sub'>
<a href="popup.php?task=staff_work_image&img_type=before&imgtype=1&jobstatus=job&job_id=<?php echo $_REQUEST['job_id']; ?>" class="getsubcat">Active</a>
<ul>
<li>
<a href="popup.php?task=staff_work_image&img_type=before&imgtype=1&jobstatus=job&job_id=<?php echo $_REQUEST['job_id']; ?>">Before</a>
</li>
<li>
<a href="popup.php?task=staff_work_image&img_type=after&imgtype=2&jobstatus=job&job_id=<?php echo $_REQUEST['job_id']; ?>">After</a>
</li>
<li>
<a href="popup.php?task=staff_work_image&img_type=checklist&imgtype=3&jobstatus=job&job_id=<?php echo $_REQUEST['job_id']; ?>">Checklist</a>
</li>
<li>
<a href="popup.php?task=staff_work_image&img_type=no_gurantee&imgtype=4&jobstatus=job&job_id=<?php echo $_REQUEST['job_id']; ?>">Guarantee</a>
</li>
<li class='last'>
<a href="popup.php?task=staff_work_image&img_type=upsell&imgtype=5&jobstatus=job&job_id=<?php echo $_REQUEST['job_id']; ?>">Upsell</a>
</li>
</ul>
</li>
<li class='has-sub'>
<a href="popup.php?task=staff_work_image&img_type=before&imgtype=1&jobstatus=reclean&job_id=<?php echo $_REQUEST['job_id']; ?>" class="getsubcat_2">Re-Clean</a>
<ul>
<li>
<a href="popup.php?task=staff_work_image&img_type=before&imgtype=1&jobstatus=reclean&job_id=<?php echo $_REQUEST['job_id']; ?>">Before</a>
</li>
<li>
<a href="popup.php?task=staff_work_image&img_type=after&imgtype=2&jobstatus=reclean&job_id=<?php echo $_REQUEST['job_id']; ?>">After</a>
</li>
<li class='last'>
<a href="popup.php?task=staff_work_image&img_type=checklist&imgtype=3&jobstatus=reclean&job_id=<?php echo $_REQUEST['job_id']; ?>">Checklist</a>
</li>
</ul>
</li>
</ul>
</li>
<?php // } ?>	
<!--Staff work image End--> 
<!--13. Client Site Image Start--> 
<?php  
    $clientimg =  CheckClientimg($_REQUEST['job_id']);
 ?>
<li class='has-sub'>
<input type="button" value="Client Image" class="<?php if($_REQUEST['task']=="client_site_image"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?> openClientImage_1 cimageShow" onclick="javascript:window.location='popup.php?task=client_site_image&img_type=before&imgtype=1&jobstatus=job&job_id=<?php echo $_REQUEST['job_id']; ?>';" <?php   if($clientimg > 0) { ?> style="float:left; margin-right:10px;background: #e49494cc;display:inline-block" <?php  } else {  ?> style="float:left; margin-right:10px;display:inline-block"  <?php  } ?> >
<ul>
<li class='has-sub'>
<a href="popup.php?task=client_site_image&img_type=before&imgtype=1&jobstatus=job&job_id=<?php echo $_REQUEST['job_id']; ?>" class="getsubcat_1">Active</a>
<ul>
<li>
<a href="popup.php?task=client_site_image&img_type=before&imgtype=1&jobstatus=job&job_id=<?php echo $_REQUEST['job_id']; ?>">Before</a>
</li>
<li class='last'>
<a href="popup.php?task=client_site_image&img_type=after&imgtype=2&jobstatus=job&job_id=<?php echo $_REQUEST['job_id']; ?>">After</a>
</li>
</ul>
</li>
<li class='has-sub'>
<a href="popup.php?task=client_site_image&img_type=before&imgtype=1&jobstatus=reclean&job_id=<?php echo $_REQUEST['job_id']; ?>" class="getsubcat_22">Re-Clean</a>
<ul>
<li>
<a href="popup.php?task=client_site_image&img_type=before&imgtype=1&jobstatus=reclean&job_id=<?php echo $_REQUEST['job_id']; ?>">Before</a>
</li>
<li class='last'>
<a href="popup.php?task=client_site_image&img_type=after&imgtype=2&jobstatus=reclean&job_id=<?php echo $_REQUEST['job_id']; ?>">After</a>
</li>
</ul>
</li>
</ul>
</li>
<!--Client Site Image End--> 
<!--14.Client Images Start--> 
<li>
<input type="button" value="Email Client Images" class="<?php if($_REQUEST['task']=="client_image"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=client_image&job_id=<?php echo $_REQUEST['job_id']; ?>';" style="float:left; margin-right:10px;">
</li>
<!--Client Images End--> 
<!--15. Cleaner Notes Start--> 
<li>
<input type="button" value="Cleaner Notes" class="<?php if($_REQUEST['task']=="cleaner_notes"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=cleaner_notes&job_id=<?php echo $_REQUEST['job_id']; ?>';" style="float:left; margin-right:10px;">
</li>
<!--Cleaner Notes End--> 
<!--16. Full Comm Start--> 
<li>
<input type="button" value="Full Comm" class="<?php if($_REQUEST['task']=="full_communication"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=full_communication&job_id=<?php echo $_REQUEST['job_id']; ?>';" style="float:left; margin-right:10px;">
</li>
<!--Full Comm End--> 
<!--17. Client Review Start--> 
<li>
<?php  if(checkReviewEmails($_REQUEST['job_id']) > 0) { ?>
<input type="button" value="Client Review" class="<?php if($_REQUEST['task']=="review"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=review&type=1&job_id=<?php echo $_REQUEST['job_id']; ?>';" style="float:left; margin-right:10px;">
<?php  } ?>
</li>
<!--Client Review End--> 
<!--18. Admin fault Notes Start--> 
<li>
<? //if(in_array($_SESSION['admin'] , array(3,17,12))) { ?>
<input type="button" value="Admin fault Notes" class="<?php if($_REQUEST['task']=="admin_fault_notes"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=admin_fault_notes&job_id=<?php echo $_REQUEST['job_id']; ?>';" style="float:left; margin-right:10px;">
<?php  //} ?>
</li>

	<li>
	   <input type="button" value="Assign History" class="<?php if($_REQUEST['task']=="assign_hitory"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=assign_hitory&job_id=<?php echo $_REQUEST['job_id']; ?>';" style="float:left; margin-right:10px;">
	</li>
	
	<li>
	   <input type="button" value="View Checklist" class="<?php if($_REQUEST['task']=="view_checklist"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=view_checklist&job_id=<?php echo $_REQUEST['job_id']; ?>';" style="float:left; margin-right:10px;">
	</li>
	
		<li>
	   <input type="button" value="Task History" class="<?php if($_REQUEST['task']=="task_history"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='popup.php?task=task_history&job_id=<?php echo $_REQUEST['job_id']; ?>';" style="float:left; margin-right:10px;">
	</li>

<!--Admin fault Notes End--> 
</ul>
</div>