<?php 
session_start();
include("../../source/functions/functions.php");
include("../../source/functions/config.php");

if(isset($_POST['page'])) 
{
	$pageid = $_POST['page'];
	
	$arg = "SELECT job_details.job_date as jobDate,job_details.job_acc_deny as WorkStatus,job_details.start_time as start,job_details.end_time as end,jobs.id as id, sites.name as site_name ,sites.abv as site_abv, jobs.status as jobStatus, jobs.accept_terms_status as accepterms_status,jobs.team_id as teamname,jobs.team_name as team_name, quote_new.name as cx_name, quote_new.date as job_date, quote_new.booking_date as jdate, jobs.customer_amount as job_amt, jobs.email_client_booking_conf as email_client_booking_conf, jobs.email_client_cleaner_details as email_client_cleaner_details ,jobs.review_email_time as review_email_time , jobs.sms_client_cleaner_details as sms_client_cleaner_details FROM jobs LEFT JOIN sites ON jobs.site_id = sites.id LEFT JOIN quote_new ON jobs.quote_id = quote_new.id LEFT JOIN job_details on job_details.quote_id = quote_new.id WHERE 1=1 AND job_details.status != 2";
			
if(isset($_SESSION['daily_dispatch']['report_from_date']) && $_SESSION['daily_dispatch']['report_from_date'] != NULL  &&  isset($_SESSION['daily_dispatch']['to_date']) && $_SESSION['daily_dispatch']['to_date'] != NULL )
	{ 
	   if($_SESSION['daily_dispatch']['called_type'] == 1) {
		  $arg .= " AND job_details.job_date >= '".$_SESSION['daily_dispatch']['report_from_date']."' AND job_details.job_date <= '".$_SESSION['daily_dispatch']['to_date']."' "; //today change
	   }elseif($_SESSION['daily_dispatch']['called_type'] == 2) {
		  $arg .= " AND quote_new.date >= '".$_SESSION['daily_dispatch']['report_from_date']."' AND quote_new.date <= '".$_SESSION['daily_dispatch']['to_date']."' "; //today change 
	   }
		$arg .= "";
	}


	if(isset($_SESSION['daily_dispatch']['site_id']) && $_SESSION['daily_dispatch']['site_id'] != NULL )
	{
		$arg .= " AND jobs.site_id = ".$_SESSION['daily_dispatch']['site_id'];
	}

	if(isset($_SESSION['daily_dispatch']['team_id']) && $_SESSION['daily_dispatch']['team_id'] != NULL  && isset($_SESSION['daily_dispatch']['team_id']) && $_SESSION['daily_dispatch']['team_id'] != 0 )
	{
		$arg .= " AND jobs.team_id = ".$_SESSION['daily_dispatch']['team_id'];
	}

	if(isset($_SESSION['daily_dispatch']['quote_type']) && $_SESSION['daily_dispatch']['quote_type'] == 1)
	{
		$arg .= "  AND  !FIND_IN_SET ('11' , job_type_id) ";
	}else if(isset($_SESSION['daily_dispatch']['quote_type']) && $_SESSION['daily_dispatch']['quote_type'] == 2)
	{
		$arg .= "  AND  FIND_IN_SET ('11' , job_type_id) ";
	}else if(isset($_SESSION['daily_dispatch']['quote_type']) && $_SESSION['daily_dispatch']['quote_type'] == 3)
	{
		$arg .= "  AND  real_estate_id != 0";
	}



	if(isset($_SESSION['daily_dispatch']['status']) && $_SESSION['daily_dispatch']['status'] != 0)
	{
		$arg .= " AND jobs.status = ".$_SESSION['daily_dispatch']['status'];
	}

$arg .= " group by job_details.job_id  ORDER BY job_details.job_date DESC";			

	$resultsPerPage = resultsPerPage;
	//$resultsPerPage = 5;

	if($pageid>0)
	{
		$page_limit=$resultsPerPage*($pageid - 1);
		$arg.=" LIMIT  $page_limit , $resultsPerPage";
	}
	else
	{
		$arg.=" LIMIT 0 , $resultsPerPage";
	}
     
	 
	$sms_for_notify = get_rs_value("siteprefs","sms_for_notify",1);	

if($sms_for_notify == 1) {
  $cont_var = 'SMS';
  $cont_var2 = 'Messages';
}
else{
  $cont_var = 'Notif';
  $cont_var2 = 'Notification';
}	 

	$data = mysql_query($arg);

	if (mysql_num_rows($data)>0)
			{ 
			    
			    $row1 = 1;
			   	$counter = 0;
				while( $row = mysql_fetch_assoc($data) ) 
				{ 
				   
				     $counter++;
				     $bgcolor = ($counter % 2 === 0) ? 'alert_even_tr' : 'alert_odd_tr';
                        
					$j = 1;
					
					$job_id = $row['id'];
				 	$arg2 = "SELECT *
					FROM job_details
					WHERE job_id = '".$job_id."' AND status != 2
					";
					$data2 = mysql_query($arg2);
					$countResult2 = mysql_num_rows($data2);
					$sumamount = 0;
					while($row2 = mysql_fetch_assoc($data2) )
					{
					     
				    
                   $gettotal =      mysql_fetch_array(mysql_query("SELECT sum(amount_total) as tamount
				   	FROM job_details
					WHERE job_id = '".$job_id."' AND status != 2 ")); 
					 
				//teamname
				if($row['team_name'] != '') {
				  
				  $teamname = $row['team_name'];
				}else {
					$teamname = 'N/A';
				}
			
                $getImgdetails = checkStaffUploadImageInDialy($row['id'], $row2['staff_id']);		

                      $getPayment =    callPaytype($row['id']);				
					 
			    
			?>
			<tr  class="parent_tr <?php if($getPayment == 'No Payment Found!') {echo "alert_danger_tr";}else{ echo $bgcolor;} ?>">
					   
					  	<?php if($j == 1) { ?>
						<td rowspan='<?php echo $countResult2; ?>' ><a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $row['id']; ?>','1200','850')"><?php echo $row['id']; ?></a></td>
						<?php } ?>
						
					 	<?php if($j == 1) { ?>
					    	<td rowspan='<?php echo $countResult2; ?>' title="<?php echo ucwords($row['site_name']); ?>"><?php echo ucwords($row['site_abv']); ?></td>
						<?php } ?>
						
						<?php if($j == 1) { ?>
						 <td rowspan='<?php echo $countResult2; ?>'><?php echo ucwords($row['cx_name']); ?></td>
						<?php } ?>
						
						<?php /* if($j == 1) { ?>
						 <td rowspan='<?php echo $countResult2; ?>'><?php echo $teamname; ?></td>
						<?php }  */?>
						
					   	<?php if($j == 1) { ?>
					     <td rowspan='<?php echo $countResult2; ?>'><?php  if($_SESSION['daily_dispatch']['called_type'] == 1) { echo changeDateFormate($row['jobDate'],'dm'); } else if($_SESSION['daily_dispatch']['called_type'] == 2) { echo changeDateFormate($row['job_date'],'dm');  } ?></td>
					   <?php } ?>
					   
						
						<?php if($j == 1) { ?>
						<td rowspan='<?php echo $countResult2; ?>'><?php   echo $gettotal['tamount'];  //echo gettotalamount($job_id); ?></td>
						<?php } ?>   
						
						<?php if($j == 1) { ?>
						   <td rowspan='<?php echo $countResult2; ?>'><?php echo $getPayment; ?></td>
						<?php } ?>   
						
							<td>
                            <?php $job_icon =  get_rs_value("job_type","job_icon",$row2['job_type_id']);  ?>
					          <img class="image_icone" src="icones/job_type32/<?php echo $job_icon." "; ?>" alt="<?php echo $row2['job_type']." "; ?>" title="<?php echo $row2['job_type']." "; ?>">	</td>
							<td><?php echo $row2['amount_total']; ?></td>
							<td title="<?php echo changeDateFormate($row2['job_date'],'datetime') . " " . $row2['job_time'] ; ?>">
							<?php  echo  date('dS M', strtotime($row2['job_date']));?>
							</td>
							
						
						
						
						<td><?php if($row2['staff_id'] != '0') { echo  get_rs_value("staff","name",$row2['staff_id']); }else { echo "Not Assign";} ?></td>	
					<?php if($j == 1) { ?>	
						<td rowspan='<?php echo $countResult2; ?>' title="<?php  if($row['sms_client_cleaner_details']!="0000-00-00 00:00:00") { echo changeDateFormate($row['sms_client_cleaner_details'],'timestamp'); } ?>" id="sms_client_cleaner_details_div_<?php echo $row['id']; ?>">
						   <?php  if($row['sms_client_cleaner_details']!="0000-00-00 00:00:00") { echo changeDateFormate($row['sms_client_cleaner_details'],'dm'); }else {
								?>
								  <input type="submit" style="border: 1px solid;background: #d2dae3;width: 67px;" value="Send SMS" class="buttone_msgsend" onClick="send_data('<?php echo $row['id']; ?>|sms_client_cleaner_details','24','sms_client_cleaner_details_div_<?php echo $row['id']; ?>');" >
								<?php  } ?>
						 </td>							
						
					<?php  } ?>	
						
						
				<?php if($sms_for_notify == 1) { ?>		
						<td id="job_sms_<?php echo $row2['id'];?>">
						    <?php  if($row2['staff_id'] != '0') { ?>
						    <input type="checkbox" name="job_sms"  <?php  if($row2['job_sms'] == '1') { ?> onChange="send_data('job|<?=$row2['id'];?>|<?php echo $row2['job_sms']; ?>',92,'quote_view');" <?php }else { ?> onClick="send_data('job|<?=$row2['id'];?>|report',25,'quote_view');" <?php  } ?> value="<?php echo $row2['job_sms']; ?>" <?php echo ($row2['job_sms']==1 ? 'checked' : '');?>>
							
    						<span title="<?php  if($row2['job_sms'] == '1') { echo changeDateFormate($row2['job_sms_date'],'dm'); } ?>">
							
							<?php  if($row2['job_sms'] == '1') { echo changeDateFormate($row2['job_sms_date'],'dm'); }else {?>
    						  <input type="submit" style="border: 1px solid;background: #d2dae3;width: 65px;" value="Job SMS" class="buttone_msgsend" onClick="send_data('job|<?=$row2['id'];?>||',25,'job_sms_<?php echo $row2['id'];?>');" >
    						 
    						<?php  } ?>
							</span>
							<br/><hr><hr>
							<span id="job_noti_date_<?php echo $row2['id']; ?>"  ><?php  if($row2['job_notification_status'] == '1') { echo changeDateFormate($row2['job_notification_date'],'dm'); } ?></span>
							<hr>
							
							 <span  title="<?php  if($row2['job_notification_status'] == '1') { echo changeDateFormate($row2['job_notification_date'],'dm'); } ?>" >
                         
						
						    <input type="submit" style="border: 1px solid;background: #d2dae3;width: 90px;" value="Job Notif" class="buttone_msgsend" id="job_notif_time_<?php echo $row2['id'];  ?>" onClick="send_data('job|<?=$row2['id'];?>||smstype',25,'job_noti_date_<?php echo $row2['id']; ?>');">
						   </span>
							
 						<?php 	} else { echo "--"; } ?>
						</td>
						  
						<td id="address_sms_<?php echo $row2['id'];?>" title="<?php  if($row2['address_sms'] == '1') { echo changeDateFormate($row2['address_sms_date'],'timestamp'); } ?>" >
						     <?php  if($row2['staff_id'] != '0') { ?>
							 
						 <input type="checkbox" class="buttone_msgsend"   name="address_sms" <?php if($row2['address_sms']==1) { ?> onChange="send_data('address|<?=$row2['id'];?>|<?php echo $row2['address_sms']; ?>',92,'quote_view');" <?php  }else { ?> onClick="send_data('address|<?=$row2['id'];?>|report',25,'quote_view');"<?php  } ?> value="<?php echo $row2['address_sms']; ?>" <?php echo ($row2['address_sms']==1 ? 'checked' : '');?>>
						 
						  <span  title="<?php  if($row2['address_sms'] == '1') { echo changeDateFormate($row2['address_sms_date'],'timestamp'); } ?>" ><?php  if($row2['address_sms'] == '1') { echo changeDateFormate($row2['address_sms_date'],'dm'); }else {  ?>
						
						   <input type="submit" style="border: 1px solid;background: #d2dae3;width: 90px;" value="Add SMS" class="buttone_msgsend" id="address_sms_time_<?php echo $row2['id'];  ?>" onClick="send_data('address|<?=$row2['id'];?>||',25,'address_sms_<?php echo $row2['id']; ?>');">
						    <?php } ?></span>
							<br/><hr><hr>
							
							<span id="add_noti_date_<?php echo $row2['id']; ?>"  ><?php  if($row2['add_notification_status'] == '1') { echo changeDateFormate($row2['add_notification_date'],'timestamp'); } ?></span>
							<hr>
							 <span title="<?php  if($row2['add_notification_status'] == '1') { echo changeDateFormate($row2['add_notification_date'],'dm'); } ?>" >
							
						      <input type="submit" style="border: 1px solid;background: #d2dae3;width: 90px;" value="Add Notif" class="buttone_msgsend" id="address_notif_time_<?php echo $row2['id'];  ?>" onClick="send_data('address|<?=$row2['id'];?>||smstype',25,'add_noti_date_<?php echo $row2['id']; ?>');">
							  
						    </span>
							<?php }else {echo "--"; }?>
					
						</td>
						
				<?php  }else { ?>	
				
				    <td id="job_sms_<?php echo $row2['id'];?>">
						    <?php  if($row2['staff_id'] != '0') { ?>
						    <input type="checkbox" name="job_sms"  <?php  if($row2['job_sms'] == '1') { ?> onChange="send_data('job|<?=$row2['id'];?>|<?php echo $row2['job_sms']; ?>',92,'quote_view');" <?php }else { ?> onClick="send_data('job|<?=$row2['id'];?>|report',25,'quote_view');" <?php  } ?> value="<?php echo $row2['job_sms']; ?>" <?php echo ($row2['job_sms']==1 ? 'checked' : '');?>>
							
    						<span title="<?php  if($row2['job_sms'] == '1') { echo changeDateFormate($row2['job_sms_date'],'timestamp'); } ?>">
							
							<?php  if($row2['job_sms'] == '1') { echo changeDateFormate($row2['job_sms_date'],'dm'); }else {?>
    						  <input type="submit" style="border: 1px solid;background: #d2dae3;width: 65px;" value="Job <?=$cont_var;?>" class="buttone_msgsend" onClick="send_data('job|<?=$row2['id'];?>||',25,'job_sms_<?php echo $row2['id'];?>');" >
    						 
    						<?php  } ?>
							</span>
							
							
 						<?php 	} else { echo "--"; } ?>
					</td>
						  
					<td id="address_sms_<?php echo $row2['id'];?>" title="<?php  if($row2['address_sms'] == '1') { echo changeDateFormate($row2['address_sms_date'],'timestamp'); } ?>" >
						     <?php  if($row2['staff_id'] != '0') { ?>
							 
						 <input type="checkbox" class="buttone_msgsend"   name="address_sms" <?php if($row2['address_sms']==1) { ?> onChange="send_data('address|<?=$row2['id'];?>|<?php echo $row2['address_sms']; ?>',92,'quote_view');" <?php  }else { ?> onClick="send_data('address|<?=$row2['id'];?>|report',25,'quote_view');"<?php  } ?> value="<?php echo $row2['address_sms']; ?>" <?php echo ($row2['address_sms']==1 ? 'checked' : '');?>>
						 
						  <span  title="<?php  if($row2['address_sms'] == '1') { echo changeDateFormate($row2['address_sms_date'],'timestamp'); } ?>" ><?php  if($row2['address_sms'] == '1') { echo changeDateFormate($row2['address_sms_date'],'dm'); }else {  ?>
						
						   <input type="submit" style="border: 1px solid;background: #d2dae3;width: 90px;" value="Add <?=$cont_var;?>" class="buttone_msgsend" id="address_sms_time_<?php echo $row2['id'];  ?>" onClick="send_data('address|<?=$row2['id'];?>||',25,'address_sms_<?php echo $row2['id']; ?>');">
						    <?php } ?></span>
							
					</td>
				
				<?php } } ?>
					
						<td title="<?php if($row['email_client_booking_conf'] != '0000-00-00 00:00:00' ) { echo changeDateFormate($row['email_client_booking_conf'],'timestamp'); } ?>">
						    <?php if($row['email_client_booking_conf'] != '0000-00-00 00:00:00' ) { echo changeDateFormate($row['email_client_booking_conf'],'dm');} else { echo "N/A"; } ?>
						</td>
						
						
						<td title="<?php if($row['email_client_cleaner_details'] != '0000-00-00 00:00:00' ) { echo changeDateFormate($row['email_client_cleaner_details'],'timestamp'); } ?>">
						
						    <?php if($row['email_client_cleaner_details'] != '0000-00-00 00:00:00' ) { echo changeDateFormate($row['email_client_cleaner_details'],'dm');} else { echo "N/A"; } ?>
							
						</td>
				     
					    <td><?php if($row2['job_acc_deny'] == Null || $row2['job_acc_deny'] == '') { echo  "N/A";  } else {echo getSystemvalueByID($row2['job_acc_deny'],47); } ?></td>
						
						<td title="<?php echo $row2['job_time']; ?>"><?php echo $row2['job_time']; ?></td>
					
					    <td title="<?php if($row2['start_time'] != '0000-00-00 00:00:00') {echo changeDateFormate($row2['start_time'],'timestamp'); }  ?>"   <?php if($row2['start_time'] == '0000-00-00 00:00:00' && $row2['job_time'] >= date('Y-m-d'))  {  ?> style="background: #efe2e2;" <?php  }  ?> >
						    <?php  if($row2['start_time'] != '0000-00-00 00:00:00') {echo changeDateFormate($row2['start_time'],'hi'); }else {  if($row2['job_type_id'] == 1) { ?><a href= "javascript:scrollWindow('sms_for_staff.php?sms_task=start_job&job__details_id=<?php echo $row2['id']; ?>','400','400')"><?php echo $cont_var;?> Start</a><?php }else {echo "Not Started"; }  }?>
						</td>
						 
						<td title="<?php if($row2['end_time'] != '0000-00-00 00:00:00') { echo changeDateFormate($row2['end_time'],'timestamp'); } ?>">
							  <?php if($row2['end_time'] != '0000-00-00 00:00:00') { echo changeDateFormate($row2['end_time'],'hi'); }else 
							{  if($row2['job_type_id'] == 1) { ?><a href= "javascript:scrollWindow('sms_for_staff.php?sms_task=finish_job&job__details_id=<?php echo $row2['id']; ?>','400','400')"><?php echo $cont_var;?> Finish</a><?php }else {echo "Not Finished"; }  }?>
						</td>	
							
							
						<?php  //$checkbeforeImg = checkStaffUploadImage($row['id'], $row2['staff_id'], 1 );?>
						<?php  $checkbeforeImg = $getImgdetails[1];?>
						<td><?php if($checkbeforeImg > 0) {echo "Yes"; }else {   if($row2['job_type_id'] == 1) { ?><a href= "javascript:scrollWindow('sms_for_staff.php?sms_task=before_img&job__details_id=<?php echo $row2['id']; ?>','400','400')"><?php echo $cont_var;?> Befor Img</a><?php }else {echo "No"; }  }?></td>
							
						<?php // $checkafterImg = checkStaffUploadImage($row['id'], $row2['staff_id'], 2 ); ?>	
						<?php  $checkafterImg = $getImgdetails[2]; ?>	
						<td><?php if($checkafterImg > 0) {echo "Yes"; }else {    if($row2['job_type_id'] == 1) { ?><a href= "javascript:scrollWindow('sms_for_staff.php?sms_task=after_img&job__details_id=<?php echo $row2['id']; ?>','400','400')"><?php echo $cont_var;?> After Img</a><?php }else {echo "No"; }  }?></td>
						  
						<?php // $checkcheckImg = checkStaffUploadImage($row['id'], $row2['staff_id'], 3 ); ?>	
						<?php  $checkcheckImg = $getImgdetails[3]; ?>	
						<td><?php if($checkcheckImg > 0) {echo "Yes"; }else {    if($row2['job_type_id'] == 1) { ?><a href= "javascript:scrollWindow('sms_for_staff.php?sms_task=checklist&job__details_id=<?php echo $row2['id']; ?>','400','400')"><?php echo $cont_var;?> CheckList</a><?php }else {echo "No"; }  }?></td>  
				
						<?php // $checkguranteeImg = checkStaffUploadImage($row['id'], $row2['staff_id'], 4 ); ?>	
						<?php  $checkguranteeImg = $getImgdetails[4]; ?>	
						<td><?php if($checkguranteeImg > 0) {echo "Yes"; }else {    if($row2['job_type_id'] == 1) { ?><a href= "javascript:scrollWindow('sms_for_staff.php?sms_task=nogurantee&job__details_id=<?php echo $row2['id']; ?>','400','400')"><?php echo $cont_var;?> No Gurantee</a><?php }else {echo "No"; }  }?></td> 
						  
						<?php if($j == 1) { ?>
						     <td rowspan='<?php echo $countResult2; ?>'><a href= "javascript:scrollWindow('sms_for_staff.php?sms_task=all_sms&job__details_id=<?php echo $row2['id']; ?>','400','400')">All <?php echo $cont_var;?></a></td>
						<?php  } ?>
					 
				       <?php if($j == 1) { ?>
				   	    <td rowspan='<?php echo $countResult2; ?>'><?php echo  getSystemDDname($row['jobStatus'],26); ?></td>
				   		<?php } ?>  
						 <?php if($j == 1) { ?>
				   	     <td rowspan='<?php echo $countResult2; ?>'><?php if($row['accepterms_status'] == 0){ echo 'Not'; }else{ echo 'Yes';} ?> </td>
				   		<?php } ?>  
						
						<?php if($j == 1) { ?>
				   	     <td rowspan='<?php echo $countResult2; ?>'  title="<?php if($row['review_email_time'] != '0000-00-00 00:00:00') { echo  changeDateFormate($row['review_email_time'],'timestamp'); }?>"><?php     if($row['jobStatus'] == 3 || $row['jobStatus'] == 1) {
                         if($row2['reclean_job'] == 1) {
							 
							 if($row2['job_type_id'] != 11) {
						 ?><a href="javascript:scrollWindow('review_email.php?type=job&job_id=<?php echo $row['id']; ?>','700','700')">Review Email</a><br>
				   	     <?php if($row['review_email_time'] != '0000-00-00 00:00:00') { echo  changeDateFormate($row['review_email_time'],'dm'); } } else { echo 'Removal Jobs'; }?>
				   	     
				   	     <?php  }else{ echo "(Re-Clean)"; } }else { ?>N/A <?php  } ?></td>
				   		<?php } ?>  
									
					</tr>
				
			<?php 
				$j++;
			
					}
					
					$j = 1;
				 
			 	} 
			 	
			?>
			<tr class="load_more">
		        <td colspan="15" class="load_more"><button class="loadmore" data-page="<?php echo  $pageid+1 ;?>">Load More</button></td>
		   </tr>
			  
	<?php 
	} 
	else
	{
	?> 
	<tr>
		<td colspan="15" >No Report Found</td>
	</tr>
	<?php
	}
}
?>