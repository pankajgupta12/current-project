<?php 

    
	$staff_notification= "select * from site_notifications where notifications_status = '0' AND  app_id != ''  ORDER BY id desc "; 
	
	
	
	//echo $notification; 
	$staff_notificationText = mysql_query($staff_notification);

	$staffcountnotef = mysql_num_rows($staff_notificationText);
 
?>
<div class="modal-content bd_noti_pop"> 
<div class="container-refresh "><a class="reload" href="#" onClick="send_data('','557','myModal');"> <img class="image" src="images/refresh.png"/> </a></div>
 <p class="noti_head">Application Notification<?php if($staffcountnotef>0) {  ?><span class="new-notification" id="notification_count"> <?php echo $staffcountnotef; ?></span><?php  } ?></p>

   
<div class="tab1">
   <div class="bd_noti_quote">
     <div class="tabs-wrapper">
		<input type="radio" name="tab" id="tab1" class="tab-head" checked="checked"/>
		<!--<label for="tab1">Quote</label>
		<input type="radio" name="tab" id="tab2" class="tab-head" />
		<label for="tab2">Job</label>-->
		
		<div class="tab-body-wrapper">
			<div id="tab-body-1" class="tab-body">
				
				<p> <div class="bd_quote_list scrollbar" id="style-5">
					<ul class="qulist1">
						 <?php if(mysql_num_rows($staff_notificationText)>0) { 

					while($data_n = mysql_fetch_assoc($staff_notificationText)) {
						//print_r($data_n);
						//job_details_show1('5366|2869','quote_notification_1')
						 ?>
								<li class="quote_notification latest " id="remove_notification_<?php echo $data_n['id'];  ?>" style="cursor: pointer;"><span class="bd_list_border">
								
									<span class="red">
									  <?php if($data_n['app_id'] != 0) { ?>
										 <a class="callUrgent" style="color:#FFF;" >
										 Appl#<?php echo $data_n['app_id'];  ?><i class="fa fa-job" aria-hidden="true"></i>
										 </a>
									 
									  <?php  } ?>
								   </span>
							   
									<span onClick="send_data('<?php echo $data_n['id']; ?>','217','site_notification')" class="hideIt">X</span>
									<p class="offsetRight"><?php  echo changeDateFormate($data_n['date'],'datetime'); ?></p><br> <b><?php echo ucfirst($data_n['heading']); ?></b></span>
								</li>
						 <?php  } }else {	?>	
							<li class="quote_notification"  id="quote_notification"   style="cursor: pointer;"><span class="bd_list_border<?php // echo $j; ?>"><span class="red"></span><p></p><br> <b>No  Notification</li>	
						 <?php   } ?> 
			       </ul>
              </div></p>
			</div>
		 </div>
	    </div>
	</div>
</div>
</div>

