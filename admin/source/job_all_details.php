<?php 
$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".mysql_real_escape_string($_REQUEST['job_id']).""));
$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mysql_real_escape_string($_REQUEST['job_id']).""));
$siteDetails = mysql_fetch_array(mysql_query("Select name ,abv,area_code from sites where id = ".$quote['site_id'].""));

 $quote_details = mysql_fetch_array(mysql_query("Select hours from quote_details Where quote_id='".$quote['id']."' AND job_type_id = 1")); 
 
 $requoteDetails = mysql_fetch_array(mysql_query("SELECT  id, est_sqm , sqm, re_quote FROM `re_quoteing` WHERE job_id =".mysql_real_escape_string($_REQUEST['job_id']).""));
 


if($_REQUEST['task'] == 'job_reclean') {
  $reclean_date = get_sql("job_reclean","reclean_date"," where job_id=".$_REQUEST['job_id']." and status != 2 Order by job_type_id limit 0 ,1");
  $heading =  'Re-Clean date';
  if($reclean_date != '') {
    $job_date =  date("dS M Y",strtotime($reclean_date));
  }else{
	$job_date = '';
  }
}else {
	$heading =  'Job date';
	$job_date =  date("dS M Y",strtotime($quote['booking_date']));
}


$bbcstaffid = $quote['bbcapp_staff_id'];

