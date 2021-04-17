<?php 

  if(!isset($_SESSION['cehck_report']['today'])){ $_SESSION['cehck_report']['today'] = date("Y-m-d"); }
   $nextdate = date("Y-m-d", strtotime($_SESSION['cehck_report']['today'] . ' +1 day'));
   
   $date = $_SESSION['cehck_report']['today'];
   $sql = mysql_query("SELECT DISTINCT(staff_id) as staffid FROM `job_details` WHERE job_date in('".$date."' ,'".$nextdate."')  and status != 2 and staff_id != 0");

  $getallstaff = getAllStaffname();
  
  
  
  
		if(mysql_num_rows($sql) > 0)  {
			
		    while($data = mysql_fetch_assoc($sql)) {
				
			  $mobilenum = get_rs_value("staff","mobile",$data['staffid']);	
		?>
	
        
				
	
        <div style="top: 19px;left: 10px;">
	       <h3><?php echo $getallstaff[$data['staffid']]; ?>  ( <a href="tel:<?php echo $mobilenum; ?>"> <?php echo $mobilenum; ?> </a>) </h3> 
		</div>
	  <?php 
	  
	    
     	  $sql1 = mysql_query("SELECT id , job_id , job_type , job_type_id , job_date , start_time , end_time , team_size , admin_check ,next_day_admin_cehck , staff_id , called_status, called,job_time  FROM `job_details` WHERE (job_date = '".$date."'  OR job_date = '".$nextdate."')  and status != 2 and staff_id = ".$data['staffid']." AND job_id in (select id from jobs where status != 2) ORDER BY job_date ASC");
		   if(mysql_num_rows($sql1) > 0){ 
		   
		        while($getdata = mysql_fetch_assoc($sql1)) {
				       	$getjobdetails[$getdata['job_date']][$data['staffid']][] = $getdata;
				}
		   
		    }
			
			
			
	  ?>
			  <table style="width: 95%;border: 1px solid #000;margin: 29px;">
			  
			 

			 <?php  
   
     

	    // echo '<pre>'; print_r($getjobdetails);
	 
			 if(!empty($getjobdetails[$date][$data['staffid']])){ 
			   // if(in_array($data['staffid'] , $getjobdetails[$date])) {
			 ?>
			   <tr>
			   <td>
				 <h4>Today Job</h4>
						<table class="user-table">
							<thead class="myTable">
								<tr>
									<th>Job ID</th>
									<th>Job Type</th>
									<th>Start Time</th>
									 <th>Stop Time</th>
									<th>Team</th>
									<th>staff</th>
									<th>Before</th>
									<th>After</th>
									<th>Upsell</th>
									<th>NG</th>
									<th>CheckList</th>
									<th>Invoice</th>
									<th>Check</th>
									<th>Add Notes</th>
								</tr>
							</thead>
							  
							<tbody>
							   
							    <?php  
								$newJobID =0;
								
								foreach($getjobdetails[$date][$data['staffid']] as $key=>$todayJobs) {

                               	if($todayJobs['staff_id'] == $data['staffid'])	{						
								
								 if($todayJobs['job_id'] != $newJobID) {
									 $send_inv = 'Not';
								     $imagedetails = CountStaffImage($todayJobs['job_id'] , $data['staffid'] , 1 );
									 
									  $email_client_invoice = get_rs_value("jobs","email_client_invoice",$todayJobs['job_id']);	
									  if($email_client_invoice !='0000-00-00 00:00:00') {
										  $send_inv = $email_client_invoice;
									  }
								 }
									
									
								
								?> 
								 
									<tr class="parent_tr_1_<?php echo $todayJobs['id']; ?> <?php  if($todayJobs['admin_check'] == 1) { echo 'alert_danger_success '; }?>" >
									  <td><a href="javascript:scrollWindow('popup.php?task=job_type&job_id=<?php echo $todayJobs['job_id']; ?>','1200','850')"><?php echo $todayJobs['job_id']; ?></a></td>   
									  <td><?php echo $todayJobs['job_type']; ?></td>   
									  <td><?php echo $todayJobs['start_time']; ?></td>   
									  <td><?php echo $todayJobs['end_time']; ?></td>
									  <td><?php echo $todayJobs['team_size']; ?></td>
									  <td><?php echo $getallstaff[$todayJobs['staff_id']]; ?></td>
									  <td><?php echo $imagedetails['1']; ?></td>   
									  <td><?php echo $imagedetails['2']; ?></td>   
									  <td><?php echo $imagedetails['5']; ?></td> 
									  <td><?php echo $imagedetails['4']; ?></td> 
									  <td><?php echo $imagedetails['3']; ?></td> 
									   <td><?php echo $send_inv; ?></td> 
									  <td><input type="checkbox" name="admin_check" id="admin_cehck_<?php echo $todayJobs['id']; ?>" value="<?php echo $todayJobs['admin_check']; ?>" onClick="cehck3pM('<?php echo $todayJobs['id']; ?>',1);" <?php if($todayJobs['admin_check'] == 1) { echo 'checked';} ?>></td>   
									   <td onClick="addNotes('<?php echo $todayJobs['id']; ?>' , 1);">Add Notes</td>  
									</tr>
								<?php 
								 $imagedetails = $imagedetails;
									 $newJobID = $todayJobs['job_id'];
								} }
								?>
									   
							</tbody>
						</table>		
				</td>
					</tr>	
			 <?php }  ?>
			
		
 <?php  if(!empty($getjobdetails[$nextdate][$data['staffid']])){ ?>		
          <tr>
           <td>	
				<h4>Next Day Job</h4>
				<table class="user-table">
					<thead class="myTable">
						<tr>
							<th>Job ID</th>
							<th>Job Type</th>
							<th>Called</th>
							<th>Call Status</th>
							<th>Start Time</th>
							<th>Check</th>
							<th>Add Notes</th>
						</tr>
					</thead>
					  
					<tbody>
					   
					<?php  
						      
							   
								foreach($getjobdetails[$nextdate][$data['staffid']] as $key=>$nextJobs) { 
								 	if($nextJobs['staff_id'] == $data['staffid'])	{		
								?>	 
							<tr class="parent_tr_2_<?php echo $nextJobs['id']; ?>  <?php  if($nextJobs['next_day_admin_cehck'] == 1) { echo 'alert_danger_success '; }?>">
							  <td><a href="javascript:scrollWindow('popup.php?task=job_type&job_id=<?php echo $nextJobs['job_id']; ?>','1200','850')"><?php echo $nextJobs['job_id']; ?></a></td>   
							  <td><?php echo $nextJobs['job_type']; ?></td>   
							  <td id="called_<?php echo $nextJobs['id']; ?>"><?php  echo create_dd("called","system_dd","id","name","type=65","onchange=\"javascript:edit_field(this,'job_details.called',".$nextJobs['id'].");\"",$nextJobs); ?> </td>   
							  <td id="called_status_<?php echo $nextJobs['id']; ?>"><?php  echo create_dd("called_status","system_dd","id","name","type=100","onchange=\"javascript:edit_field(this,'job_details.called_status',".$nextJobs['id'].");\"",$nextJobs); ?> </td>   
							   <td style="background: white;border: 1px solid;padding: 4px;"><input type="text" id="job_time" value="<?php echo $nextJobs['job_time']; ?>" onblur="javascript:edit_field(this,'job_details.job_time','<?php echo  $nextJobs['id']; ?>');"></td>   
							  <td><input type="checkbox" name="admin_check" id="admin_cehck_<?php echo $nextJobs['id']; ?>" value="<?php echo $nextJobs['next_day_admin_cehck']; ?>" onClick="cehck3pM('<?php echo $nextJobs['id']; ?>',2);" <?php if($nextJobs['next_day_admin_cehck'] == 1) { echo 'checked';} ?>></td>   
							  <td onClick="addNotes('<?php echo $nextJobs['id']; ?>' , 2);">Add Notes</td>   
							</tr>
								<?php } }  ?>	
							   
					</tbody>
				</table>
		</td>
		</tr>
			<?php  } ?>
			
		<?php  
		
			$sql12 = mysql_query("SELECT id , job_id , job_type , admin_check, reclean_status , reclean_date,reclean_time , start_time , end_time FROM `job_reclean` WHERE staff_id =".$data['staffid']." and reclean_status != 5 and job_id in (select id from jobs where status = 5)"); 
			if(mysql_num_rows($sql12) > 0) {
		?>	
		<tr>
		
        <td>		
				<h4>Re-Clean Job </h4>
				<table class="user-table">
					<thead class="myTable">
						<tr>
							<th>Job ID</th>
							<th>Job Type</th>
							<th>Status</th>
							<th>Date</th>
							<th>Time</th>
							 <th>Start</th>
							 <th>Stop</th>
							<th>Before</th>
							<th>After</th>
							<th>CheckList</th>
							<th>Check</th>
							<th>Notes</th>
						</tr>
					</thead>
					  
					<tbody>
					    <?php  
					   
                         $recleanjobid = 0;
					     while($dataget = mysql_fetch_assoc($sql12)) { 
					   
					            if($dataget['job_id'] != $recleanjobid) {
								     $recleanimagedetails = CountStaffImage($dataget['job_id'] , $data['staffid'] , 2 );
								 }
					   
					       
					   ?>
						 
							<tr class="parent_tr_3_<?php echo $dataget['id']; ?> <?php  if($dataget['admin_check'] == 1) { echo 'alert_danger_success '; }?>" >
							  <td><a href="javascript:scrollWindow('popup.php?task=job_reclean&job_id=<?php echo $dataget['job_id']; ?>','1200','850')"><?php echo $dataget['job_id']; ?></a></td>   
							  <td><?php echo $dataget['job_type']; ?></td>   
							  <td id="reclean_status_<?php echo $dataget['id']; ?>"><?php
       							echo   create_dd("reclean_status","system_dd","id","name",'type=37',"onchange=\"javascript:edit_field(this,'job_reclean.reclean_status',".$dataget['id'].");\"",$dataget);
								
							 // echo create_dd("reclean_status","system_dd","id","name","type=37","",$dataget); ?></td>   
							  <td><?php echo $dataget['reclean_date']; ?></td>   
							  <td><?php // echo $dataget['reclean_time']; ?>
							   <input type="text" style=" border: 1px solid; margin: -38px; padding: 3px;" id="reclean_time" value="<?php echo $dataget['reclean_time']; ?>" onblur="javascript:edit_field(this,'job_reclean.reclean_time','<?php echo  $dataget['id']; ?>');">
							  </td>   
							  <td><?php echo $dataget['start_time']; ?>
							  </td>   
							  <td><?php echo $dataget['end_time']; ?></td>   
							  <td><?php echo $recleanimagedetails['1']; ?></td>   
							  <td><?php echo $recleanimagedetails['2']; ?></td>   
							  <td><?php echo $recleanimagedetails['3']; ?></td>   
							  <td><input type="checkbox" name="admin_check" id="admin_cehck_<?php echo $dataget['id']; ?>" value="<?php echo $nextJobs['admin_check']; ?>" onClick="cehck3pM('<?php echo $dataget['id']; ?>',3);" <?php if($dataget['admin_check'] == 1) { echo 'checked';} ?>></td>   
							  <td  onClick="addNotes('<?php echo $dataget['id']; ?>' , 3);">Add Notes</td>
							</tr>
					   <?php  
					   
							$recleanimagedetails = $recleanimagedetails;
							$recleanjobid = $dataget['job_id'];
					    } ?>
							   
					</tbody>
				</table>
		</td>
    </tr>
	 <?php   } ?>
	</tr>
		
    </table>	
	  <?php } } ?> 	
	  
<style>
	.dispatch_top_ul2 {
       width: 97%;
       padding: 20px 0;
    }
	#daily_view h3 {
       margin-left: 36px;
      } 
</style>	