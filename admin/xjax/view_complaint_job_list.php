<?php  

		if(!isset($_SESSION['complaint_page']['from_date'])){ $_SESSION['complaint_page']['from_date'] = date("Y-m-1"); }
		if(!isset($_SESSION['complaint_page']['to_date'])){ $_SESSION['complaint_page']['to_date'] = date("Y-m-t"); }

    $arg = "SELECT * FROM `job_complaint` where 1 = 1 AND  job_id in (select booking_id from quote_new where bbcapp_staff_id = 0 AND booking_id > 0) ";
	
	 if($_SESSION['complaint_page']['from_date'] != '' && $_SESSION['complaint_page']['to_date'] != '') {
		 $arg .= " AND DATE(createdOn) >= '".$_SESSION['complaint_page']['from_date']."'  AND  DATE(createdOn) <= '".$_SESSION['complaint_page']['to_date']."'  ";
	 }

	 if($_SESSION['complaint_page']['site_id'] > 0) {
		 $arg .= " AND job_id in (SELECT id from jobs WHERE site_id = ".$_SESSION['complaint_page']['site_id'].") ";
	 }
	 
	 
	 if($_SESSION['complaint_page']['complaint_type'] > 0) {
		 $arg .= " AND complaint_type = '".$_SESSION['complaint_page']['complaint_type']."' ";
	 }
	 
	 if($_SESSION['complaint_page']['complaint_status'] > 0) {
		 $arg .= " AND complaint_status = '".$_SESSION['complaint_page']['complaint_status']."' ";
	 }else{
		 //$arg .= " AND complaint_status != 4 ";
	 }
	 
	 $arg .= " ORDER BY `id` DESC";
	
	//echo $arg;
	$sql = mysql_query($arg);
 
    $count = mysql_num_rows($sql);
	$jobStatua = JobStatusName();
	$jobtype =  jobIcone();
	
	
