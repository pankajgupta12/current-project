<?php 

    $str = '1,8';
	//$comlt_date = date('Y-m-d' , strtotime('-1 day'));
	//$staff_notification= ( "select * from site_notifications where notifications_status = '0' AND ( task_manage_id = ".$_SESSION['admin']." OR login_id = ".$_SESSION['admin']." )  AND notifications_type in (1,8) AND ( task_complete_date= '0000-00-00 00:00:00' OR  DATE(task_complete_date) >= '".$comlt_date."' ) " ); 
	$staff_notification= ( "select * from site_notifications where notifications_status = '0' AND ( task_manage_id = ".$_SESSION['admin']." OR login_id = ".$_SESSION['admin']." ) AND message_status != 3  AND notifications_type in (1,8) Order by p_order asc"  ); 


	//echo $notification; 
	$staff_notificationText = mysql_query($staff_notification);

	$staffcountnotef = mysql_num_rows($staff_notificationText);
 
?>
<div class="modal-content bd_noti_pop"> 
<div class="container-refresh "><a class="reload" href="#" onClick="send_data('2','570','site_notification');"> <img class="image" src="images/refresh.png"/> </a></div>
 <p class="noti_head">Personal Notification<?php if($staffcountnotef>0) {  ?><span class="new-notification" id="notification_count"> <?php echo $staffcountnotef; ?></span><?php  } ?></p>
 
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
					<ul class="qulist1 ">
						 <?php 
						 
						 $color_class = array(1=>'ordering_red',2=>'ordering_dark_org',3=>'ordering_org',4=>'ordering_light_org',5=>'ordering_yellow_black');
						 
						 if(mysql_num_rows($staff_notificationText)>0) { 



					while($data_n = mysql_fetch_assoc($staff_notificationText)) {
					    
						 ?>
								<li class="quote_notification  <?php  if($data_n['task_type'] == 2 && $data_n['is_urgent'] == 1){  echo 'latest'; } ?> <?php echo $color_class[$data_n['p_order']]; ?>" id="remove_notification_<?php echo $data_n['id'];  ?>" style="cursor: pointer;"><span class="bd_list_border">
								
								<span class="red">
								  <?php if($data_n['email_id'] != 0) { 
								  
								   if($data_n['quote_id'] > 0) {
									 
									   $val =   'Q#'.$data_n['quote_id']; 
									   $argid = $data_n['quote_id'];
									}elseif($data_n['email_id'] > 0){
										$val = 'E#'.$data_n['email_id']; 
										 $argid = $data_n['email_id'];
									}
								  
								  ?>
								     <a class="callUrgent" style="color:#FFF;"  target="_blank" href="../mail/index.php?task=bcic_email&emails_noti_id=<?php echo base64_encode($argid);  ?>">
								     <?php 
									 
									echo $val;
									
									 ?><i class="fa fa-phone" aria-hidden="true"></i>
									 </a>
								  <?php  }elseif($data_n['quote_id'] != 0 && $data_n['email_id'] == 0 && $data_n['task_type'] != 2){ ?>
								    <a class="callUrgent" style="color:#FFF;" onclick="quote_details_show('<?php echo $data_n['id'].'|'.$data_n['quote_id']; ?>','remove_notification_<?php echo $i; ?>');">
								     Quote#<?php echo $data_n['quote_id'];  ?><i class="fa fa-job" aria-hidden="true"></i>
									 </a>
								  <?php  }  elseif($data_n['job_id'] != 0 && $data_n['task_type'] != 2 ){ ?>
								    <a  class="callUrgent" style="color:#FFF;" href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $data_n['job_id'];  ?>','1200','850')">
								     Job#<?php echo $data_n['job_id'];  ?><i class="fa fa-job" aria-hidden="true"></i>
									 </a>
								  <?php  }elseif($data_n['task_type'] == 2 ){ 
                								  if($data_n['quote_id'] != 0) {  ?>
									 <a class="callUrgent" style="color:#FFF;" onclick="quote_details_show('<?php echo $data_n['id'].'|'.$data_n['quote_id']; ?>','remove_notification_<?php echo $i; ?>');">
								     Quote#<?php echo $data_n['quote_id'];  ?><i class="fa fa-job" aria-hidden="true"></i>
									 </a>
									  <br/>
									<?php } 
									if($data_n['job_id'] != 0) {  ?>
									   <a  class="callUrgent" style="color:#FFF;" href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $data_n['job_id'];  ?>','1200','850')">
								     Job#<?php echo $data_n['job_id'];  ?><i class="fa fa-job" aria-hidden="true"></i>
									 </a>
									   <br/>
									<?php  }  ?>
								  
									<p class="" style="margin-top: 12px;">	<?php  echo create_dd("message_status","system_dd","id","name",'type = 135 ',"onchange=\"javascript:changes_notification_status(this.value, '".$data_n['id']."');\"",$data_n); ?></p>
										<br/>
																
									 <br/>
								<span>	 
								     <!---<a  class="callUrgent" style="color:#FFF;" href="javascript:void(0);">
										Task# <?php echo $data_n['heading'];  ?>
									</a>-->
								</span>	
									<?php  } ?>
                                </span>
								
							<?php   if($data_n['task_type'] == 2 ){?>  
                               <!--<span onClick="send_data('<?php echo $data_n['id']; ?>','571','site_notification')" class="hideIt">X</span>-->
					           
                               <p class="offsetRight"><?php  echo changeDateFormate($data_n['date'],'datetime'); ?></p><br> <b><?php echo ucfirst($data_n['comment']); ?></b></span>
                               
                                <?php  
                                
                                    if($data_n['task_from_type'] == 1 && $data_n['task_from'] == 0) {
                                   
                                       $fromtype = 'Automated';
                                    }else{
                                       $fromtype = get_rs_value("admin","name",$data_n['task_from']);
                                    }
                               
                               ?>
                               
							
							   <p style="float:right;margin-top: -61px;" > From:  <?php echo $fromtype;  //echo  $data_n['task_from']; ?></p>
							
							<?php }else { ?>
							   <span onClick="send_data('<?php echo $data_n['id']; ?>','571','site_notification')" class="hideIt">X</span>
                               <p class="offsetRight"><?php  echo changeDateFormate($data_n['date'],'datetime'); ?></p><br> <b><?php echo ucfirst($data_n['heading']); ?></b></span>
							    
								
							    
							<?php  } ?>
							   
								</li>
						 <?php  } }else {	?>	
							<li class="quote_notification"  id="quote_notification"   style="cursor: pointer;"><span class="bd_list_border<?php // echo $j; ?>"><span class="red"></span><p></p><br> <b>No Persnal Notification</li>	
							<?php  } ?> 
			       </ul>
              </div></p>
			</div>
		 </div>
	    </div>
	</div>
</div>
</div>

