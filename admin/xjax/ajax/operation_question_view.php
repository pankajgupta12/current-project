    <div class="question_div">
	   <h4> <?php echo $gettrackdata[$track_id]; ?><?php echo $count; ?> ( J#<a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php  echo $trackdetails['job_id']; ?>','1200','850')"><?php  echo $trackdetails['job_id']; ?></a>)</h4>
	   <h6 style="font-weight: 600;"><?php echo $getsubdata[$trackid_head]; ?></h6>
	     <?php  if(isset($_POST['msg']) && $_POST['msg'] != '') { ?> <p style="color: #097309;font-size: 17px;margin-left: 242px;margin-top: -31px;padding: 3px;font-weight: bold;"> Your question is saved successfully</p><?php  } else {   ?><p style="color: #d2132a;font-size: 17px;margin-left: 242px;margin-top: -31px;padding: 3px;font-weight: bold;"> This job is already review </p><?php  } ?>
			<table class="question_heading">
					  <tr>
						<th>ID</th>
						<th>Qus</th>
						<th>Check</th>
						<th>Review Date</th>
						<th>Last Updated</th>
					  </tr>
						  <?php   if($count > 0) { 
						   $i = 1; while($data = mysql_fetch_assoc($slq)) {
						  ?>
							  <tr> 
								<td><?php echo $i; ?></td>
								<td>
							
								<?php 
								//$data['question_id']
								if($data['question_name'] != '') {
								 $staff_qus = $data['question_name'];
								}else{
								  $staff_qus = get_rs_value("operation_checklist","qus",$data['question_id']);
								}
								echo $staff_qus;	
								
								if($data['ans'] == 1) {
									$ans = 0;
								}else{
									$ans = 1;
								}
								
								?></td>
								<td><input type="checkbox"  id="ans_data_<?php echo $data['id']; ?>" name="ans_data" onclick="send_data('<?php echo $ans;?>|<?php echo $data['id']; ?>' , 587 , 'getdata_1');" value="<?php echo $data['ans']; ?>" <?php if($data['ans'] == 1) {echo 'checked'; } ?>></td>
								<td><?php echo changeDateFormate($data['createdOn'] , 'timestamp'); ?></td>
								<td><?php if($data['updatedOn'] != '0000-00-00 00:00:00') { echo changeDateFormate($data['updatedOn'] , 'timestamp'); }else{echo 'N/A';} ?></td>
							  </tr>
							<?php $i++; }  }else { ?>
							<tr>
								<td colspan="5">No Question</td>
							</tr>	
							<?php  }  ?>	
			
			  
			</table>
			
    </div>
	
	 	 <?php  //include_once('get_operations_sales_page.php'); ?>
  <?php  //} ?>	