?>
   <div class="right_text_boxData right_text_box">
	  <div class="midle_staff_box"><span class="midle_text">Total Records <?php echo   $count; ?> </span></div>
	</div>

            <table class="user-table" border="1px">
					<thead>
						<tr>
							<th>Comp ID</th>
							<th>Job ID</th>
							<th>Claner Name</th>
							<th>Name</th>
							<th>Email</th>
							<th>Mobile</th>
							<th>Job Type</th>
							<th>Job Date</th>
							<th>Job Amt</th>
							<th>Job Handle</th>
							<th>Job Status</th>
							<<th>Complaint Status</th>
							<th>Complaint Type</th>
							<th>Admin Name</th>
							<!--<th>Comment</th>-->
							<th>Created Date</th>
							<th>Complete Date</th>
							<th>Notes</th>
						</tr>
					</thead>
					  
				<tbody>
					<?php  
					if(mysql_num_rows($sql) > 0) 
					{ 
				$i = 0;
						while($data = mysql_fetch_assoc($sql)) 
						{
							 $staffname = get_rs_value("staff","name",$data['staff_id']);
						
						 $jobdetails =  getJobDetailsData($data['job_id']);
						 
						// print_r($jobdetails);
						 
						$quotedetails = mysql_fetch_array(mysql_query("Select id ,booking_id, email,phone,name, booking_date from quote_new where booking_id = ".$data['job_id'].""));
						 
						// print_r()
						$job_type = '';
						if($data['job_type_id'] > 0) {
						   $job_type = ' ( ' .get_rs_value("job_type","name",$data['job_type_id']).')';
						}
						
						$complaint_status = get_sql("system_dd","name"," where type='124' AND id='".$data['complaint_status']."'");
						
						?>
							
									<tr class="parent_tr_<?php echo $data['id']; ?>">
									    <td> <?php echo $data['id']; ?> </td>
										<td><a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $data['job_id']; ?>','1200','850')"> <?php echo $data['job_id']; ?> </a></td>
										<?php  if($data['staff_id'] > 0  && $data['job_type_id'] > 0) { ?>
										<td> <?php echo $staffname.$job_type; ?> </td>
										<?php  }else { ?>
										<td> <?php echo  create_dd("job_type_id","job_details","job_type_id","job_type","job_id=".$data['job_id']." AND staff_id > 0 ","Onchange=\"return change_complaint_status(this, 'job_complaint.job_type_id',".$data['id'].", 'job_type_id_".$data['id']."', 'Complaint Job Type ');\"",$data); ?> </td>
										<?php  } ?>
										<td> <?php echo $quotedetails['name']; ?> </td>
										<td title="<?php echo $quotedetails['email'];  ?>"><a href="mailto:<?php echo $quotedetails['email'];  ?>"> <?php echo substr($quotedetails['email'], 0, 10); ?></a> </td>
										<td><a href="tel:<?php echo $quotedetails['phone']; ?>"> <?php echo $quotedetails['phone']; ?></a> </td>
										<td> 
										<?php 
											foreach($jobdetails[$data['job_id']] as $key=>$jvalue) 
											{
												if($jvalue['staff_id'] != 0) {
												
												  $staffDetails = mysql_fetch_array(mysql_query("Select name , email , mobile from staff where id = ".$jvalue['staff_id'].""));
												  
												  $sname = $staffDetails['name'];
												  $mobile = $staffDetails['mobile'];
												}else{
													$sname = 'N/A';
												    $mobile = 'N/A';
												}
												
												 $icondata = $jobtype[$jvalue['job_type_id']];
													echo '<img title="'.$sname.' ( '.$mobile.') ('.$jvalue['amount_total'].')" class="image_icone" src="icones/job_type32/'.$icondata.'">';
													$totalamount[] = $jvalue['amount_total'];
											} 
						                ?> 
										</td>
										<td> <?php echo changeDateFormate($quotedetails['booking_date'],'datetime'); ?> </td>
										<td> <?php echo '$'.array_sum($totalamount); ?> </td>
										<td> <?php if($data['job_handling'] == 1) {echo 'Cleaner'; } elseif($data['job_handling'] == 2 || $data['job_handling_by_clnr'] == 1) { echo 'Admin';}else{echo 'New';}?> </td>
										<td> <?php echo $jobStatua[$data['job_status']]; ?> </td>
										<td> <?php  echo $complaint_status;  //echo  create_dd("complaint_status","system_dd","id","name","type=124","Onchange=\"return change_complaint_status(this, 'job_complaint.complaint_status',".$data['id'].", 'complaint_status_".$data['id']."', 'Complaint Status');\"",$data); ?> </td>
										<td> <?php echo  create_dd("complaint_type","system_dd","id","name","type=125","Onchange=\"return change_complaint_status(this,'job_complaint.complaint_type' ,".$data['id']." , 'complaint_type_".$data['id']."', 'Complaint  Type');\"",$data); ?></td>
										
										
										<td><?php echo  create_dd("admin_id","admin","id","name"," status = 1 AND is_call_allow = 1","Onchange=\"return change_complaint_status(this, 'job_complaint.admin_id',".$data['id'].", 'admin_id_".$data['id']."','Admin Name');\"",$data,'field_id'); ?>  </td>
										<!--<td> <textarea  style="width: 90%;" rows="5" cols="25"><?php echo $data['description']; ?></textarea> </td>-->
										<td title="<?php echo changeDateFormate($data['createdOn'], 'timestamp'); ?>"> <?php echo changeDateFormate($data['createdOn'], 'dt'); ?> </td>
										<td title="<?php if($data['complaint_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($data['complaint_date'], 'timestamp'); }?>"><?php if($data['complaint_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($data['complaint_date'], 'dt'); } else{echo 'N/A';}?> </td>
										<td><a href="javascript:void(0);" onClick="show_notes('<?php echo $data['id']; ?>', '<?php echo $data['job_id']; ?>');"> Notes </td>
									</tr>
						<?php  
						 unset($totalamount);
						} 
					}else{ 
					?>
					            <tr class="parent_tr_<?php echo $data['id']; ?>">
										<td colspan="15"> No Result </td>
								</tr>		
					<?php  } ?>				
				</tbody>
            </table>
			
			
			<?php  
			
                function getclenerdata_details($jobid) {
                
                        $data = mysql_query("SELECT job_id , job_type_id , complaint_status ,  (SELECT name from staff where id = staff_id)  as sname  ,job_type , staff_id FROM `job_details` WHERE `job_id` = ".$jobid." AND staff_id> 0");
                        
                        //echo create_dd("status","system_dd","id","name","type=".$jobid." AND staff_id> 0","",$getData1);
                        
                        
                        $strx = "<select name='staff_id_data' id='staff_id_data' style='width: 100%;margin-top: 11px;height: 31px;text-align: center;font-size: 16px;'>";
                        
                        $strx.="<option value='0'>Select staff</option>"; 
                        if(mysql_num_rows($data) > 0) {		   
                        while($r=mysql_fetch_assoc($data)){ 
                        
                        $select = '';
                        if($r['complaint_status'] == 1) { $select = 'disabled';}
                        
                        $strx.="<option  value=".$r['staff_id'].'__'.$r['job_type_id']."  $select >".$r['job_type']."(".$r['sname'].")</option>";
                        }	
                        }else{
                        $strx.="<option value='0'>No Staff</option>";
                        }
                        $strx.="</select>";
                        echo $strx; 
                }
			
			 ?>