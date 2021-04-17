<style>
th {
    height: 30px;
    text-align: center;
}
table, td, th {
    border: 1px solid black;
    text-align: center;
    padding: 4px;
}
</style>

<!------ Include the above in your HEAD tag ---------->
<div class="body_container">
	<div class="body_back">
	  <span class="main_head" style="margin-bottom: -33px;">Task  Assign History</span>
	   <span id="message_show"></span>
		<br/>
		 <?php  
		 
		  $job_id = $_REQUEST['job_id'];
		  $sql = mysql_query("SELECT *  FROM `site_notifications` WHERE `job_id` = 	".$job_id." order by id asc");
		 
		
		 ?>
         <br>
			<div id="save_clener_notes" class="col-md-12"> 
				<table  border="1">
					<tr>
						 <td><strong>Sr No</strong></td>
						 <td><strong>Subject</strong></td>
						 <td><strong>Comment</strong></td>
						 <td><strong>Noti Form</strong></strong></td>
						 <td><strong>Assigned To</strong></strong></td>
						 <td><strong>Task Status</strong></strong></td>
						 <td><strong>Status</strong></strong></td>
						 <td><strong>Read Admin</strong></strong></td>
						 <td><strong>Read date</strong></strong></td>
						 <td><strong>Date</strong></strong></td>
					</tr>
				   
				   <?php   
               $i = 1;
               while($data = mysql_fetch_assoc($sql)) {
		           /* $denieddata =  JobDeniedStaff($job_id, $data['job_type_id']);
			        $availdata = CheckAVailStaffdata($data['site_id'], $data['job_type_id'] , $data['job_date']);
			        $getHaveJob = getHaveJob($data['site_id'], $data['job_type_id'] , $data['job_date']);
					
				
					 $availdata1 = explode(',', $availdata['staffid']);
					$availdata=array_diff($availdata1 ,$denieddata);*/
				   $adminname = get_rs_value('admin','name',$data['login_id']);
					
					//explode(',',$data['staff_name']);
					 $userinfo = explode('_', explode(',',$data['notification_read_user'])[0]);
					 
				//	 print_r($userinfo);
					
				   ?>
				    <tr>
						<td><?php  echo $i; ?></td>
						<td><?php echo  $data['heading']; ?></td>
						<td><?php echo  $data['comment']; ?></td>
						<td><?php echo  $data['staff_name']; ?></td>
						<td><?php echo  $adminname; ?></td>
						<td><?php echo 	getSystemDDname($data['message_status'], 135); ?></td>
						<td><?php  if($data['notifications_status'] == 0) {echo 'Pending'; }else { echo 'Done'; } ?></td>
						<td><?php echo $userinfo[0]; ?></td>
						<td><?php  if($userinfo[1] !='') { echo date('dS M Y H:m A' , strtotime(str_replace(array('(',')'), array('',''),$userinfo[1]))); } ?></td> 
						<td><?php echo  date('dS M Y H:m A' , strtotime($data['date'])); ?></td>
				    </tr>
           <?php 
            $i++;

		   } ?>				
				
				</table>
				
			</div> 
<br>
</div>

