<div class="body_container">
	<div class="body_back">
		<span class="main_head">Job Assign details</span>
		  <div class="container"> 
 <?php 
    $stafid = $_GET['id'];
	$getInfo = getOfferedInfo($stafid);
	//print_r($getInfo);
  ?>
    
	    <strong><center>Total Offer <?php  echo (count($getInfo['InfoData']));  ?><br/>Total Accepted <?php  echo ($getInfo['acc']);  ?><br/></center></strong>
		
		   <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table staff-loc-list">	 
            		<thead style="text-align:center;">
            			<tr class="table_cells" style="height:50px;">
							<td><strong>Quote id</strong></td>
							<td><strong>Job Id</strong></td>
							<td><strong>Job Date</strong></td>
							<td><strong>Name</strong></td>
							<td><strong>Postcode</strong></td>
							<td><strong>Suburb</strong></td>
							<td><strong>Job Type</strong></td>
							<td><strong>Job Amount</strong></td>
							<td><strong>Staff Amount</strong></td>
							<td><strong>BCIC Amount</strong></td>
							<td><strong>Offered date</strong></td>
            			</tr>
            		</thead>
            		
            		<?php  
					
					$totalamt = 0;
					$totalstaffamt = 0;
					$totalbcicamt = 0;
					if(!empty($getInfo['InfoData'])) 
					{
            		    foreach($getInfo['InfoData'] as $key=>$data) 
						{
						
							$cdetails = explode('====' ,$data['cname']);
							$getData = GetTotalAmountData_1($data['job_type_id'] , $data['job_id'] , $data['staff_id']);
					   	
                                $jobamount_1 = $getData['jobamount'];
                                $samount_1 = $getData['samount'];
                                $bcicamount_1 = $getData['bcicamount'];
					   	
									if($data['job_type_id'] > 0 && $jobamount_1 > 0) { 
										$jobtype =  jobImagesName($data['job_type_id']); 
											
											$jobamount = number_format($jobamount_1, 2);
											$samount = 	number_format($samount_1,2);
											$bcicamount = 	number_format($bcicamount_1,2); 
											
									}else{
										
										$jobtype_data = job_detailsdata($data['job_id'] , $data['staff_id']);
										
										$jobtype = $jobtype_data['jobtype'];
										$jobamount = number_format($jobtype_data['jobamount'], 2);
										$samount = 	number_format($jobtype_data['samount'],2);
										$bcicamount = 	number_format($jobtype_data['bcicamount'],2); 
									}
						
							$totalamt = $totalamt + $jobamount;
							$totalstaffamt = $totalstaffamt + $samount;
							$totalbcicamt = $totalbcicamt + $bcicamount;
							
							//$job_acc_deny = get_sql("job_details","job_acc_deny","where job_id=".$data['job_id']." AND staff_id = ".$data['staff_id']."  AND status != 2 AND job_type_id = 1 AND job_acc_deny in (1,3) GROUP by job_id");
					?>
            		  
            		
                    		   <tr class="parent_tr <?php if($data['job_acc_deny'] > 0) { ?> alert_danger_success <?php  } ?>">
                				  <td><?php echo $cdetails[3]; ?></td>
                				  <td><?php echo $data['job_id']; ?></td>
                				  <td><?php echo changeDateFormate($cdetails[4], 'datetime'); ?></td>
                				  <td><?php echo $cdetails[0]; ?></td>
                				  <td><?php echo $cdetails[1]; ?></td>
                				  <td><?php echo $cdetails[2]; ?></td>
                				  <td><?php echo $jobtype; ?></td>
                				  <td><?php echo $jobamount; ?></td>
                				  <td><?php echo $samount; ?></td>
                				  <td><?php echo $bcicamount; ?></td>
                				  <td title="<?php echo changeDateFormate($data['created_at'], 'timestamp'); ?>"><?php echo changeDateFormate($data['created_at'], 'timestamp'); ?></td>
                    			</tr>
            		
            		
            		<?php  } ?>
                            <tr>
                                  <td colspan="7"><h4>Total Amount</h4></td>
                                  <td><h4><?php echo number_format($totalamt,2); ?></h4></td>
                                  <td><h4><?php echo number_format($totalstaffamt, 2); ?></h4></td>
                                  <td><h4><?php echo number_format($totalbcicamt, 2); ?></h4></td>
							</tr>	  
					<?php  }else { ?>
            		
            		<tbody class="table_scrol_location">
            						<tr class="table_cells">
            				   <td colspan="3">No result</td>
            				   
            				</tr>
            		</tbody>
            	<?php   } ?>
            			
            				
         	</table>

		</div>
		
    </div>
</div>

<?php  

function jobImagesName($ids)
{

    $sql = mysql_query("select GROUP_CONCAT(name) as jname from job_type WHERE id in (".$ids.") ");

    $data = mysql_fetch_assoc($sql);
	return $data['jname'];
}



function GetTotalAmountData_1($jobtypeid , $job_id, $staff_id){
    
    $data['total_amount'] = 0;
    $data['bcicamount'] = 0;
    $data['samount'] = 0;
    $sql = mysql_query("SELECT SUM(total_amount) as jobamount , SUM(total_bcic_amt) as bcicamount , SUM(total_staff_amt) as samount  FROM ( Select * from `staff_jobs_status` WHERE `job_id` = ".$job_id." and status = 5 and job_type_id IN (".$jobtypeid.") AND staff_id = ".$staff_id."  GROUP by job_type_id ) as staff_jobs_status");

    $count = mysql_num_rows($sql);
    if($count > 0) {
	$data = mysql_fetch_assoc($sql);
	   return array('total_amount' => $data['total_amount'] ,'bcicamount' => $data['bcicamount'] ,'samount' => $data['samount']  );
    }
}

function job_detailsdata($jobid ,$staffid) {
	
	$sql = mysql_query("SELECT job_id, GROUP_CONCAT(job_type) as jobtype , SUM(amount_total) as jobamount,  SUM(amount_staff) as samount, SUM(amount_profit) as bcicamount FROM `job_details` WHERE job_id = ".$jobid." and staff_id = ".$staffid."");
	
	$count = mysql_num_rows($sql);
	$data = mysql_fetch_assoc($sql);
	
	if($data['job_id'] == 0 && $data['job_id']  == '') {
		//echo "SELECT job_id, GROUP_CONCAT(job_type) as jobtype , SUM(amount_total) as jobamount,  SUM(amount_staff) as samount, SUM(amount_profit) as bcicamount FROM `job_details` WHERE job_id = ".$jobid." ";
		$sql1 = mysql_query("SELECT job_id, GROUP_CONCAT(job_type) as jobtype , SUM(amount_total) as jobamount,  SUM(amount_staff) as samount, SUM(amount_profit) as bcicamount FROM `job_details` WHERE job_id = ".$jobid." ");
		$data = mysql_fetch_assoc($sql1);
	}
	
	return $data;
	
	
}


 ?>