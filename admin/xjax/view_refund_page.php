<br>
<br>
<br>
<?php  

    $arg = "SELECT * FROM `refund_amount` where is_deleted = 1 ";
	
	 if($_SESSION['payment_refund_page']['from_date'] != '' && $_SESSION['payment_refund_page']['to_date'] != '') {
		 $arg .= " AND DATE(created_date) >= '".$_SESSION['payment_refund_page']['from_date']."'  AND  DATE(created_date) <= '".$_SESSION['payment_refund_page']['to_date']."'  ";
	 }

	 if($_SESSION['payment_refund_page']['site_id'] > 0) {
		 $arg .= " AND job_id in (SELECT id from jobs WHERE site_id = ".$_SESSION['payment_refund_page']['site_id'].")  ";
	 }
	 $arg .= " ORDER BY `id` DESC";
	
	$sql = mysql_query($arg);
 
    $count = mysql_num_rows($sql);
	
	$fieldname = array('ID' , 'Job Id' , 'Comment' , 'Amount' , 'Transaction ID' , 'Response Message','Refund Payment Date' ,'Email date', 'Staff Name');
	
	/*  $getouterdatagetouterdata[] = array($getdata['email_id'],date('h:i:s A' , strtotime($opentime)),$enddate,$totaltime,$getdata['activity'],$isemailed,$getdata['staff_name']); */

?>
   <div class="right_text_boxData right_text_box">
	  <div class="midle_staff_box"><span class="midle_text">Total Records <?php echo   $count; ?> </span></div>
	</div>

            <table class="user-table" border="1px">
					<thead>
						<tr>
							<th>Id</th>
							<th>Job ID</th>
							<th>Comment</th>
							<th>Amount</th>
							<th>Transaction ID</th>
							<th>Refund Status</th>
							<th>Fault Status</th>
							<th>Cleaner Name</th>
							<!--<th>Payment Status</th>-->
							<th>Click For Refund</th>
							<th>Staff Name</th>
							<th>Refund Status</th>
							<th>Send  Email</th>
							<th>Download</th>
							<th>Created Date</th>
						</tr>
					</thead>
					  
				<tbody>
					<?php  
					if(mysql_num_rows($sql) > 0) 
					{ 
				$i = 0;
						while($data = mysql_fetch_assoc($sql)) 
						{
							 
							  $fault_status = getSystemvalueByID($data['fault_status'],97);
							  $re_status = getSystemvalueByID($data['status'],96);
							  
							$cleaner_name = '';
							if($data['cleaner_name'] > 0) {
							  $cleaner_name = get_rs_value("staff","name",$data['cleaner_name']);	
							}
							
							
				/* $fieldname = array('ID' , 'Job Id' , 'Comment' , 'Amount' , 'Transaction ID' , 'Response Message','Refund Payment Date' ,'Email date', 'Staff Name'); */			
					if($data['refund_status'] == 1) {		
				           $getouterdatagetouterdata[] = array($i , $data['job_id'],$data['comment'],$data['amount'],$data['transaction_id'],'Approved',$data['refund_payment_date'] ,$data['email_date'], $data['staff_name']);
						   
						   $i++;
					}

				
						?>
							
									<tr  <?php  if($data['refund_status'] == 1)  { ?>  class="alert_danger_success"  <?php }?>>
										<td> <?php echo $data['id']; ?> </td>
										<td><a href="javascript:scrollWindow('popup.php?task=payment&job_id=<?php echo $data['job_id']; ?>','1200','850')"><?php echo $data['job_id']; ?> </a></td>
										<td style="width:40%;"> <?php echo $data['comment']; ?></td>
										<td> <?php echo $data['amount']; ?> </td>
										<td> <?php echo $data['transaction_id']; ?> </td>
										<td > <?php if($data['status'] == 4) { echo $re_status; } else { echo create_dd("status","system_dd","id","name","type=96","Onchange=\"refund_paymentstatus(this.value,".$data['id'].");\"",$data); }?>    </td>
										<td> <?php echo $fault_status; ?> </td>
										<td> <?php echo $cleaner_name; ?> </td>
										<!--<td> <?php  echo $job_status; ?> </td>-->
										<td id="refund_payment_<?php echo $data['id']; ?>"><?php 

										if($data['refund_status'] == 1) {
											  echo 'Approved';
										 
										}else {
											if($data['status'] == 4 && $data['refund_payment_status'] == 0) {
											    
											    if($_SESSION['admin'] != 12) {
										  
										?> <a  style="cursor: pointer;" onClick="refund_payment('<?php echo $data['job_id']; ?>' , '<?php echo $data['id']; ?>');">Refund </a> <?php }else {echo  'Not Authorized';}  } else { $fault_status;  } }  ?></td>
										
										<td> <?php echo $data['staff_name']; ?> </td>
										<td> <?php if($data['refund_status'] == 1) {  echo 'SUCCESS'; }else {  echo 'Not'; }  ?> </td>
										 <td id="email_date_<?php echo $data['id']; ?>">
										    <?php  if($data['refund_status'] == 1 && $data['email_date'] == '0000-00-00 00:00:00') { ?>
										       <a onClick="send_data('<?php echo $data['id']; ?>' , 558 ,'email_date_<?php echo $data['id']; ?>' );">Send Email </a>
										     <?php  } else if($data['email_date'] != '0000-00-00 00:00:00') {  echo changeDateFormate($data['email_date'] , 'timestamp');  ?>
											 <?php  } else { echo 'N/A'; }?>
										</td>
										<td> <?php 
										
											
										
										if($data['refund_status'] == 1 && $data['filename'] != '') {  ?>  <a href="../refund/<?php  echo $data['filename']; ?>" target="_blank" download>Download</a> <?php }  ?> </td>
										<td title='<?php echo changeDateFormate($data['created_date'] , 'timestamp'); ?> '> <?php echo changeDateFormate($data['created_date'] , 'datetime'); ?> </td>
									</tr>
						<?php  
						} 
					}
					?>
				</tbody>
            </table>
			<textarea name='fheading' style='display: none;'><?php echo serialize($fieldname); ?></textarea>
			<textarea name='export_data' style='display: none;'><?php echo serialize($getouterdatagetouterdata); ?></textarea>
			
			<script>
			
			    function refund_payment(jobid , id)
				{
					if (confirm('Are you sure you want to do refund amount')) 
					{
						var str = jobid+'|'+id;
						send_data(str , 550 , 'refund_payment_'+id); 
					}
					else
					{
					   return false;
					}
			    } 
				
			</script>