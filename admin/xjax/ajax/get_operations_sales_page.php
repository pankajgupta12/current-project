<?php  

  /*  $fieldsdata = explode('|', $_POST['fielddata']);
     $track_id = $fieldsdata[0];
     $trackid_head = $fieldsdata[1]; */
	 
	 
	// echo $track_id; die;  
	$gettrackdata1 =  dd_value(112);
	$getsubdata1 = getsubheading($track_id);
 ?>

		<script type="text/javascript">
			$(document).ready(function () {
				 $('.follow_date_class').datepicker({dateFormat:'yy-mm-dd'});
			}); 
		</script>
		
	        <div class="modal-content">
						<div class="modal-header">
						   <button type="button" class="close" data-dismiss="modal<?php //echo $data['id']; ?>">&times;</button>
						   
						      <h4 class="modal-title action_popup" ><?php echo $gettrackdata[$track_id]; ?> &nbsp; (<?php echo $getsubdata[$trackid_head]; ?>)</h4>
						   
						   
						   <h4 class="modal-title" ><?php  echo ucfirst($getqdetails['name']);  ?> ( <a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $getdata['job_id']; ?>','1200','850')"><?php echo $getdata['job_id']; ?></a>)    <span>Amount $<?php echo $getqdetails['amount']; ?></span></h4>
						</div>
						

				
					  
					<div class="modal-body">
						<?php if($track_id != 3 &&  $track_id != 4 &&  $track_id != 6 && $track_id != 7) {  ?>	 
							<span class="glyphicon glyphicon-phone"><a href="tel:<?php echo $getqdetails['phone']; ?>"><?php echo $getqdetails['phone']; ?></a></span>
   							
							
								<p class="glyphicon glyphicon-time left-time-tab"><?php echo changeDateFormate($getdata['fallow_created_date'] , 'datetime'); ?>  <?php echo $getdata['fallow_time']; ?></p>	
								
						    <ul >
							
							    <?php  if($getdata['ans_date'] != '0000-00-00 00:00:00') { ?>
								
								     Answer <span class="glyphicon glyphicon-ok" ></span>
								     Left Message <span class="glyphicon glyphicon-remove" ></span>
									 
									  <br/>
									  <br/>
											
									
							    <?php }else if($getdata['left_sms_date'] != '0000-00-00 00:00:00') { ?>
								
								     Answer <span class="glyphicon glyphicon-remove" ></span>
								     Left Message <span class="glyphicon glyphicon-ok" ></span>
									 
									  <br/>
									  <br/>
											
									
							    <?php } else if($getdata['ans_date'] == '0000-00-00 00:00:00' && $getdata['left_sms_date'] == '0000-00-00 00:00:00') { ?>
								 
								    Answer <span class="glyphicon glyphicon-remove" ></span>
								     Left Message <span class="glyphicon glyphicon-remove" ></span>
									 
									  <br/>
									  <br/>
								
								<?php  }
								
								
							if($track_id == 1 && ($trackid_head == 1 || $trackid_head == 8)) {	
								
							   
                                $jobsdetails = mysql_fetch_array(mysql_query("select id ,cl_email_date_for_img , cl_sms_date_for_img from jobs  where id = ".$getdata['job_id'].""));	
								
								 if($trackid_head == 1) {
								   $ans = 'ans_date';
								   $left_ans = 'left_sms_date';
								   $checked = 'check_question';
								 
								 }elseif($trackid_head == 8) {
								   $ans = 'bfr_img_ans_date';
								   $left_ans = 'bfr_img_not_ans_date';
								   $checked = 'bfr_img_checked_date';
								 }
								
								?>
							
							       <li id="ans_date_<?php echo $getdata['id']; ?>">
									  <button type="button" onclick="opr_set_message_type_button('<?php echo $getdata['id']; ?>' ,'<?php echo $ans; ?>' );" class="btn btn-primary btn-sm">Answer</button>
									</li>
									 
									<li id="left_sms_date_<?php echo $getdata['id']; ?>">
									  <button type="button" onclick="opr_set_message_type_button('<?php echo $getdata['id']; ?>' ,'<?php echo $left_ans; ?>');" class="btn btn-info btn-sm">Left Message</button>
									</li>
									
									<li id="check_question_<?php echo $getdata['id']; ?>">
									  <!--<button type="button" onclick="opr_set_message_type_button('<?php echo $getdata['id']; ?>' ,'check_question');" class="btn btn-info btn-sm"> </button>-->
									  
									   <input type="checkbox" name="check_question" id="check_question"  onclick="opr_set_message_type_button('<?php echo $getdata['id']; ?>' ,'<?php echo $checked; ?>');"  <?php if($getdata['check_question'] != '0000-00-00 00:00:00') { echo 'checked'; } ?> style="width: 36px;height: 21px;margin-top: 13px;"> Checked
									  
									</li>
							
							         <br/>
									
									 <br/>
									 
							<?php  if($trackid_head == 1) { ?>   
							    Email Date For Img Upload <?php date("d M Y h:i:s A",strtotime($jobsdetails['cl_email_date_for_img']));  ?> <br/>
								
								<?php  if($jobsdetails['cl_sms_date_for_img'] == '0000-00-00 00:00:00') { ?>
								 <button type="button" class="btn btn-info btn-sm"  id="email_image_upload"  OnClick="send_data('<?php echo $jobsdetails['id']; ?>', 606, 'email_image_upload');">Img Upload SMS</button>
								 <?php  } else { ?>
								  SMS Date For Img  Upload <?php date("d M Y h:i:s A",strtotime($jobsdetails['cl_sms_date_for_img']));  ?> <br/>
								 <?php  } ?>
								<br/>
								<br/>
							 <?php } ?>
							 
							<?php   } ?>	
								
        							    <li id="sms_date_<?php echo $getdata['id']; ?>"> 
        								  <!--<button type="button"  class="btn btn-info btn-sm">SMS</button>-->
        								  <button type="button" class="btn btn-info btn-sm" onClick="op_savefallowdate('<?php echo $getdata['id']; ?>',2);">Auto Follow</button>
        								  <button type="button" class="btn btn-info btn-sm" onClick="op_show_schedule(3);">Follow</button>
        								  <!--<button type="button" class="btn btn-danger btn-sm" onClick="show_schedule(2);">Lost</button>-->
        								</li>
							  
							
							</ul>	
								<div class="last_activity">
									<?php  $getdata_1 = get_sales_activity($getdata['quote_id'] , 2); 
									 
									   $getRespoType = system_dd_type(111); 
									 
									 foreach($getdata_1 as $key=>$value) {
										 $adminname = get_rs_value('admin' , 'name' , $value['admin_id']);
									?>
									
									   <div class="follow-div">
										   <p><b><?php echo  ucwords($getRespoType[$value['response_type']]);  ?><b/></p>
										   <span>(<?php echo  $adminname;  ?>)</span> 
										   <p style="float: right;"><?php echo  changeDateFormate($value['created_date'] , 'timestamp');  ?></p> 
									   </div>
									 <?php   } ?>
								   
								</div>
								
								
								
								<span id="show_schedule" style="display:none;">
								   <input size="16" type="text"  name="fallow_created_date" value="<?php echo $getdata['fallow_created_date']; ?>" id="fallow_created_date" class="follow_date_class">
									<span>
										<select name="fallow_time"  id="schedule_time">
										<option value=''>Select</option>
										  <?php  
											$minutes = get_minutes('01:00', '23:00');  
											foreach($minutes as $key=>$minute) {
												if(($getdata['fallow_time'] == $minute)) { $selected = 'selected'; }else { $selected = '';} 
											   echo '<option value='.$minute.' '.$selected.'>'.$minute .'</option>';  
											}  
										  ?>
										
										</select>
									
									</span>
								
								   <button type="button" class="btn btn-success btn-sm" onClick="op_savefallowdate('<?php echo $getdata['id']; ?>',1);">Save</button>
								</span>
								
					<br/>	
           				<?php 
                    }	 
					
					if($track_id == 3) 
					{
						
						$jobs = mysql_fetch_array(mysql_query("select id ,review_call_done, review_call_done , left_message,answered from jobs  where id = ".$getdata['job_id'].""));
						
					   if($jobs['answered'] != '0000-00-00 00:00:00') { ?>
								
								     Answer <span class="glyphicon glyphicon-ok" > <strong><?php echo date("d M Y h:i:s A",strtotime($jobs['answered'])); ?></strong></span> &nbsp;
								     Left Message <span class="glyphicon glyphicon-remove" ></span>
									 
									  <br/>
									  <br/>
											
									
							   <?php }else if($jobs['left_message'] != '0000-00-00 00:00:00') { ?>
								
								     Answer <span class="glyphicon glyphicon-remove" ></span> &nbsp;
								     Left Message <span class="glyphicon glyphicon-ok" ><strong><?php echo date("d M Y h:i:s A",strtotime($jobs['left_message'])); ?></strong></span>
									 
									  <br/>
									  <br/>
											
									
							    <?php }else {?>
					
					 <ul >
						<li id="ans_date_<?php echo $getdata['job_id']; ?>">
							  <button type="button"  id="left_message_<?php echo $getdata['job_id']; ?>" onClick="send_data('<?php echo $getdata['job_id']; ?>|left_message|<?php echo $_POST['id']; ?>' ,591,'getdata')"  class="btn btn-primary btn-sm">Left Message</button>
						</li>
							 
							<li id="left_sms_date_<?php echo $getdata['job_id']; ?>">
							   <button type="button" id="answered_<?php echo $getdata['job_id']; ?>" onClick="send_data('<?php echo $getdata['job_id']; ?>|answered|<?php echo $_POST['id']; ?>' ,591,'getdata')" class="btn btn-info btn-sm">Answer</button>
							</li>
							
							
					 </ul>	
								<?php  } ?> 
              <?php if($jobs['answered'] != '0000-00-00 00:00:00' || $jobs['left_message'] != '0000-00-00 00:00:00') { ?>
					  <span><h4>Review Call Action</h4>
                        <span id="review_call_done"></span>		
						
							 <?php  if($jobs['review_call_done'] != '0000-00-00 00:00:00')  {?>		 
								Review Call Client <span class="glyphicon glyphicon-ok"></span> <strong><?php echo  date("d M Y h:i:s A",strtotime($jobs['review_call_done'])); ?></strong>
							 <?php  }else{ ?>
							   <button type="button"  class="btn btn-success btn-sm" onClick="send_data('<?php echo $getdata['job_id']; ?>|review_call_done|<?php echo $_POST['id']; ?>','591','getdata');">Review Call Client</button>	
							 <?php  }  ?>  
					 

				<?php  } } if($track_id == 1 && $trackid_head == 2) {
						
						 ?>
							<span>Best time to contact &nbsp; </span> 
						    <span id="show_schedule" >
									<span>
										<select  class="formfields" name="best_time_contact" onchange="javascript:edit_quote_edit_field(this,'quote_new.best_time_contact','<?php echo $getqdetails['id']; ?>')"  id="best_time_contact">
										<option value=''>Select</option>
										  <?php  
											//$minutes = get_minutes('07:30', '18:00');   
											$minutes = get_minutes('07:30', '17:30');  
											//print_r($minutes);
											
											//print_r
											 foreach($minutes as $key=>$minute) {
												 //$selected = '';
												if(($getqdetails['best_time_contact'] == $minute)) { $selected = 'selected'; }else { $selected = '';} 
											   echo '<option value='.$minute.' '.$selected.'>'.$minute .'</option>';  
											}   
										  ?>
										</select>
									</span>
							</span>			
								
							<br/>	
								<span><h4>Email</h4>
								 <button type="button" class="btn btn-success btn-sm" onClick="">Email</button>
							   </span>	
								
								
						          <span><h4>SMS</h4>
							        <button type="button" class="btn btn-success btn-sm" onClick="">SMS</button>
							   </span>			
						<?php  }else if($track_id == 1 && $trackid_head == 3) {

								$jobs = mysql_fetch_array(mysql_query("select id , estimate_status ,  assigning_status from jobs  where id = ".$getdata['job_id'].""));
						?>		
						   <span><h4>Action</h4>
						    <span id="show_schedule" >
								  <strong>Estimate Status:</strong>
										<span>
											 <?php echo create_dd("estimate_status","system_dd","id","name",'type=122',"onchange=\"javascript:edit_field(this,'jobs.estimate_status',".$jobs['id'].");\"",$jobs); ?>
										 </span>
							   
							   
							   <strong>Assigning Status:</strong>  
									 <span>	<?php echo create_dd("assigning_status","system_dd","id","name",'type=35',"onchange=\"javascript:edit_field(this,'jobs.assigning_status',".$jobs['id'].");\"",$jobs); ?>
									</span>	 
							</span>	 
						
						
						<?php  } else if($track_id == 1 && $trackid_head == 5) {
							
					$jobs = mysql_fetch_array(mysql_query("select id , email_client_cleaner_details ,new_sms_to_client_date, noti_to_cleaner, sms_client_cleaner_details from jobs  where id = ".$getdata['job_id'].""));
						?>
						
					<br/>	
					<br/>	
					<br/>	
							
					<span id="email_client_cleaner_details_div"></span>		
					 <?php  if($jobs['email_client_cleaner_details'] != '0000-00-00 00:00:00')  {?>		  
						Email Client <span class="glyphicon glyphicon-ok"></span>	 <?php echo  date("d M Y h:i:s A",strtotime($jobs['email_client_cleaner_details'])); ?>  
					 <?php  } else { ?>
						
						 <button type="button"  class="btn btn-success btn-sm" onClick="send_data('<?php echo $jobs['id'];?>|email_client_cleaner_details','24','email_client_cleaner_details_div');">Email Client </button>
					 <?php  } ?>	 
						&nbsp;&nbsp;
                   <span id="sms_client_cleaner_details_div"></span>						
					<?php  if($jobs['sms_client_cleaner_details'] != '0000-00-00 00:00:00')  {?>		  
						 Email SMS <span class="glyphicon glyphicon-ok"></span> <?php echo  date("d M Y h:i:s A",strtotime($jobs['sms_client_cleaner_details'])); ?>	  
					 <?php  } else { ?>	 
						 <button type="button"  class="btn btn-success btn-sm" onClick="send_data('<?php echo $jobs['id'];?>|sms_client_cleaner_details','24','sms_client_cleaner_details_div');">Send SMS </button>
					 <?php  } ?>	 
					 
					  <button type="button" class="btn btn-success btn-sm" onClick="">Email Real Estate  </button>
					  
					  <br/>
					  <br/>
					  <br/>
					 
					 <span id="new_sms_to_client_date_div"></span>						
					<?php  if($jobs['new_sms_to_client_date'] != '0000-00-00 00:00:00')  {?>		  
						 <span class="glyphicon glyphicon-ok"></span>SMS To Client <?php echo  date("d M Y h:i:s A",strtotime($jobs['new_sms_to_client_date'])); ?>	  
					 <?php  } else { ?>	 
						 <button type="button"  class="btn btn-success btn-sm" onClick="send_data('<?php echo $jobs['id'];?>|new_sms_to_client_date','612','new_sms_to_client_date_div');">SMS To Client </button>
					 <?php  } ?>	 
					 
					 <span id="noti_to_cleaner_div"></span>						
					<?php  if($jobs['noti_to_cleaner'] != '0000-00-00 00:00:00')  {?>		  
						 <span class="glyphicon glyphicon-ok"></span>Notification To Cleaner <?php echo  date("d M Y h:i:s A",strtotime($jobs['noti_to_cleaner'])); ?>	  
					 <?php  } else { ?>	 
						 <button type="button"  class="btn btn-success btn-sm" onClick="send_data('<?php echo $jobs['id'];?>|noti_to_cleaner','612','noti_to_cleaner_div');">Notification To Cleaner </button>
					 <?php  } ?>	 
						 
						
							 
							 
					<?php  } else if($track_id == 1 && $trackid_head == 6) { 
						
							$jobs = mysql_fetch_array(mysql_query("select id , call_cleaner_date from jobs  where id = ".$getdata['job_id'].""));
							
							?>	
							
							<span id="call_cleaner_date"></span>		
						
							 <?php  if($jobs['call_cleaner_date'] != '0000-00-00 00:00:00')  {?>		 
								Call Cleaner <span class="glyphicon glyphicon-ok"></span> <?php echo  date("d M Y h:i:s A",strtotime($jobs['call_cleaner_date'])); ?>
							 <?php  }else{ ?>
							   <button type="button"  class="btn btn-success btn-sm" onClick="send_data('<?php echo $jobs['id'];?>','590','call_cleaner_date');">Call Cleaner</button>	
							 <?php  }  ?>  
								
				<?php  } else if($track_id == 2 && (in_array($trackid_head , array(1,2,4)))) { 

					   $jobdetails = mysql_fetch_array(mysql_query("SELECT id , job_id ,  staff_id , job_time  FROM `job_details` WHERE `job_id` = ".$getdata['job_id']." AND staff_id != 0 AND  job_type_id = 1"));
					   
					   if(!empty($jobdetails)) {
						   
						     //echo date('H:i' , strtotime($jobdetails['job_time'])) .'<='. date('H:i');
							 $ctdate = date('8:00');
						    if(date('H:i' , strtotime($jobdetails['job_time'])) <= $ctdate){
									$staffdetails = mysql_fetch_array(mysql_query("SELECT id , mobile ,  name   FROM `staff` WHERE `id` = ".$jobdetails['staff_id'].""));
									
								if($trackid_head == 1) {		
								  $message = 'J#.'.$getdata['job_id'].'  Pls make sure you start jobs on daily basis.';
								  $strhead = "Send Custom SMS to ".$staffdetails['name']." (".$staffdetails['mobile'].") For Start job";	
								}elseif($trackid_head == 2){
									$message = 'J#'.$getdata['job_id'].'  Pls make sure you before image upload on daily basis.';
									$strhead = "Send Custom SMS to ".$staffdetails['name']." (".$staffdetails['mobile'].") For Before Image";	
								}elseif($trackid_head == 4){
									//J#17261  Pls make sure you After image upload on daily basis.
									$message = 'J#'.$getdata['job_id'].'  Pls make sure you After image upload on daily basis.';
									$strhead = "Send Custom SMS to ".$staffdetails['name']." (".$staffdetails['mobile'].") For  After Image";	
								}
					?>
					 <br/>
					 <br/>
					 <br/>
					  
					    <span class="sms_result" id="sms_result_<?php echo $track_id.'_'.$trackid_head; ?>" style="text-align: center;color: green;font-size: 20px;"></span>
					 
					    <h4><strong><?php echo $strhead; ?> job( J#<?php echo $getdata['job_id']; ?> ) </strong></h4>
						
						<textarea maxlength="500" cols="1" rows="2"  style="font-size: 19px;margin: 0px;width: 609px;height: 58px;border: 1px solid;" name="message_content" id="message_content_<?php echo $track_id.'_'.$trackid_head; ?>" placeholder="Type Message Here..."><?php  if($message != '') { echo $message; } ?></textarea>
					  <br/>
					        <button type="button"  class="btn btn-success btn-sm" onClick="send_noti('<?php echo $track_id.'_'.$trackid_head; ?>' , '<?php echo $getdata['job_id']; ?>' ,'<?php echo $staffdetails['mobile']; ?>' ,'<?php echo base64_encode($strhead); ?>');">Send Notification </button>
					
				<?php  }} 
				} else if($track_id == 4 && $trackid_head == 2) { 
						
							$jobs = mysql_fetch_array(mysql_query("select id , awaiting_exit_report , awaiting_exit_nextday_email ,guarantee_expired_email_date ,  awaiting_exit_receive from jobs  where id = ".$getdata['job_id'].""));
							
							?>	
						<h3>SMS – reminder to send us the exit report </h3>
                        <br/>						
								
						
						
						        Next Day Emailed Awaiting Exit Report
 								<?php  if($jobs['awaiting_exit_nextday_email'] != '0000-00-00 00:00:00')  { ?>
                                    <span class="glyphicon glyphicon-ok"></span>  
								<?php  echo  date("d M Y h:i:s A",strtotime($jobs['awaiting_exit_nextday_email']));
                                  } else {
								?>
                                 <span class="glyphicon glyphicon-remove"></span>  
								<?php   echo 'Not Send'; } ?> 
							 
							 <br/>
							 <br/>
							 
						    <span id="call_cleaner_date"></span>	
							 <?php  if($jobs['awaiting_exit_report'] != '0000-00-00 00:00:00')  {?>		 
								Awaiting Exit Report SMS <span class="glyphicon glyphicon-ok"></span> <?php echo  date("d M Y h:i:s A",strtotime($jobs['awaiting_exit_report'])); ?>
							 <?php  }else{ ?>
							   <button type="button"  class="btn btn-success btn-sm" onClick="send_data('<?php echo $jobs['id'];?>|1','592','call_cleaner_date');">Awaiting Exit Report SMS  </button>	
							 <?php  }  ?>  
							 
							<br/>
							<br/>
							
							<?php  

                        if($jobs['awaiting_exit_report'] != '0000-00-00 00:00:00') 
				       
					   {
                            $awaiting_exit_report = date('Y-m-d' , strtotime($jobs['awaiting_exit_report'] , '+1 day'));
							 if($awaiting_exit_report <  date('Y-m-d')) {
							?>
							
							
							<span id="guarantee_expired_email_date"></span>	
							 <?php  if($jobs['guarantee_expired_email_date'] != '0000-00-00 00:00:00')  {?>		 
								Guarantee Expired Email Date<span class="glyphicon glyphicon-ok"></span> <?php echo  date("d M Y h:i:s A",strtotime($jobs['guarantee_expired_email_date'])); ?>
							 <?php  }else{ ?>
							   <button type="button"  class="btn btn-success btn-sm" onClick="send_data('<?php echo $jobs['id'];?>|3','592','guarantee_expired_email_date');">
							   Guarantee Expired Email  </button>	
							 <?php  }  ?>  
						<?php  } 
						} ?>	
						
						<br/>
							 <br/>
							<hr>
							 
							 <span id="awaiting_exit_receive"></span>	
							 <br/>
							  <?php  if($jobs['awaiting_exit_receive'] != '0000-00-00 00:00:00')  {?>	
							  Exit Report Receive <span class="glyphicon glyphicon-ok"></span> <?php echo  date("d M Y h:i:s A",strtotime($jobs['awaiting_exit_receive'])); ?> 
							  <?php  }else{ ?>
							   <button type="button"  class="btn btn-success btn-sm" onClick="send_data('<?php echo $jobs['id'];?>|2','592','awaiting_exit_receive');">Exit Report Receive  </button>	
							<?php  } ?>
							
							
						  
								
				<?php  }else if($track_id == 4 && $trackid_head == 5 ) {  
				   $jobs = mysql_fetch_array(mysql_query("select id , arrange_reclean_date_noti from jobs  where id = ".$getdata['job_id'].""));
				
				
				?>
				
				              <span id="arrange_reclean_date_noti"></span>	
							  <?php  if($jobs['arrange_reclean_date_noti'] != '0000-00-00 00:00:00')  {?>	
							  Send Arrange Job Date <span class="glyphicon glyphicon-ok"></span> <?php echo  date("d M Y h:i:s A",strtotime($jobs['arrange_reclean_date_noti'])); ?> 
							  <?php  }else{ ?>
							   <button type="button"  class="btn btn-success btn-sm" onClick="send_data('<?php echo $jobs['id'];?>|4','592','arrange_reclean_date_noti');">Send Arrange Job Date  </button>	
							   <?php }?>
				
				<?php  } else if($track_id == 6 && $trackid_head == 1 ) {
					
				      $jobs = mysql_fetch_array(mysql_query("select id , complaint_sent_to_cleaner from job_complaint  where job_id = ".$getdata['job_id'].""));
				
				
				?>
				
				              <span id="arrange_reclean_date_noti"></span>	
							  <?php  if($jobs['complaint_sent_to_cleaner'] != '0000-00-00 00:00:00')  {?>	
							  Complaint sent to Cleaner  <span class="glyphicon glyphicon-ok"></span> <?php echo  date("d M Y h:i:s A",strtotime($jobs['complaint_sent_to_cleaner'])); ?> 
							  <?php  }else{ ?>
							   <button type="button"  class="btn btn-success btn-sm" onClick="send_data('<?php echo $jobs['id'];?>|6','611','complaint_sent_to_cleaner');">Complaint sent to Cleaner </button>	
							   <?php }?>
				
				<?php  } else if(($track_id == 6 && $trackid_head == 8)  || ($track_id == 7 && $trackid_head == 7) ) {
					
				      $complaintetals = mysql_fetch_array(mysql_query("select * from job_complaint  where job_id = ".$getdata['job_id']." AND id= ".$complaint_id.""));
				
				
				   if($track_id == 6) {
					   $type = '143';
					   $heading = 'Who was at Fault -';
				   }elseif($track_id == 7) {
					   $type = '143';
					    $heading = 'What was the Resolution was-';
				   }
				
				?>
				<style>
					select#who_fault {
					width: 80%;
					height: 100%;
					border: 1px solid #000;
					}
				</style>
				
				<table style="width: 90%;">
					 
					   <tr>
					     <td colspan="2"  style="text-align:center;"> Fill the Information <span style="float: right;font-size: 15px;"><?php if($complaintetals['complaint_date'] !='0000-00-00 00:00:00'){ echo 'Last Updated Date '. date("d M Y h:i:s A",strtotime($complaintetals['complaint_date']));  }   ?></span></td>
					  </tr>

					  <tr>
					     <td><?php  echo $heading; ?> </td>
					     <td> 
						 <!--<input  style="width: 100%;height: 35px;" type="text" value="<?php  if($complaintetals['who_fault'] !='') { echo  $complaintetals['who_fault']; } ?>" id="who_fault">-->
						  <?php echo  create_dd("who_fault","system_dd","id","name","type=$type","",$complaintetals); ?>
						 
						 </td>
					  </tr>
					  
					  <tr>
					     <td>	Refund Given  </td>
					     <td> <input type="text" style="width: 100%;height: 35px;" value="<?php  if($complaintetals['refund_given'] !='') { echo  $complaintetals['refund_given']; } ?>" id="refund_given"></td>
					  </tr>
					  
					  <tr>
					     <td>	Gift Voucher</td>
					     <td> <input type="text" style="width: 100%;height: 35px;" value="<?php  if($complaintetals['gift_voucher'] !='') { echo  $complaintetals['gift_voucher']; } ?>" id="gift_voucher"></td>
					  </tr>
					 
					  <tr>
					     <td>	Insurance Case  </td>
					     <td> <input type="text" style="width: 100%;height: 35px;" value="<?php  if($complaintetals['insurance_case'] !='') { echo  $complaintetals['insurance_case']; } ?>" id="insurance_case"></td>
					  </tr>
					  <tr>
					     <td> 	Paying Invoice – </td>
					     <td> <input type="text" style="width: 100%;height: 35px;" value="<?php  if($complaintetals['payning_invoice'] !='') { echo  $complaintetals['payning_invoice']; } ?>" id="payning_invoice"></td>
					  </tr>
					  <tr>
					     <td>	Others   </td>
					     <td> <input type="text" value="<?php  if($complaintetals['other'] !='') { echo  $complaintetals['other']; } ?>" style="width: 100%;height: 35px;" id="other"></td>
					  </tr>
					  
					  <tr>
					     <td> </td>
					     <td> <input type="submit" value="Save" id="submit" onClick="saveCompliteInfo('<?php echo $id; ?>|<?php echo $track_id;  ?>|<?php echo $trackid_head.'_'.$complaint_id;?>');"></td>
					  </tr>
					 
					 </table>
				             
				
				<?php  } ?>
					
						</div>
						
					<div class="modal-footer" style="margin-top: 78px;">
					  <button type="button" class="btn btn-default" data-dismiss="modal<?php// echo $data['id']; ?>">Close</button>
					</div>
			</div>