$adminStatus = getpay_staffStatus($_REQUEST['job_id']);

 ?>
	<br/>
	<div style="width: 100%;">
	
		<div class="modify_left_lst" style="background: #fff;margin-top: -36px;">
			<div class="">
				<ul class="bci_creat_first_quote1" style="padding: 6px; <?php if($bbcstaffid > 0) { echo  'background:#c1efea'; } ?>"   >
					<li><strong>#Q For:  </strong> <?php echo $quote['id']; ?> (<?php echo get_rs_value('quote_for_option','name',$quote['quote_for']); ?>)</li>
					
					 <?php  if($quote['real_estate_id'] > 0) { ?>
					   <li><strong>#Q Real E. Name:  </strong><?php echo get_rs_value("real_estate_agent","name",$quote['real_estate_id']); ?></li>
					 <?php  } ?>
					 
					<!--<li><strong>#Q Id:  </strong><?php echo $quote['id']; ?></li>-->
					<li><strong>Reference: </strong><?php echo $quote['job_ref']; ?>  </li>
					<li><strong>Name:  </strong><?php echo ucfirst($quote['name']); ?></li>
					<li><strong>Email:</strong> <?php echo $quote['email']; ?></li>
					<li><strong>Phone: </strong><a href="tel:<?php echo $siteDetails['area_code'].$quote['quote_for'].$quote['phone']; ?>"><?php echo $quote['phone']; ?></a></li>
					
					<li><strong>Site: </strong><?php echo get_rs_value("sites","name",$jobs['site_id']);?> (<?php echo $quote['suburb']; ?>) </li>
					
					<!--<li><strong>Suburb: </strong><?php echo $quote['suburb']; ?>  </li>-->
					
					<li><strong><?php echo $heading; ?>: </strong><?php echo $job_date; ?></li>
					
					
					<li><strong>Amt: </strong> $<?php if($jobs['customer_amount']!=""){ echo  $jobs['customer_amount']; }else{ echo  $quote['amount']; } ?> </p></li>
					
					<li><strong>Pymt By: </strong><?php echo ucfirst($quote['name']); ?> </li>
					<li> <strong>Amt Charged: </strong><?php echo totalAmountofJob($_REQUEST['job_id']);?></li>
					
					<?php   if($quote['contact_type'] != "") {  ?><li><strong>Contact Type:</strong> <?php echo getContactType($quote['contact_type']); ?></li> <?php  } ?>
					<?php   if($quote['mode_of_contact'] != "") {  ?><li><strong>Mode of Contact: </strong><?php echo getmodeOFContact($quote['mode_of_contact']); ?>  </li><?php  } ?>
					
					<li><strong>Have Removal: </strong>  <?php echo getSystemvalueByID($quote['have_removal'] , 40); ?> </li>
					
					
					<li style="overflow:inherit;" ><div  class="td_back" style="border:none;">
					
					
					<?php  
					if($_GET['task'] == 'job_reclean') {
						echo " <strong>Re-Clean Job Assigned-:</strong> ";
						$argSql  = "SELECT staff_id,job_type,start_time , end_time ,job_type_id ,sub_staff_assign_date ,  sub_staff_id FROM `job_reclean` where job_id = ".$_REQUEST['job_id']." And status != 2"; 
					}else {
						echo "<strong>Job Assigned-: </strong>";
					    $argSql  = "select * from job_details where job_id=".$_REQUEST['job_id']." and status!=2";
					}
					
					//echo $argSql;
					  $checkf = 0;
                      $job_details = mysql_query($argSql);
					  if(mysql_num_rows($job_details)>0) {
						  $workingdate = array();
						  $getSubStafff = array();
                            while($jdetails = mysql_fetch_assoc($job_details))
							{ 
						
								if($jdetails['job_type_id'] == '1') {
									
									//$getadd =   checkSuberb($jdetails['latitute'], $jdetails['longitude']);
								}
							
						//	print_r($jdetails);
							if($jdetails['job_type_id'] == '13') {
							      $checkf =  1;
							}
							
							
							
							if($jdetails['job_type_id'] == '1') {
								$staffwork = 0;
								
								   
								
									if($jdetails['start_time'] != '0000-00-00 00:00:00'){  
    								  $start_time   = date("h:i:s A",strtotime($jdetails['start_time']));
    								// $start_time = changeDateFormate($jdetails['start_time'],'timestamp');
    								 $staffwork = 1;
    							    }else{
    									$start_time = 'Not Started';
    								}
    								
    								if($jdetails['end_time'] != '0000-00-00 00:00:00'){ 
    
                                        $staffwork = 1;			

											$upsell = $jdetails['upsell'];									
    								 
    								   $end_time = date("h:i:s A",strtotime($jdetails['end_time']));
    							    }else{
    									$end_time = 'Not Finished';
    								}
								
								if($jdetails['sub_staff_id'] != 0) {
									
									$getSubStafff[$jdetails['sub_staff_id']] = $jdetails['sub_staff_assign_date'];
									$getSubStafff[$jdetails['sub_staff_id']] = $jdetails['sub_staff_assign_date'];
								}
								
							}elseif($jdetails['job_type_id'] == '8') {
								$staffwork = 0;
								
									if($jdetails['start_time'] != '0000-00-00 00:00:00'){  
    								  $start_time   = date("h:i:s A",strtotime($jdetails['start_time']));
    								// $start_time = changeDateFormate($jdetails['start_time'],'timestamp');
    								 $staffwork = 1;
    							    }else{
    									$start_time = 'Not Started';
    								}
    								
    								if($jdetails['end_time'] != '0000-00-00 00:00:00'){ 
    
                                        $staffwork = 1;			

											$upsell = $jdetails['upsell'];									
    								 
    								   $end_time = date("h:i:s A",strtotime($jdetails['end_time']));
    							    }else{
    									$end_time = 'Not Finished';
    								}
								
								if($jdetails['sub_staff_id'] != 0) {
									
									$getSubStafff[$jdetails['sub_staff_id']] = $jdetails['sub_staff_assign_date'];
									$getSubStafff[$jdetails['sub_staff_id']] = $jdetails['sub_staff_assign_date'];
								}
								
							}elseif($jdetails['job_type_id'] == '11'){
								
							   $quotedetails = mysql_fetch_assoc(mysql_query("select * from quote_details where quote_id ='".mysql_real_escape_string($jdetails['quote_id'])."' AND job_type_id = 11"));	
								//print_r($jdetails);
								
								$quotedetails_data = array();
								$quotedetails_data['booking_date'] = $jdetails['job_date']; 
								$quotedetails_data['travelling_hr'] = $quotedetails['travelling_hr'];
								$quotedetails_data['hours'] = $quotedetails['hours'];
								$quotedetails_data['cubic_meter'] = $quotedetails['cubic_meter'];
								$quotedetails_data['job_type_id'] = $jdetails['job_type_id'];
								$quotedetails_data['loading_time'] = $quotedetails['loading_time'];
								$quotedetails_data['travel_time'] = $quotedetails['travel_time'];
								$quotedetails_data['depot_to_job_time'] = $quotedetails['depot_to_job_time'];
								$quotedetails_data['traveling'] = $quotedetails['traveling'];
								$quotedetails_data['truck_type_id'] = $quotedetails['truck_type_id'];
								
								$removal = true;
							}
							
							 
							  $job_icon =  get_rs_value("job_type","job_icon",$jdetails['job_type_id']);
							
							 if($jdetails['staff_id'] != 0) {
								 $staffNumber = get_rs_value("staff","mobile",$jdetails['staff_id']);
								 $staffassig = 'job_type32';
								 $staffname = get_rs_value("staff","name",$jdetails['staff_id'])." | ".get_rs_value("staff","mobile",$jdetails['staff_id']);
							 }else{
								 $staffassig = 'job_type_red'; 
								 $staffname = ''; 
							 }
							
							
							?>
							<?php  if($staffassig == 'job_type32') { ?> <a   href="tel:<?php echo $staffNumber; ?>" ><?php  } ?>
							   
							   <img class="image_icone" src="icones/<?php echo $staffassig; ?>/<?php echo $job_icon." "; ?>" alt="<?php echo $jdetails['job_type']." "; ?>"  <?php if($removal != true) { ?> title="<?php echo $jdetails['job_type']; ?>  <?php echo $staffname; ?>" <?php  } ?> >
							 
						<?php  if($staffassig == 'job_type32') { ?></a><?php  } ?>
						
						        <?php  if($removal == true) { ?> 
							   
								    <div class="tooltip_div" style="left:130px;width: 500px;">
										<div class="name_text"> <strong>Moving From : </strong><?php echo $quote['moving_from']; ?><br/>
										
                                        <strong>Moving To : </strong><?php echo $quote['moving_to']; ?></div>
										 <div class="name_text">===========================================</div>
										<div style="float: left;">
											<div class="name_text"><strong>Moving From </strong></div>
											<div class="name_text"><strong>On Level From: </strong><?php echo getbrSystemvalueByID($quote['is_flour_from'] ,1); ?></div>
											<div class="name_text"><strong>Lift/Elevator From: </strong><?php echo getbrSystemvalueByID($quote['is_lift_from'] ,2); ?></div>
											<div class="name_text"><strong>Home Type From: </strong><?php echo getbrSystemvalueByID($quote['house_type_from'],3); ?></div>
											<div class="name_text"><strong>Door Distance From: </strong><?php echo getbrSystemvalueByID($quote['door_distance_from'] ,4); ?></div>
										</div>	
										
										<div style="float: right;width: 50%;margin-top: -117px;">
											<div class="name_text"><strong>Moving To </strong></div>
											<div class="name_text"><strong>On Level To: </strong><?php echo getbrSystemvalueByID($quote['is_flour_to'] ,1); ?></div>
											<div class="name_text"><strong>Has Lift/Elevator To: </strong><?php echo getbrSystemvalueByID($quote['is_lift_to'] ,2); ?></div>
											<div class="name_text"><strong>Home Type To: </strong><?php echo getbrSystemvalueByID($quote['house_type_to'] ,3); ?></div>
											<div class="name_text"><strong>Door Distance To: </strong><?php echo getbrSystemvalueByID($quote['door_distance_to'] ,4); ?></div>
										</div>	
										
									    <div class="name_text">===========================================</div>	
									    <div style="float: left;">
									        <div class="name_text" title="depot to job time"><strong>DTJA : </strong><?php echo $quotedetails_data['depot_to_job_time']; ?> hr</div>
											
											 <div class="name_text"><strong>Trvl Time : </strong><?php echo $quotedetails_data['travelling_hr']; ?> hr</div>
											  
											  <div class="name_text"><strong>Trvl Round : </strong><?php echo $quotedetails_data['traveling']; ?> hr </div>
											 <div class="name_text"><strong>Loadl Time : </strong><?php echo $quotedetails_data['loading_time']; ?>hr </div>
											 
											
											
										</div>	
										<div style="float: right;width: 50%;margin-top: -95px;">
											
											<div class="name_text"><strong> Day Time : </strong><?php echo ucfirst(getbrSystemvalueByID($quotedetails_data['travel_time'] , 5)); ?></div>
											 
											<div class="name_text"><strong>Total Working : </strong><?php echo $quotedetails_data['hours']; ?> hr * $ <?php  echo get_rs_value('truck_list','amount',$quotedetails_data['truck_type_id']); ?> </div>
											
											<div class="name_text"><strong>Total Cubic : </strong><?php echo $quotedetails_data['cubic_meter']; ?> m3</div>
											
										</div>	
										
											
									</div>	
							    <?php  } ?>		
								
							<?php 	} }else { echo "Not found"; }?>
					</div></li>
					
					
					
					<?php  if($staffwork == 1) {?>
					  <li><strong>Job Start/End : </strong>  <?php echo $start_time; ?> / <?php echo $end_time; ?> </li>
				    <?php  	}   ?>
					
					<?php  
					   $checkimg = checkImageLink($_REQUEST['job_id']);
					    if($checkimg > 0) { 
					?>
					<li><strong>Image Link : </strong>  <a href="<?php echo CreateImageLink($_REQUEST['job_id']); ?>" target="_blank"><?php echo CreateImageLink($_REQUEST['job_id']); ?></a></li>
					<?php } ?>
					
					
					<?php  if(!empty($getSubStafff)) { ?>
					  <li><strong>Sub Staff: </strong><?php   foreach($getSubStafff as $key=>$value) { echo  '<a title="'.changeDateFormate($value, 'timestamp').'" href="javascripts:void(0);">'.get_rs_value("sub_staff","name",$key); ?></a> /  <a  href="tel:<?php echo  get_rs_value("sub_staff","mobile",$key); ?>"><?php echo  get_rs_value("sub_staff","mobile",$key);  } ?>  </a></li>
				    <?php  	}  

                     $getWorkDetails = get_total_work_hr($_REQUEST['job_id'] , $quote_details['hours']);
					?>
					
					<li><strong>Quote Hours: </strong> <?php echo $quote_details['hours'] .' Hours';;?></li>
					
					
					<?php   if($getWorkDetails['work_hr'] > 0) { ?>
					<li><strong>Work Hours: </strong> <?php echo $getWorkDetails['work_hr'] .' Hours'; ?></li>
					
					 <?php  }  if($getWorkDetails['team_size'] > 0) { ?>
					<li><strong>Team Size: </strong> <?php echo $getWorkDetails['team_size']; ?></li> 
					  
					<?php  }  if($getWorkDetails['total_work'] > 0) { ?>
					<li><strong>Total Hours: </strong><?php echo $getWorkDetails['total_work'] .' Hours'; ?></li>	
					
					<?php } if($getWorkDetails['extra_hr'] > 0) { ?>
					<li><strong>Extra Hours: </strong><?php echo $getWorkDetails['extra_hr'] .' Hours'; ?></li>
					
					<?php  } ?>
					<li><strong>T&C Accept: </strong><?php if($jobs['accept_terms_status'] == 0){ echo 'Not'; }else{ echo 'Yes';} ?> </li>
					
					<?php  if(checkReviewEmails($_REQUEST['job_id']) > 0) { 
					 $getdata = mysql_fetch_assoc(mysql_query("SELECT overall_experience FROM `bcic_review` where 1=1 AND job_id = ".$_REQUEST['job_id']." AND job_type = 1"));
					   $yellow_star = $getdata['overall_experience'];
					   $white_star = 5 - $yellow_star;
					  ?>
						<li><strong> Review Rating:</strong> 
						
						  <?php for($r = 1; $r <= $yellow_star; $r++) { ?>
								<p class="fa fa-star checked1" ></p>
						  <?php  } ?>
						  
						  <?php for($r = 1; $r <= $white_star; $r++) { ?>
								<p class="fa fa-star " ></p>
						  <?php  } ?>
						  
						</li>
						
							<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
							<style>
							.checked1 {
							   color: orange;
							}
							</style>
						
					<?php  } ?>
					
					<?php  if($adminStatus['acc_completed'] > 0) { ?>
					 <li><strong>Status:</strong>   <?php  echo get_sql("system_dd","name"," where type= 26 and id = ".$jobs['status'].""); ?></li>
					<?php  }else{ ?>
					   <li  class="dropdown_list"><strong>Status:</strong><p><?php echo create_dd("status","system_dd","id","name",'type=26',"onchange=\"javascript:edit_field(this,'jobs.status',".$jobs['id'].");\"",$jobs); ?> </li>
					<?php  } ?>
					
					<li class="dropdown_list"><strong>Upsell:</strong> <?php echo create_dd("upsell_denied","system_dd","id","name",'type=106',"onchange=\"javascript:edit_field(this,'jobs.upsell_denied',".$jobs['id'].");\"",$jobs); ?> </li>
					
					<li class="dropdown_list"><strong>Upsell Required:</strong> <?php echo create_dd("upsell_required","system_dd","id","name",'type=127',"onchange=\"javascript:edit_field(this,'jobs.upsell_required',".$jobs['id'].");\"",$jobs); ?> </li>
					
					<li class="dropdown_list"><strong>Upsell Admin:</strong> <?php echo create_dd("upsell_admin","admin","id","name",'status = 1 AND is_call_allow = 1',"onchange=\"javascript:edit_field(this,'jobs.upsell_admin',".$jobs['id'].");\"",$jobs); ?> </li>
					
					 <!--<li class="dropdown_list" style="margin: 11px 0px 0px 50px;"><strong style="margin-left: -70px;"> Case Manager Team:</strong><p style="margin: -26px 32px 2px -31px;"><?php echo create_dd("team_id","system_dd","id","name",'type=87',"onchange=\"javascript:edit_field(this,'jobs.team_id',".$jobs['id'].");\"",$jobs); ?> </li>--->
					 
					 <li class="dropdown_list"><strong> Online Pymt:</strong><p><?php echo create_dd("online_payment_status","system_dd","id","name",'type=65',"onchange=\"javascript:edit_field(this,'jobs.online_payment_status',".$jobs['id'].");\"",$jobs); ?> </li> 
					 
					 <li class="dropdown_list"><strong > Deposit:</strong><p><?php echo create_dd("deposit","system_dd","id","name",'type=40',"onchange=\"javascript:edit_field(this,'jobs.deposit',".$jobs['id'].");\"",$jobs); ?> </li> 
					 
					 
					
					<?php  
					if(in_array($_SESSION['admin'] , array(1,3,17))) {
                            $quotedetails = mysql_fetch_assoc(mysql_query("select id , job_id, task_manage_id from sales_task_track where job_id= ".$jobs['id']." and track_type = 2"));	
						//echo "select id , job_id, task_manage_id from sales_task_track where job_id= ".$jobs['id']." and track_type = 2";	
							
					?>		
							 <li class="dropdown_list"><strong> Operations:</strong><p>  
					<?php 		
                       if(!empty($quotedetails) ) {
						   
						   if($quotedetails['job_id'] > 0) {
							   
						?> 
						 
						  <?php   
							  echo create_dd("task_manage_id","admin","id","name",'id in (3,12,57,34)',"onchange=\"javascript:edit_field(this,'sales_task_track.task_manage_id',".$quotedetails['job_id'].");\"",$quotedetails); ?> 
						   <?php }else{echo 'N/A'; } }else {  
						   $task_manage_id =  get_sql("sales_task_track","task_manage_id"," where job_id= ".$jobs['id']." and track_type = 2"); 
						   if($task_manage_id > 0) {
							   echo $task_manage_id;
						   }else{
							   echo 'N/A';
						   }	
     					}
					 echo '</p></li>';			
					}
					
					?>
					
					 
					 <li class="dropdown_list"><strong>Estimate:</strong>   <?php echo create_dd("estimate_status","system_dd","id","name",'type=122',"onchange=\"javascript:edit_field(this,'jobs.estimate_status',".$jobs['id'].");\"",$jobs); ?> </li>
					 
					<li class="dropdown_list"><strong>Assigning Status:</strong>  
						<?php echo create_dd("assigning_status","system_dd","id","name",'type=35',"onchange=\"javascript:edit_field(this,'jobs.assigning_status',".$jobs['id'].");\"",$jobs); ?>
					</li>
					
					<li class="dropdown_list"><strong>Job Assigning Status:</strong>  
					<?php echo create_dd("job_assign_status","system_dd","id","name",'type=133',"onchange=\"javascript:edit_field(this,'jobs.job_assign_status',".$jobs['id'].");\"",$jobs); ?></li>

                     <?php  if(in_array($_SESSION['admin'], array(1,12,17,15,72))) { ?>
				    	<li class="dropdown_list"><strong>Booking Admin:</strong>   <?php echo create_dd("login_id","admin","id","name",'status=1 AND is_call_allow = 1 ',"onchange=\"javascript:edit_field(this,'quote_new.login_id.admin',".$quote['id'].");\"",$quote); ?> </li>					
					<?PHP  }else{ ?>
					  <li><strong>Booking Admin:  </strong> <?php echo get_rs_value('admin', 'name', $quote['login_id']); ?></li>
					<?php  } ?>
					<li class=""><strong>Start Time:</strong> <input type="text" name="start_time" id="start_time" value="<? echo get_field_value($jobs,"start_time");?>" onblur="javascript:edit_field(this,'jobs.start_time','<?php  echo $jobs['id']; ?>')" >   </li>					
					
					<li class=""><strong>Get Entry :</strong>  <input type="text" name="get_entry"  id="get_entry" value="<? echo get_field_value($jobs,"get_entry");?>" onblur="javascript:edit_field(this,'jobs.get_entry','<?php  echo $jobs['id']; ?>')" >  </li>					
					
					<li class=""><strong>Cleaner Park :</strong>  <input type="text" name="cleaner_park" id="cleaner_park" value="<? echo get_field_value($jobs,"cleaner_park");?>" onblur="javascript:edit_field(this,'jobs.cleaner_park','<?php  echo $jobs['id']; ?>')">    </li>
					<li class="dropdown_list"><strong>Re-quoting Status  :</strong>  
						<?php echo create_dd("re_quote","system_dd","id","name","type=150","onChange=\"javascript:edit_field(this,'re_quoteing.re_quote','" . $requoteDetails['id'] . "');\"",$requoteDetails,'field_id');?>
					</li>
					<li class=""><strong>SQM :</strong>  <input type="text" name="sqm" id="sqm" value="<? if($requoteDetails['sqm'] != '') { echo $requoteDetails['sqm']; } ?>" onblur="javascript:edit_field(this,'re_quoteing.sqm','<?php  echo $requoteDetails['id']; ?>')">    </li>					
					
				</ul>
				
			</div>
		</div>
		
  
    <style>
		.modify_left_lst {
		box-shadow: 0 0 13px 0 rgba(82,63,105,.05);
		border-radius: 4px;
		padding: 5px;
		}
		.bci_creat_first_quote1 li {
		width: 19%;
		overflow: inherit;
		margin-bottom: 8px;
		}
		.bci_creat_first_quote1 li.dropdown_list {
		width: 19%; margin:0px;
		}
		.bci_creat_first_quote1 li.dropdown_list strong {
		float: left; padding: 5px 0px; width:70px;
		}

		.bci_creat_first_quote1 li select {float: left; margin: 0 0px 0 0px;	width: 50%; }

		

		.bci_creat_first_quote1 {
		display: block;
		/* margin: -2px 0; */
		padding: 0;
		font-size: 13px;
		/* font-weight: 600; */
		width: 106%;
		/* font-weight: 600; */
		}
    </style>
	</div>