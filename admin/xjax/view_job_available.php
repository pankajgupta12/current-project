 <?php  

if($_SESSION['job_avail']['job_type_id'] == "") { $_SESSION['job_avail']['job_type_id'] = 1;} 
	
		$today = date('Y-m-d');
		$next_day = date('Y-m-d', strtotime("+15 day"));

      $sitename =  mysql_query("SELECT id , name FROM `sites`");
	
 ?>
 
 <span class="staff_text" style="margin-bottom:25px;margin-left: 19px;">Job Availablity by Day</span><br/>
     <span><?php // echo ('Record has been successfully updated');  ?></span>
	 
	 <?php if($_SESSION['job_avail']['job_type_id'] != 0 && $_SESSION['job_avail']['job_type_id'] !='') { ?>
	   <h3 style="text-align:  center;color: #00b8d4;padding: 7px;">Job Type :  <?php echo get_rs_value("job_type","name",$_SESSION['job_avail']['job_type_id']);  ?></h3>
	 <?php  } ?>
	 
    <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
	<tr class="table_cells">
		  <td>Site</td>
		<?php for($i=0; $i<= 15; $i++) { ?>  
		     <td title="<?php  echo changeDateFormate(date('Y-m-d', strtotime("+".$i." day")), 'datetime');?>"> <?php  echo changeDateFormate(date('Y-m-d', strtotime("+".$i." day")), 'dm');?><br>(<?php echo date('l', strtotime("+".$i." day")); ?>)<br /> Jobs<strong>/</strong>Staff</td>
		<?php  } ?>
		  
	</tr>
    <?php  
	 while($getSitename = mysql_fetch_assoc($sitename)) {
		//foreach($getSiteName as $key=>$value) {
			$key = $getSitename['id'];
			$value = $getSitename['name'];
	?>
			<tr class="table_cells">
			
			  <td ><?php  echo $value;  ?></td>
			  <?php 
			   $totalCountjob = 0;
			   $getTotalJob = array();
			   $getTotalstaffall = array();
			  for($k = 0; $k <= 15; $k++) { 
			 
                $day_name = date('l', strtotime("+".$k." day"));	
                  			
			     $staffSql = ("SELECT  GROUP_CONCAT(id) as staff_id  FROM `staff` WHERE site_id = ".$key." and status = 1  AND  no_work = 1  AND find_in_set ('".$day_name."' , avaibility)");
				 
				 if($_SESSION['job_avail']['job_type_id'] != 0 && $_SESSION['job_avail']['job_type_id'] !='') {
				   $staffSql .= "AND find_in_set ('".$_SESSION['job_avail']['job_type_id']."' , amt_share_type)";
				 }
				 
				$staffQuery =  mysql_query($staffSql);
				$getTotalStaff = mysql_fetch_assoc($staffQuery);
				 
							 
				$incressDate = date('Y-m-d', strtotime("+".$k." day"));
			   
					if(checkJobAvailable($key  , $incressDate) > 0) {
					   $class = "background:#d89a9a;border: 1px solid #000;cursor: pointer;";
					   $title = "We Are Fully Booked for this day";
					   $status = 1;
					}else{
					   $class = "background:#c6e4c6;border: 1px solid #000;cursor: pointer;";
					   $title = "Bookings Open ";
					   $status = 0;
					}
					
			    $checkJobSql = ("SELECT COUNT(*) as totalJob FROM `job_details` WHERE status !=2 AND site_id = ".$key." AND  job_date = '".$incressDate."' AND staff_id != 0 ");		
				 
				
				if($_SESSION['job_avail']['job_type_id'] != 0 && $_SESSION['job_avail']['job_type_id'] !='') {
				    $checkJobSql .= "AND job_type_id = ".$_SESSION['job_avail']['job_type_id']."";
				}
				 
				$checkJobSql .= " group by staff_id";
				
				
				//echo $checkJobSql;
				
				$checkJob = mysql_query($checkJobSql);
				
				if(mysql_num_rows($checkJob) > 0) {
					$totalJob = mysql_num_rows($checkJob); 
				}
				//echo $totalJob;
					
				$activestaffsql =  mysql_query("SELECT  count(staff_id) as totalActiveStaff  FROM `staff_roster` WHERE staff_id in  (".$getTotalStaff['staff_id'].") AND date = '".$incressDate."' AND status = 1");	
				
				if(mysql_num_rows($activestaffsql) > 0) {
					$activStaff =  mysql_fetch_assoc($activestaffsql);
				}
               
			  ?>  
			  
			    <td style="<?php echo $class; ?>" title="<?php echo $title; ?>" id="job_avil_<?php echo $key.'_'.$k; ?>" onClick="send_data('<?php echo $key; ?>|<?php echo $incressDate; ?>|<?php echo $status; ?>',254,'job_avil_<?php echo $key.'_'.$k; ?>');">
			  
					<br>
				   <?php if($totalJob > 0) { echo $totalJob; }else{ echo '-'; } ?> 
				   /
					<?php if($activStaff['totalActiveStaff'] > 0) {echo $activStaff['totalActiveStaff'];} else { echo '-'; } ?>
			   
			    </td>
			  <?php  
			   unset($totalJob);
			   unset($activStaff['totalActiveStaff']);
			   unset($getTotalStaff['staff_id']);
			  } ?>
			</tr> 
		<?php  } ?>	
		
		
    </table>