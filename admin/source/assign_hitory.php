<style>
th {
    height: 30px;
    text-align: center;
}
table, td, th {
    border: 1px solid black;
}
</style>

<!------ Include the above in your HEAD tag ---------->
<div class="body_container">
	<div class="body_back">
	  <span class="main_head" style="margin-bottom: -33px;">Job  Assign History</span>
	   <span id="message_show"></span>
		<br/>
		<br/>
		<br/>
		 <?php  
		 
		  $job_id = $_REQUEST['job_id'];
		 $sql = mysql_query("SELECT  job_id ,  job_type_id ,  job_type ,  site_id, job_date FROM `job_details` WHERE job_id = ".$job_id." AND status != 2 order by job_type_id asc");
		 
		
		 ?>
         <br>
			<div id="save_clener_notes" class="col-md-12"> 
				<table  border="1">
					<tr>
						 <td><strong>Job Type</strong></td>
						 <td><strong>Denied</strong></td>
						 <td><strong>Available</strong></td>
						 <td><strong>Already Has a Job</strong></td>
					</tr>
				   
				   <?php   

          while($data = mysql_fetch_assoc($sql)) {
		            $denieddata =  JobDeniedStaff($job_id, $data['job_type_id']);
			        $availdata = CheckAVailStaffdata($data['site_id'], $data['job_type_id'] , $data['job_date']);
			        $getHaveJob = getHaveJob($data['site_id'], $data['job_type_id'] , $data['job_date']);
					
				
					 $availdata1 = explode(',', $availdata['staffid']);
					$availdata=array_diff($availdata1 ,$denieddata);
					
				   ?>
				    <tr>
						<td><?php  echo $data['job_type']; ?></td>
						<td><?php if(!empty($denieddata)) {  echo implode(',' ,$denieddata); }else{ echo 'N/A';} ?></td>
						<td><?php if(!empty($availdata)) { echo implode(', ' ,$availdata); } else { echo 'N/A'; } ?></td>
						<td><?php if(!empty($getHaveJob['staffid'])) {  echo implode(', ' ,$getHaveJob); } else { echo 'N/A'; }?></td>
				    </tr>
           <?php 
     unset($denieddata);
     unset($availdata);
     unset($getHaveJob);

		   } ?>				
				
				</table>
				
			</div> 
<br>
</div>

