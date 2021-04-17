<?php  
 $stafid = $_GET['id']; $page = $_GET['page'];
$stafname = explode(' ', get_rs_value("staff","name",$stafid))[0]; ?>
<div class="body_container">
	<div class="body_back">
		<span class="main_head"><?php echo $stafname; ?> Job Report</span>		 <input type="button" value="Active" class="<?php if($page=="1"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='staff_details.php?task=staff_job_report&page=1&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;"/>		 		 <input type="button" value="Complete" class="<?php if($page=="2"){ echo 'staff_button_over'; }else{ echo 'staff_button'; } ?>" onclick="javascript:window.location='staff_details.php?task=staff_job_report&page=2&id=<?php echo $_REQUEST['id']; ?>';" style="float:left; margin-right:10px;"/>		
		  <div class="container"> 
 <?php   if($page == 1) {	  $status = 1;  }else if($page == 2){	   $status = 3;  }
  
   //$sql = "SELECT id,  quote_id, job_id ,  (SELECT CONCAT(name, ' ==== ', postcode, ' ==== ', suburb) as cdetails FROM quote_new WHERE id = job_details.quote_id) as cname ,   count(job_type_id) as jobtype , GROUP_CONCAT(job_type) as jtype ,  SUM(amount_total) as jobamount ,  SUM(amount_profit) as bcicamount , SUM(amount_staff) as samount , staff_id ,  job_date FROM  `job_details` WHERE staff_id = ".$stafid." AND job_id in (SELECT id FROM jobs WHERE status = 3) GROUP by job_id";
   
   $sql = "SELECT id,  quote_id, job_id , reclean_job,  count(job_type_id) as jobtype , GROUP_CONCAT(job_type_id) as jobtypeid,  GROUP_CONCAT(job_type) as jtype ,  SUM(amount_total) as jobamount ,  SUM(amount_profit) as bcicamount , SUM(amount_staff) as samount , staff_id ,  job_date FROM  `job_details` WHERE staff_id = ".$stafid." AND job_id in (SELECT id FROM jobs WHERE status = $status) GROUP by job_id ORDER BY job_date asc";

//echo $sql;

$query = mysql_query($sql);

