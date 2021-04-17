<?
	if(!isset($_SESSION['reclean']['reclean_from_date'])){ $_SESSION['reclean']['reclean_from_date'] = date("Y-m-1"); }
	if(!isset($_SESSION['reclean']['to_date'])){ $_SESSION['reclean']['to_date'] = date("Y-m-t"); }
	if(!isset($_SESSION['reclean']['status'])){ $_SESSION['reclean']['status'] = 5; }
	
	

    
        $resultsPerPage = resultsPerPage;

        $arg = "SELECT J.site_id as site_name,J.id as jobID,R.staff_id as StaffID,R.reclean_date as recleandate,R.start_time as start,R.end_time as end,R.reclean_time as recleantime, J.status as JobStatus, J.review_email_time as review_email_time, R.quote_id as QuoteID FROM `job_reclean` R join jobs J  on R.job_id = J.id   where 1= 1 AND   R.status != 2 ";

		if(isset($_SESSION['reclean']['status']) && $_SESSION['reclean']['status'] != 0 )
		{
			$arg .= " AND J.status  = ".$_SESSION['reclean']['status'];
		}

		if(isset($_SESSION['reclean']['reclean_from_date']) && $_SESSION['reclean']['to_date'] != NULL && $_SESSION['reclean']['to_date'] != 0 )
		{
			$arg .= " AND R.reclean_date >= '".date('Y-m-d',strtotime($_SESSION['reclean']['reclean_from_date']))."' AND R.reclean_date <='".$_SESSION['reclean']['to_date']."'";
		}

		if(isset($_SESSION['reclean']['site_id']) && $_SESSION['reclean']['site_id'] != NULL  &&  $_SESSION['reclean']['site_id'] != 0)
		{
			$arg .= " AND R.site_id = ".$_SESSION['reclean']['site_id'];
		}
				
		$arg .=	" Group by R.job_id  ORDER BY R.reclean_date asc";
	
	
 //echo $arg;

$data = mysql_query($arg);
$countResult = mysql_num_rows($data);
?>

		<div class="right_text_box" >
		    <div class="midle_staff_box"> <span class="midle_text">Total Records Found <?php echo $countResult; ?> </span></div>
		</div>
