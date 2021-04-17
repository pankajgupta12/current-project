<div class="body_container">
	<div class="body_back">
		<span class="main_head">Job Assign details</span>
		  <div class="container"> 
 <?php 
   $stafid = $_GET['id'];
   $sql = "SELECT id,  quote_id, job_id ,  (SELECT CONCAT(name, ' ==== ', postcode, ' ==== ', suburb) as cdetails FROM quote_new WHERE id = job_details.quote_id) as cname ,   count(job_type_id) as jobtype , GROUP_CONCAT(job_type) as jtype ,  SUM(amount_total) as jobamount ,  SUM(amount_profit) as bcicamount , SUM(amount_staff) as samount , staff_id ,  job_date FROM  `job_details` WHERE staff_id = ".$stafid." AND job_id in (SELECT id FROM jobs WHERE status = 3) GROUP by job_id";

//echo $sql;

$query = mysql_query($sql);

$cnt = mysql_num_rows($query);

  ?>
    
	    <strong><center>Total Records <?php  echo $cnt;  ?></center></strong>
		
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
            			</tr>
            		</thead>
            		
            		<?php  
					
					$totalamt = 0;
					$totalstaffamt = 0;
					$totalbcicamt = 0;
					
            		if($cnt > 0) {
						while($data = mysql_fetch_array($query)) { 
						
						 $cdetails = explode('====' ,$data['cname']);
						
						$totalamt = $totalamt + $data['jobamount'];
						$totalstaffamt = $totalstaffamt + $data['samount'];
						$totalbcicamt = $totalbcicamt + $data['bcicamount'];
					?>
            		  
            		
                    		   <tr>
                				  <td><?php echo $data['quote_id']; ?></td>
                				  <td><?php echo $data['job_id']; ?></td>
                				  <td><?php echo changeDateFormate($data['job_date'], 'datetime'); ?></td>
                				  <td><?php echo $cdetails[0]; ?></td>
                				  <td><?php echo $cdetails[1]; ?></td>
                				  <td><?php echo $cdetails[2]; ?></td>
                				  <td><?php echo $data['jtype']; ?></td>
                				  <td><?php echo number_format($data['jobamount'], 2); ?></td>
                				  <td><?php echo number_format($data['samount'],2); ?></td>
                				  <td><?php echo number_format($data['bcicamount'],2); ?></td>
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
            			<?php  } ?>
            			
            				
         	</table>

		</div>
		
    </div>
</div>