$cnt = mysql_num_rows($query);

  ?>
    
	    <strong><center>Total Records <?php  echo $cnt;  ?></center></strong>
		
		   <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table staff-loc-list">	 
            		<thead style="text-align:center;">
            			<tr class="table_cells" style="height:50px;">
							<td><strong>Id</strong></td>
							<td><strong>Quote id</strong></td>
							<td><strong>Job Id</strong></td>
							<td><strong>Job Date</strong></td>
							<td><strong>Type</strong></td>
							<td><strong>Total Payment</strong></td>
							<td><strong>BCIC Payment</strong></td>
							<td><strong><?php echo $stafname; ?> Payment</strong></td>
							<td><strong>Quote Hours</strong></td>
							<td><strong>Working Quote</strong></td>
							<td><strong>Team Size</strong></td>
							<td><strong>Re-Clean</strong></td>
							<td><strong>Review</strong></td><?php   if($page == 2) { ?>
							<td><strong>Send Full Time</strong></td><?php  } ?>
            			</tr>
            		</thead>
            		
            		<?php  
					
					$totalamt = 0;
					$totalstaffamt = 0;
					$totalbcicamt = 0;
					$i = 1;
					$totalworktime = 0;
					$teamsize = 0;
					$work_hr = 0;
					
					
					
            		if($cnt > 0) {
						while($data = mysql_fetch_array($query)) { 
						
						// $cdetails = explode('====' ,$data['cname']);
						
						$jobid = $data['job_id'];
						
						$totalamt = $totalamt + $data['jobamount'];
						$totalstaffamt = $totalstaffamt + $data['samount'];
						$totalbcicamt = $totalbcicamt + $data['bcicamount'];
						
						
						$quote_hr   = get_quote_details($data['quote_id'] , $data['jobtypeid']);
						
						if(in_array(1, array(1,2,3,4,5))) {
						   $getdetails = get_total_work_hr($jobid , $quote_hr);
						  // print_r($getdetails);
						  $work_hr = $getdetails['work_hr'];
						  $totalworktime = $getdetails['total_work'];
						  $teamsize = $getdetails['team_size'];
						}
						
						 $overall_experience =  getoverallratting($jobid);
						 
						 $full_time_date = get_rs_value("quote_new","full_time_date",$data['quote_id']); 
					?>
            		  
            		
                    		   <tr>
                				  <td><?php echo $i; ?></td>
                				   <td><?php echo $data['quote_id']; ?></td>
                				  <td><?php echo $jobid; ?></td>
                				  <td><?php echo changeDateFormate($data['job_date'], 'datetime'); ?></td>
                				  <td><?php echo $data['jtype']; ?></td>
								   <td><?php echo number_format($data['jobamount'], 2); ?></td>
								   <td><?php echo number_format($data['bcicamount'],2); ?></td>
                				  <td><?php echo number_format($data['samount'],2); ?></td>
                				  
                				  <td><?php if($quote_hr > 0 ) {  echo $quote_hr; } ?></td>
                				  <td><?php if($totalworktime > 0 ) { echo $totalworktime; } ?></td>
                				  <td><?php echo $teamsize; ?></td>
                				  <td <?php if($data['reclean_job'] == 2) { ?> style="background-color:#e89797;"  <?php  }  ?>><?php if($data['reclean_job'] == 2) { echo 'Yes'; }  ?></td>
                				  <td><?php if($overall_experience > 0) { echo $overall_experience; }  ?></td>								  								 <?php   if($page == 2) { ?> 
                				  <td id="send_full_info_<?php echo $jobid;  ?>"><?php  if($full_time_date != '0000-00-00 00:00:00') { echo changeDateFormate($data['job_date'], 'datetime'); } else { ?> <a href="javascript:void(0);" onclick="send_data('<?php echo $jobid; ?>' , 525,'send_full_info_<?php echo $jobid;  ?>')">Send </a><?php  } ?></td>								 <?php  } ?> 
                				 
                    			</tr>
            		
            		
            		<?php $i++; } ?>
                            <tr>
                                  <td colspan="5"><h4>Total Amount</h4></td>
                                  <td><h4><?php echo number_format($totalamt,2); ?></h4></td>
								   <td><h4><?php echo number_format($totalbcicamt, 2); ?></h4></td>
                                  <td><h4><?php echo number_format($totalstaffamt, 2); ?></h4></td>
                                 
                                  <td colspan="6"></td>
							</tr>	  
					<?php  }else { ?>
            		
            		<tbody class="table_scrol_location">
            						<tr class="table_cells">
            				   <td colspan="3">No result</td>
            				   
            				</tr>
            					</tbody>
            			<?php  } ?>
            			
            				
         	</table>

		</div>
		
    </div>
</div>


<?php  
 
  function get_quote_details($quotid, $jobtypeid){
	  
	 // echo "SELECT id, job_type_id, job_type, SUM(hours) as whr FROM `quote_details`   WHERE quote_id = ".$quotid." and job_type_id in (".$jobtypeid.")";
	   $job_details = mysql_fetch_array(mysql_query("SELECT id, job_type_id, job_type, SUM(hours) as whr FROM `quote_details`   WHERE quote_id = ".$quotid." and job_type_id in (".$jobtypeid.")"));
	   
	   return $job_details['whr'];
	   
  }
  
  function getoverallratting($jobid){
	  
	  $overall_experience = 0;
	   $query = mysql_query("SELECT overall_experience FROM `bcic_review` WHERE  job_id = ".$jobid."");
	   
	   if(mysql_num_rows($query) > 0) {
	        $job_details = mysql_fetch_array($query);
	       $overall_experience =  $job_details['overall_experience'];
	   }
	   return $overall_experience;
  }
   

 ?>