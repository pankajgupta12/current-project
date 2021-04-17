<?php 

 //print_r($_SESSION['email_report_data']);
 
   if(!isset($_SESSION['email_report_data']['admin_id'])){ $_SESSION['email_report_data']['admin_id'] = 0; }
    
	if($_SESSION['email_report_data']['from_date'] != '') {
		$_SESSION['email_report_data']['from_date'] = $_SESSION['email_report_data']['from_date'];
	}else{
		$_SESSION['email_report_data']['from_date'] = date("Y-m-d");
	}
	
  $fromdate = date('Y-m-d 00:00:00' , strtotime($_SESSION['email_report_data']['from_date']));
  $todate = date('Y-m-d 23:59:00' , strtotime($_SESSION['email_report_data']['from_date']));
  
	$sql = "SELECT  DISTINCT(email_id) as email_id , id , activity , emailids , date_time , open_time , closed_time ,is_sent ,  staff_name FROM `email_activity`   WHERE date_time >=  '".$fromdate."' and date_time <=  '".$todate."' AND p_id  = 0";
   
    if($_SESSION['email_report_data']['admin_id'] != '0') {
        $sql .= " AND staff_id = ".$_SESSION['email_report_data']['admin_id']."";
    }
	
	$sql .= ' group by email_id Order by id desc';

	//echo  $sql;
	
	$query = mysql_query($sql);

	$count = mysql_num_rows($query);
	
	
	$fieldname = array('Email id' , 'Start-Time' , 'End-Time' , 'Total Time' , 'Activity' , 'Send Email'  , 'Admin Name');
    //$inout = array('' , '' , '' , '' , '');
   
 ?>


    <table class="start_table_tabe3"> 
	
			<thead>
				<tr>
				  <th>Email id</th>
				  <th>Start-Time</th>
				  <th>End-Time</th>
				  <th>Total Time</th>
				  <th>Activity</th>
				  <th>Send Email</th>
				  <th>Admin Name</th> 
				  <th>View Email</th> 
				</tr>
			</thead>	
				
	<?php  if($count > 0)  { 
	    while($data = mysql_fetch_assoc($query)) {
		   
		   
		   /*  $sql1 = mysql_query("SELECT * FROM `email_activity`   WHERE date_time >=  '".$fromdate."' and date_time <=  '".$todate."' AND  email_id = '".$data['email_id']."'");
		   
		   $countsubrec = mysql_num_rows($sql1); */
		   
		  $getallrecords =  getEmailsRecord($fromdate , $todate , $data['email_id'], $_SESSION['email_report_data']['admin_id']);
		  
		   $start_time = date('h:i:s A' , strtotime($data['open_time']));
		   if($data['closed_time'] != '0000-00-00 00:00:00') { $end_time =  date('h:i:s A' , strtotime($data['closed_time'])); }
		   if($data['is_sent'] == 1) {$is_sent =  'Yes'; }else {$is_sent =  'No'; }
		  
		  //$getouterdatagetouterdata[] = array($data['email_id'],$start_time,$end_time,'-',$data['activity'],$is_sent,$data['staff_name']);
		  
		 //
		  
		   
	?>			
			<tbody>
			
			    <tr id="delete_data_1">
				
					  <td><?php echo $data['email_id']; ?></td>
					  <td><?php echo $start_time; ?></td>
					  <td><?php echo $end_time;  ?></td>
					  <td><?php echo '-'; ?></td>
					  <td><?php echo $data['activity']; ?></td>
					  <td><?php if($data['is_sent'] == 1) {echo 'Yes'; }else {echo 'No'; } ?></td>
					  <td><?php echo $data['staff_name']; ?></td>
					  
					  <td>
					    <?php  if(count($getallrecords) > 1) { ?><a href="javascript:showdiv('ediv_<?php echo $data['id']; ?>');">View Email (<?php echo count($getallrecords); ?>)</a><?php  }else {echo '-'; } ?>
					  </td>
				  
				</tr>
				
				<?php  //if(count($getallrecords) > 1) { ?>
				 <tr>
					    <td colspan="20" id="ediv_<?php echo $data['id']; ?>" style="display: none;">
							<table class="inside_table">
								<tbody>
								<tr>
									<th>Email id</th>
									<th>Start-Time</th>
									<th>End-Time</th>
									<th>Total Time</th>
									<th>Activity</th>
									<th>Send Email</th>
									<th>Admin Name</th> 
								</tr>
								<?php 
								
								$i = 0;
								//$getouterdatagetouterdata[] = array();
						 // $getouterdatagetouterdata[] = array('Email id' , 'Start-Time' , 'End-Time' , 'Total Time' , 'Activity' , 'isSent'  , 'Admin Name');
								foreach($getallrecords as $key=>$getdata) {
								    
									
								
									if($getdata['activity'] == 'Open Email') {
										 $opentime= $getdata['open_time'];
										 $flag = 3;
									}
									 
									if($getdata['activity'] == 'Closed Email' && $flag == 3) {
										   $closed_time = $getdata['closed_time'];
										   $flag = 2;
									}

                                 						
									
									$startdate = date('h:i:s A' , strtotime($getdata['open_time']));
									 if($getdata['closed_time'] != '0000-00-00 00:00:00') { $enddate = date('h:i:s A' , strtotime($getdata['closed_time'])); }else { $enddate = '-'; }
									 
									 if($getdata['is_sent'] == 1) {$isemailed =  'Yes'; }else {$isemailed =  'No'; }
									
									
									
									
								  
								?>
										<tr>
											<td><?php  echo $getdata['email_id']; ?></td>
											<td><?php  echo $startdate; ; ?></td>
											<td><?php echo $enddate;   ?></td>
											<td><?php if($flag == 2) { $totaltime  = CalculateTime($opentime , $closed_time); echo $totaltime;   }  ?></td>
											<td><?php  echo $getdata['activity']; ?></td>
											<td><?php echo $isemailed; ?></td>
											<td><?php echo $getdata['staff_name']; ?></td>
										</tr>
								 <?php 
								 //if($i != 0) {
									 if($flag == 2) {
										 
                                       //$getouterdatagetouterdata[] = array($getdata['email_id'],$startdate,$enddate,$totaltime,$getdata['activity'],$isemailed,$getdata['staff_name']);
                                       $getouterdatagetouterdata[] = array($getdata['email_id'],date('h:i:s A' , strtotime($opentime)),$enddate,$totaltime,$getdata['activity'],$isemailed,$getdata['staff_name']);
									   
									    unset($opentime); unset($closed_time); 
									   
									   unset($flag);
									 }
								unset($totaltime); 
								//} 
								$i++; }   //$getouterdatagetouterdata[] = array(); ?>		
								</tbody>
							</table>
						</td>
					</tr>
				<?php 	//} ?>
				
			</tbody>
			
			
			
			
	   <?php }
         
	   } else { echo '<tr><td colspan="20">No Found</td></tr>'; }
	   ?>	
			
	</table>			

	 	
		<textarea name='fheading' style='display: none;'><?php echo serialize($fieldname); ?></textarea>
	    <textarea name='export_data' style='display: none;'><?php echo serialize($getouterdatagetouterdata); ?></textarea>
	
	