<div class="usertable-overflow">
	<table class="user-table">
	  <thead>
	  <tr>
		<th>Job Id</th>
		<th>Site</th>
        <th>Q Name</th>
        <th>Reclean Date</th>
        <th>Total Amount</th> 
		<th>Payment</th>
		<th>Job Type</th>
		<th>Job Amount</th>   
		<th>Reclean dateTime</th>	
		<th>Staff Name</th>   
		<th>Re-Clean Job SMS</th>
		<th colspan="6">Staff Re-Clean Job Work</th>
		<th>Email Agent</th>   
		<th>Job Status</th>   
		<th>Review Email</th>  
		
	  </tr>	  
	  <tr>
		<th></th>
		<th></th>
		<th></th>
        <th></th>
        <th></th>
        <th></th>		       
		<th></th>
        <th></th>
        <th></th>
         <th></th>
         <th></th>
         <th>Start</th> <th>End</th> <th>Before Img</th> <th>After Img</th><th>All SMS</th> <th>Re-Clean Status</th>
         <th></th>
         <th></th>
         <th></th>
        
	  </tr>
	  </thead>
		
		<tbody id="get_loadmoredata">
			<?php
			if (mysql_num_rows($data)>0){ 
			    
			    $row1 = 1;
			   	$counter = 0;
				while( $row = mysql_fetch_assoc($data) ) 
				{ 
				   
				   // print_r($row);
				   
				     $counter++;
				     $bgcolor = ($counter % 2 === 0) ? 'alert_even_tr' : 'alert_odd_tr';
                        
					$j = 1;
					
					$job_id = $row['jobID'];
					
					$arg2 = "SELECT *
					FROM job_reclean
					WHERE job_id = '".$job_id."' AND status != 2
					";
					//echo $arg2;
					$data2 = mysql_query($arg2);
					$countResult2 = mysql_num_rows($data2);
					$sumamount = 0;
				   if(mysql_num_rows($argSql) == 0)	{		    
					while($row2 = mysql_fetch_assoc($data2) )
					{    
					
					    $getRecl['amount_total'] = get_sql("job_details","amount_total","WHERE job_id = '".$job_id."' AND status != 2 AND job_type_id=".$row2['job_type_id']." AND reclean_job = 2");
					
					
				    	$siteDetails =  mysql_fetch_assoc(mysql_query("select name, abv from sites  where id = ".$row['site_name'].""));
					
			?>
					<tr  class="parent_tr <?php if(callPaytype($row['jobID']) == 'No Payment Found!') {echo "alert_danger_tr";}else{ echo $bgcolor;} ?>">
					   
					  	<?php if($j == 1) { ?>
						  <td rowspan='<?php echo $countResult2; ?>' ><a href="javascript:scrollWindow('popup.php?task=job_reclean&job_id=<?php echo $row['jobID']; ?>','1200','850')"><?php echo $row['jobID']; ?></a></td>
						<?php } ?>
						
					 	<?php if($j == 1) { ?>
					    	<td rowspan='<?php echo $countResult2; ?>' title="<?php  echo  $siteDetails['name']; ?>"><?php  echo  $siteDetails['abv']; ?></td>
						<?php } ?>
						
						<?php if($j == 1) { ?>
						 <td rowspan='<?php echo $countResult2; ?>'><?php echo ucwords(get_rs_value("quote_new","name",$row['QuoteID'])); ?></td>
						<?php } ?>
					
					   	<?php  if($j == 1) { ?>
					     <td rowspan='<?php echo $countResult2; ?>'><?php echo changeDateFormate($row['recleandate'],'datetime'); ?></td>
					   <?php } ?>
					   
					   	<?php/* if($j == 1) { ?>
					     <td rowspan='<?php echo $countResult2; ?>'><?php echo $row['recleantime']; ?></td>
					   <?php } */ ?>
						
						<?php if($j == 1) { ?>
						  <td rowspan='<?php echo $countResult2; ?>'><?php echo gettotalamount($row['jobID']);  //echo $gettotal['tamount'];  ?></td>
						<?php } ?>   
						
						<?php if($j == 1) { ?>
						<td rowspan='<?php echo $countResult2; ?>'><?php echo callPaytype($row['jobID']); ?></td>
						<?php } ?>   
							<!--<td><?php echo $row2['job_type']; ?></td>-->
                        <td>
                            <?php $job_icon =  get_rs_value("job_type","job_icon",$row2['job_type_id']);  ?>
					          <img class="image_icone" src="icones/job_type32/<?php echo $job_icon." "; ?>" alt="<?php echo $row2['job_type']." "; ?>" title="<?php echo $row2['job_type']." "; ?>">
						</td>							
							<td><?php echo $getRecl['amount_total']; ?></td>
						<td><?php echo changeDateFormate($row2['reclean_date'],'datetime')."<br/>".$row2['reclean_time']; ?></td>	
						
						<td><?php if($row2['staff_id'] != '0') { echo  get_rs_value("staff","name",$row2['staff_id']); }else { echo "Not Assign";} ?></td>	
					
							<td id="job_sms_<?php echo $row2['id'];?>" title="<?php  if($row2['job_sms'] == '1') { echo changeDateFormate($row2['job_sms_date'],'timestamp'); } ?>">
									<?php  if($row2['staff_id'] != '0') { ?>
									<input type="checkbox" name="job_sms" <?php  if($row2['job_sms'] == '1') { ?> onChange="send_data('job|<?=$row2['id'];?>|<?php echo $row2['job_sms']; ?>',176,'quote_view');" <?php }else { ?> onClick="send_data('job|<?=$row2['id'];?>|report',174,'quote_view');" <?php  } ?> value="<?php echo $row2['job_sms']; ?>" <?php echo ($row2['job_sms']==1 ? 'checked' : '');?>>
									  <?php  if($row2['job_sms'] == '1') { echo changeDateFormate($row2['job_sms_date'],'datetime'); }else {
									?>
									  <input type="submit" style="border: 1px solid;background: #d2dae3;width: 60px;" value="Job Send" class="buttone_msgsend" onClick="send_data('job|<?=$row2['id'];?>|report',174,'quote_view');" >
									 
									<?php  } } else { echo "--"; }?>
							</td>
						
							<td title="<?php  if($row2['start_time'] != '0000-00-00 00:00:00') {echo changeDateFormate($row2['start_time'],'timestamp'); }?>"><?php  if($row2['start_time'] != '0000-00-00 00:00:00') {echo changeDateFormate($row2['start_time'],'datetime'); }else {   if($row2['job_type_id'] == 1) { ?><a href="javascript:scrollWindow('reclean_sms_for_staff.php?sms_task=start_job&job__details_id=<?php echo $row2['id']; ?>','400','400')">SMS Start</a><?php }else { echo "No Started";}  } ?></td>
							
							<td title="<?php if($row2['end_time'] != '0000-00-00 00:00:00') { echo changeDateFormate($row2['end_time'],'timestamp'); }?>"><?php if($row2['end_time'] != '0000-00-00 00:00:00') { echo changeDateFormate($row2['end_time'],'datetime'); }else {  if($row2['job_type_id'] == 1) { ?><a href="javascript:scrollWindow('reclean_sms_for_staff.php?sms_task=finish_job&job__details_id=<?php echo $row2['id']; ?>','400','400')">SMS Finish</a><?php  } else { echo  "Not Finished";} } ?></td>
							
							<td><?php 
							$beforeImg = checkBeforeImageUpload($row2['job_id'],$row2['staff_id'] , 1);
							if($beforeImg > 0) { echo "Yes"; }else { if($row2['job_type_id'] == 1) { ?><a href="javascript:scrollWindow('reclean_sms_for_staff.php?sms_task=before_img&job__details_id=<?php echo $row2['id']; ?>','400','400')">SMS Befor Img</a><?php  }else { echo "No";} }?></td>
							
							<td><?php 
							$afterImg = checkBeforeImageUpload($row2['job_id'],$row2['staff_id'] , 2);
							if($afterImg > 0) { echo "Yes"; }else { if($row2['job_type_id'] == 1) { ?><a href="javascript:scrollWindow('reclean_sms_for_staff.php?sms_task=after_img&job__details_id=<?php echo $row2['id']; ?>','400','400')">SMS after Img</a><?php  }else { echo "No";} }?></td>
							
							<td><?php if($row2['job_type_id'] == 1) { ?><a href= "javascript:scrollWindow('reclean_sms_for_staff.php?sms_task=all_sms&job__details_id=<?php echo $row2['id']; ?>','400','400')">All SMS</a> <?php  } else { "N/A"; } ?></td>
							
                          
							
							<td><?php echo  getSystemDDname($row2['reclean_status'],37);  ?></td>	
							
							  <?php  
							//  echo  "Select agent_email from job_details where job_id = ".$row2['job_id']." AND status !=  2";
						    $getemailAgent = mysql_fetch_assoc(mysql_query("Select agent_email from job_details where job_id = ".$row2['job_id']." AND status !=  2"))
						   
						    ?>
							<?php  if($j == 1) { ?>
								<td rowspan='<?php echo $countResult2; ?>' id="agent_email_<?php  echo $row2['job_id']; ?>" title="<?php if($row2['agent_email_sent_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($row2['agent_email_sent_date'], 'timestamp'); }?>">
								
								<a style="color:blue;cursor: pointer;" href="javascript:scrollWindow('reclean_agent_email.php?job_id=<?php echo $row2['job_id']; ?>','750','750')">Send Email</a><br>
								<?php if($row2['agent_email_sent_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($row2['agent_email_sent_date'], 'timestamp'); }?>
								
								   <?php  /* if($row2['agent_email_sent_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($row2['agent_email_sent_date'], 'datetime'); }elseif($getemailAgent['agent_email'] != '') { ?><a style="color:blue;cursor: pointer;" href="javascript:scrollWindow('reclean_agent_email.php?job_id=<?php echo $row2['job_id']; ?>','750','550')">Send Email</a><?php  }else{ echo 'No Email'; }  */?> 
								   
								</td>
						  <?php }  ?>  	
						  
					
						<?php if($j == 1) { ?>	
							<td rowspan='<?php echo $countResult2; ?>'><?php echo  getSystemDDname($row['JobStatus'],26);  ?></td>
						<?php } ?>	
						
						<?php if($j == 1) { ?>
				   	       <td rowspan='<?php echo $countResult2; ?>' title="<?php if($row['review_email_time'] != '0000-00-00 00:00:00') { echo  changeDateFormate($row['review_email_time'],'timestamp'); }?>"><?php if($row['JobStatus'] == '3' || $row['JobStatus'] == '1') { ?><a href="javascript:scrollWindow('review_email.php?type=reclean&job_id=<?php echo $row['jobID']; ?>','700','700')">Review Email</a>
				   	       <?php if($row['review_email_time'] != '0000-00-00 00:00:00') { echo  changeDateFormate($row['review_email_time'],'datetime'); }?>
				   	          
				   	       <?php  }else { ?>N/A <?php   } ?><?php //  echo  getSystemDDname($row['JobStatus'],26);  //$row['JobStatus'];	   ?></td>
				   		<?php } ?> 
						
					
					</tr>
				
			<?php 
				$j++;
			
					}
				   }
					
					$j = 1;
				 
			 	} 
			 	
			?>
			<?php if($countResult >= $resultsPerPage) { ?>
			<!--<tr class="load_more">
	         <td colspan="15"><button class="loadmore" data-page="2" >Load More</button></td>
			</tr>-->
			<?php } }else { ?>
          <tr>
	         <td colspan="25">No records</td>
			</tr>
			<?php  } ?>
		</tbody>

	     
	</table>


</div>

<style>
   .buttone_msgsend
   {
        width: 50px;
        border: 1px solid;
        background: green;
        cursor: pointer;
        padding: 3px;

    }

</style>
