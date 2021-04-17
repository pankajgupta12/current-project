<?php 

       $getdatainf=  GetAlownotification();

    $str = '5,6 ';
	if(in_array($_SESSION['admin'] , $getdatainf)) {
     $str = '5,6,7 ,8';
    }
	$staff_notification= "select * from site_notifications where notifications_status = '0'  AND notifications_type IN (".$str.") ORDER BY p_order asc "; 
	
	
	// $rolemanag = get_rs_value("admin","auto_role",$_SESSION['admin']);
	 
	//echo $notification; 
	$staff_notificationText = mysql_query($staff_notification);

	$staffcountnotef = mysql_num_rows($staff_notificationText);
 
?>
<div class="modal-content bd_noti_pop"> 
<div class="container-refresh "><a class="reload" href="#" onClick="send_data('2','216','site_notification');"> <img class="image" src="images/refresh.png"/> </a></div>
 <p class="noti_head">Urgent Notification<?php if($staffcountnotef>0) {  ?><span class="new-notification" id="notification_count"> <?php echo $staffcountnotef; ?></span><?php  } ?></p>

   
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
								    <?php if($data_n['staff_id'] != 0) { ?>
										 <a class="callUrgent" style="color:#FFF;" href="tel:<? echo get_rs_value("staff","mobile",$data_n['staff_id']); ?>">
										 <? echo get_rs_value("staff","name",$data_n['staff_id']); ?><i class="fa fa-phone" aria-hidden="true"></i>
										 </a>
								    <?php  }elseif($data_n['job_id'] != 0 && $data_n['staff_id'] == 0 ){ ?>
								    <a class="callUrgent" style="color:#FFF;" href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $data_n['job_id'];  ?>','1200','850')">
								     Job#<?php echo $data_n['job_id'];  ?><i class="fa fa-job" aria-hidden="true"></i>
									 </a>
								    <?php  }elseif($data_n['quote_id'] != 0){ ?>
								    <a class="callUrgent" style="color:#FFF;" onclick="quote_details_show('<?php echo $data_n['id'].'|'.$data_n['quote_id']; ?>','remove_notification_<?php echo $i; ?>');">
								     Quote#<?php echo $data_n['quote_id'];  ?><i class="fa fa-job" aria-hidden="true"></i>
									 </a>
								    <?php  }elseif($data_n['notifications_type'] == 5 && $data_n['quote_id'] != 0){ ?>
										<a class="callUrgent" style="color:#FFF;" onclick="quote_details_show('<?php echo $data_n['id'].'|'.$data_n['quote_id']; ?>','remove_notification_<?php echo $i; ?>');">
										 Quote#<?php echo $data_n['quote_id'];  ?><i class="fa fa-job" aria-hidden="true"></i>
										 </a>
								    <?php  } ?>
                                </span>
								
								<?php if(in_array($_SESSION['admin'] , $getdatainf)) { ?>
								<span>
								 <?php 
								 echo create_dd("login_id","admin","id","name"," status = 1 AND is_call_allow = 1","onchange=\"javascript:edit_field(this,'site_notifications.login_id','".$data_n['id']."')\"",$data_n,'field_id');
								 
								 $from =  get_rs_value("admin","name",$data_n['task_from']);
								 
								 ?>
								</span>
								
								<span class="formUser"><p style="margin-right: 22px;"><?php // if($data_n['task_complete_date'] != "0000-00-00 00:00:00") { echo  changeDateFormate($data_n['task_complete_date'],'dm'); } ?>  ( <?php  echo getSystemDDname($data_n['message_status'], 135); ?> ) </p> </span>
								
								<span onClick="send_data('<?php echo $data_n['id']; ?>','217','remove_notification_<?php echo $data_n['id']; ?>')" class="hideIt">X</span>
								
					          <?php  } ?>
							  
									<p class="offsetRight"><?php  echo changeDateFormate($data_n['date'],'datetime'); ?></p><br> <b><?php echo ucfirst($data_n['heading']); ?></b></span>
								</li>
						    <?php  } }else {	?>	
							<li class="quote_notification"  id="quote_notification"   style="cursor: pointer;"><span class="bd_list_border<?php // echo $j; ?>"><span class="red"></span><p></p><br> <b>No urgent messages</li>	
							<?php  } ?> 
			       </ul>
              </div></p>
			</div>
		 </div>
	    </div>
	</div>
</div>
</div>

