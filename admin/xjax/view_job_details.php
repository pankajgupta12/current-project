<table>
      <thead>
        <th></th>
        <th>Reset</th>
        <th>Type</th>
        <th>Staff</th>
        <th>Date</th>
        <th>Time</th>
        <th>Amount</th>
        <th>Discount</th>
        <th>Staff Amount</th>
        <th>Profit</th>
        <th>BCIC(% / F)</th>
        <th>Staff Paid</th>
        <!--<th>S/E Job</th>-->
        <th>SMS Send</th>
		<th>Notif Send</th>
        <th>DateTime</th>
      </thead>
      <tbody>
      <?php
		
		$job_picker_x = "";
		
		$job_details = mysql_query("select * from job_details where job_id=".$job_id." and status!=2");
        while($jdetails = mysql_fetch_assoc($job_details)){

		
				$startDate  = date('Y-m-d');
				$endDate = $jdetails['job_date'];

				$start_ts = strtotime($startDate);
				$end_ts = strtotime($endDate);
				$diff = ($end_ts - $start_ts);
				$noofday = intval($diff / 86400);
		
		
				
					$job_picker_x.= '$("#job_date_'.$jdetails['id'].'").datepicker({dateFormat:\'yy-mm-dd\'});'."\r\n";
					
					//$cond = " (site_id=".$jdetails['site_id']." or site_id2=".$jdetails['site_id'].") and status=1 and job_types like '%".$jdetails['job_type']."%'";
				//	$cond = " (site_id=".$jdetails['site_id']." or site_id2=".$jdetails['site_id']." OR find_in_set( ".$jdetails['site_id']." , all_site_id)) and status=1 and find_in_set('".$jdetails['job_type']."' , job_types)";
					$cond = " (site_id=".$jdetails['site_id']." or site_id2=".$jdetails['site_id']." OR find_in_set( ".$jdetails['site_id']." , all_site_id)) and status=1 and find_in_set('".$jdetails['job_type']."' , job_types)";
					//$onchange = "onchange=\"javascript:send_data('staff_id_".$jdetails['id']."','','div_staff_id_".$jdetails['id']."');\"";					
					$onchng = "onchange=\"javascript:assing_jobs('".$jdetails['id']."','".$jdetails['job_id']."','staff_id_".$jdetails['id']."');\" ";
					
					$resetonchng = "onClick=\"reset_assing_jobs('".$jdetails['id']."','".$jdetails['job_id']."','0');\" ";
					
					$opentab = "onclick=\"javascript:scrollWindow('staff_details.php?task=4&action=modify&id=".$jdetails['staff_id']."','1200','850');\" ";
					
					//echo  $cond;
				 
				    $job_Status = get_rs_value("jobs","status",$jdetails['job_id']);
					
                    if($job_Status == '3') {
					    $staffDetails = 	get_rs_value("staff","name",$jdetails['staff_id']);
					}else {
						$staffDetails  = create_dd_staff("staff_id_".$jdetails['id'],"staff","id","name",$cond,$onchng,$jdetails['staff_id']);
					}					
				
				   
					 if($jdetails['staff_id'] != 0 && $jdetails['job_type_id'] == '11') {
						 
						$truck_assign = "onchange=\"javascript:truck_assign('".$jdetails['id']."','".$jdetails['job_id']."','staff_truck_".$jdetails['id']."');\" ";
						 
                        $staff_truck = "staff_id = ".$jdetails['staff_id']."";
						$staffDetails.= '<br/>'.create_dd_staff("staff_truck_".$jdetails['id'],"staff_trucks","id","cubic_meters",$staff_truck,$truck_assign,$jdetails['staff_truck_id']);
					 }
				
				
				   // if($job_Status != '1') {
					if($jdetails['start_time'] != '0000-00-00 00:00:00'  || $jdetails['end_time'] != '0000-00-00 00:00:00'){  
						if($jdetails['start_time'] != '0000-00-00 00:00:00'){
						   $s_img = '<img src="../admin/images/check_agree.png" style="height: 23px;padding: 2px;"/>';
						   $s_startDate = $jdetails['start_time'];
						}else {
						   $s_img = '<img src="../admin/images/error_button.png" style="height: 23px;padding: 2px;"/>';	
						   $s_startDate = 'Not Started';
						}
						if($jdetails['end_time'] != '0000-00-00 00:00:00'){
							$e_img = '<img src="../admin/images/check_agree.png" style="height: 23px;padding: 2px;"/>';
							$endDate = $jdetails['end_time'];
						}else {
							$e_img = '<img src="../admin/images/error_button.png" style="height: 23px;padding: 2px;"/>';
							$endDate = 'Not Finished';
						}
					}
			     
					
				    if($jdetails['staff_id'] != 0) {
						 $denyonchng = "onClick=\"deny_assing_jobs('".$jdetails['id']."','".$jdetails['job_id']."','".$jdetails['staff_id']."');\" ";
						 $denybutton = '<br/><br/><button type="button" class="reser_button" id="reset_staff_id_'.$jdetails['id'].'" value="0" '.$denyonchng.'>Deny</button></td>';
				    } else{
					 $denybutton = '';
				    }
					$color_ch = '';
					
					
					//onblur="javascript:edit_field(this,\'job_details.discount\','.$jdetails['id'].');"
					
					if($jdetails['amount_status'] == 2) { $color_ch  =  'style=" background: #efdede;"'; }
				echo '<tr id="jdetails_'.$jdetails['id'].'" >
					  <td><a title="Delete" href="javascript:send_data(\''.$jdetails['id'].'\',22,\'jdetails_'.$jdetails['id'].'\')"><img src="images/cross.jpg"  alt=""/></a></td>
					  <td id="reset_staff_id_'.$jdetails['id'].'">
					     <button type="button" class="reser_button" id="reset_staff_id_'.$jdetails['id'].'" value="0" '.$resetonchng.'>Reset</button>'.$denybutton.'
					  <td>'.$jdetails['job_type'].'</td>
					  <td id="div_staff_id_'.$jdetails['id'].'">'.$staffDetails.'</td>
					  <td><input size="10" name="job_date_'.$jdetails['id'].'" type="text" id="job_date_'.$jdetails['id'].'"  value="'.$jdetails['job_date'].'" onblur="javascript:edit_field(this,\'job_details.job_date\','.$jdetails['id'].');"></td>
					  <td><input size="10" name="job_time_'.$jdetails['id'].'" type="text" id="job_time_'.$jdetails['id'].'"  value="'.$jdetails['job_time'].'" onblur="javascript:edit_field(this,\'job_details.job_time\','.$jdetails['id'].');"></td>
					  <td><input size="10" name="amount_total_'.$jdetails['id'].'" type="text" id="amount_total_'.$jdetails['id'].'" value="'.$jdetails['amount_total'].'" onblur="javascript:edit_field(this,\'job_details.amount_total\','.$jdetails['id'].');"></td>
					  <td><input size="10" name="discount_'.$jdetails['id'].'" style="background: #edebef;" readonly type="text" id="discount_'.$jdetails['id'].'" value="'.$jdetails['discount'].'" ></td>
					  <td '.$color_ch.'><input  '.$color_ch.' size="10" name="amount_staff_'.$jdetails['id'].'" type="text" id="amount_staff_'.$jdetails['id'].'" value="'.$jdetails['amount_staff'].'" onblur="javascript:edit_field(this,\'job_details.amount_staff\','.$jdetails['id'].');"></td>
					  <td><input size="10"  name="amount_profit_'.$jdetails['id'].'" type="text" id="amount_profit_'.$jdetails['id'].'" value="'.$jdetails['amount_profit'].'" onblur="javascript:edit_field(this,\'job_details.amount_profit\','.$jdetails['id'].');"></td><td>';
					  
					

					if($jdetails['staff_id'] != '0') {  
					   if($jdetails['amt_share_type'] == '') {
						  echo '<p style="cursor: pointer; color:red;">Please add bcic share</p>';
					   }else {
					      echo '<input size="10"  name="amt_share_type_'.$jdetails['id'].'" type="text" id="amt_share_type_'.$jdetails['id'].'" value="'.$jdetails['amt_share_type'].'" onblur="javascript:edit_field(this,\'job_details.amt_share_type\','.$jdetails['id'].');">';
					   }
					}else {
						echo "N/A";
					}
					  echo "</td><td>"; 
					   //echo $staffdetails;	  
					  if($jdetails['staff_paid']=="0"){ echo 'No'; }else{ echo 'Yes'; } 
					  echo '</td>';
                    // echo '<td>'.$s_img.' / '.$e_img.'</td>';					  
					 echo  '<td>';
					  
					  if($jdetails['staff_id'] != '0') {
						  
						   echo '<a href="javascript:send_data(\'job|'.$jdetails['id'].'\',25,\'send_job_sms_'.$jdetails['id'].'\');" class="whitespace">Job SMS</a><br/>';
							echo '<a href="javascript:send_data(\'address|'.$jdetails['id'].'\',25,\'send_address_sms_'.$jdetails['id'].'\');" class="whitespace" >Add SMS</a>';
							/*if($noofday <= 1)  {
								echo '<a href="javascript:send_data(\'address|'.$jdetails['id'].'\',25,\'send_address_sms_'.$jdetails['id'].'\');">Add SMS</a>';
							} */
							
						}else{
							  echo "N/A";
						}
						
						echo '</td>';
						
						echo  '<td>';
						if($jdetails['staff_id'] != '0') {
							
						   echo '<a href="javascript:send_data(\'job|'.$jdetails['id'].'||smstype'.'\',25,\'job_noti_date_'.$jdetails['id'].'\');" class="whitespace">Job Notif</a><br/>';
						   						 					   
						   
						   if($jdetails['job_notification_date'] != '0000-00-00 00:00:00')
						   {
							   $Notifdate = changeDateFormate($jdetails['job_notification_date'],'timestamp');
							   $Notifdatetitle = changeDateFormate($jdetails['job_notification_date'],'datetime');
						   }else {
							    $Notifdate = 'N/A';
							    $Notifatetitle = '';
						   }
						   
						   if($jdetails['add_notification_date'] != '0000-00-00 00:00:00')
						   {
							   $AddNotif = changeDateFormate($jdetails['add_notification_date'], 'timestamp');
							   $AddNotiftitle = changeDateFormate($jdetails['add_notification_date'], 'datetime');
						   }else {
							    $AddNotif = 'N/A';
							    $AddNotiftitle = '';
						   }
						   
						  echo  '<a id="job_noti_date_'.$jdetails['id'].'" class="whitespace" title="'.$Notifdate.'">'.$Notifdatetitle.'</a><br/>';
						  
						   
						   
							echo '<a href="javascript:send_data(\'address|'.$jdetails['id'].'||smstype'.'\',25,\'add_noti_date_'.$jdetails['id'].'\');" class="whitespace" >Add Notif</a><br/>';
							
							echo  '<a id="add_noti_date_'.$jdetails['id'].'" class="whitespace"  title="'.$AddNotif.'">'.$AddNotiftitle.'</a>';
							
						}else{
							echo "N/A";
						}
						echo '</td>';
						 
						echo '<td>';
						
						   if($jdetails['job_sms_date'] != '0000-00-00 00:00:00')
						   {
							   $SMSdate = changeDateFormate($jdetails['job_sms_date'],'timestamp');
							   $SMSdatetitle = changeDateFormate($jdetails['job_sms_date'],'datetime');
						   }else {
							    $SMSdate = 'N/A';
							    $SMSdatetitle = '';
						   }
						   
						   if($jdetails['address_sms_date'] != '0000-00-00 00:00:00')
						   {
							   $AddSMS = changeDateFormate($jdetails['address_sms_date'], 'timestamp');
							   $AddSMStitle = changeDateFormate($jdetails['address_sms_date'], 'datetime');
						   }else {
							    $AddSMS = 'N/A';
							    $AddSMStitle = '';
						   }
						   
						  echo  '<a id="send_job_sms_'.$jdetails['id'].'" class="whitespace" title="'.$SMSdate.'">'.$SMSdatetitle.'</a><br/>';
						  echo  '<a id="send_address_sms_'.$jdetails['id'].'" class="whitespace"  title="'.$AddSMS.'">'.$AddSMStitle.'</a>';
						echo '</td>';

					echo '</tr>';
				}
		
		
		?>
        </tbody>
    </table>
    <style>
       .reser_button{
          padding: 2px;
          width: 52px;
          border-radius: 0px;
           cursor: pointer;
        }  
		.whitespace {
			white-space: nowrap;
		}
    </style>
<script>
	$(function() {
		  <?php //echo $job_picker_x;?>
	});	
</script>