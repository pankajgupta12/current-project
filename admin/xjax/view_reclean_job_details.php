    <table>
      <thead>
        <th>Delete</th>
        <th>Job Type</th>
        <th>Staff</th>
        <th>Reclean Date</th>
        <th>Time</th>
        <th>Status</th>
        <th>Re-Clean Status</th>
        <th>ReClean SMS Send</th>
		<th>ReClean Notification</th>
        <th>DateTime</th>
      </thead>
      <tbody>
      <?php
		
		
		
		$job_details = mysql_query("select * from job_reclean where job_id=".$job_id." and status!=2");
		if(mysql_num_rows($job_details)>0) {
			while($jdetails = mysql_fetch_assoc($job_details)){
						
					//	$resetonchng = "onClick=\"reset_assing_jobs('".$jdetails['id']."','".$jdetails['job_id']."','0');\" ";
						$staffName = get_rs_value("staff","name",$jdetails['staff_id']);
				
					echo '<tr id="jdetails_'.$jdetails['id'].'">
						  <td><a title="Delete" href="javascript:delete_reclean_jobs(\''.$jdetails['id'].'|'.$job_id.'\',173,\'jdetails_'.$jdetails['id'].'\')"><img src="images/cross.jpg"  alt=""/></a></td>
						  <td>'.$jdetails['job_type'].'</td>
						  <td id="div_staff_id_'.$jdetails['id'].'">'.$staffName.'</td>
						  <td><input size="10" name="reclean_date_'.$jdetails['id'].'" type="text" id="reclean_date_'.$jdetails['id'].'"  value="'.$jdetails['reclean_date'].'" onblur="javascript:edit_field(this,\'job_reclean.reclean_date\','.$jdetails['id'].');"></td>
						  <td><input size="10" name="reclean_time_'.$jdetails['id'].'" type="text" id="reclean_time_'.$jdetails['id'].'"  value="'.$jdetails['reclean_time'].'" onblur="javascript:edit_field(this,\'job_reclean.reclean_time\','.$jdetails['id'].');"></td>';
						  
						   echo '<td id="reclean_status_'.$jdetails['id'].'">'.create_dd("reclean_status","system_dd","id","name",'type=37',"onchange=\"javascript:edit_field(this,'job_reclean.reclean_status',".$jdetails['id'].");\"",$jdetails).'</td>';
						  
						  echo '<td id="reclean_work_'.$jdetails['id'].'">'.create_dd("reclean_work","system_dd","id","name",'type=86',"onchange=\"javascript:edit_field(this,'job_reclean.reclean_work',".$jdetails['id'].");\"",$jdetails).'</td>';
						
						  
						  echo "</td><td>"; 
						  
						  if($jdetails['staff_id'] != '0') {
							  
								echo '<a href="javascript:send_data(\'job|'.$jdetails['id'].'\',174,\'send_sms_date_'.$jdetails['id'].'\');" >Job SMS</a><br/>';
							}else{
								  echo "No assigned";
							}
							
							echo '</td><td>';
							
							if($jdetails['staff_id'] != '0') {
							  
								echo '<a href="javascript:send_data(\'address|'.$jdetails['id'].'||smstype'.'\',174,\'add_notif_date_'.$jdetails['id'].'\');" >Add Notification</a><br/>';
								
							   if($jdetails['add_notification_date'] != '0000-00-00 00:00:00')
							   {
							
								   $add_notification_date = $jdetails['add_notification_date'];
								   
							   }else {
								  
									$add_notification_date = 'N/A';
									
							   }
								
								echo  '<a id="add_notif_date_'.$jdetails['id'].'">'.$add_notification_date.'</a><br/>';
								
								
							}else{
								  echo "No assigned";
							}
							
							
							
							echo '<td>';
							  echo  '<a id="send_sms_date_'.$jdetails['id'].'">'.$jdetails['job_sms_date'].'</a><br/>';
							  //echo  '<a id="send_address_date_'.$jdetails['id'].'">'.$jdetails['address_sms_date'].'</a><br/>';
							 // echo  '<a id="send_email_date_'.$jdetails['id'].'">'.$jdetails['email_date'].'</a>';
							echo '</td>';
		  
						echo '</tr>';
						
					}
		}else {
			echo "<td colspan='10'>No record</td>";
		}
		
		
		?>
        </tbody>
    </table>
   
