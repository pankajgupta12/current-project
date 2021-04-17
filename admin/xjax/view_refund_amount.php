<?php 
    $refundsql = mysql_query("select * from refund_amount where is_deleted = 1 AND job_id=".$job_id."");
	
	if(mysql_num_rows($refundsql)){ 
    $total_amount_1=0;
	
	$permision = false;
	
	$adminall =  array(1,2,4,12,17);
	 if(in_array($_SESSION['admin'] ,$adminall)) {
		 $permision = true;
	 }
	 $deleteval = 'N/A';
	
	echo '<table class="start_table_tabe3"> 
			<thead>
          <tr>
			  <th>Amount</th>
			  <th>Transaction ID</th>
			  <th>Comments</th>
			  <th>Fault</th>
			  <th>Cleaner Name</th>
			  <th>Account Status</th>
			  <th>Refund Payment Status</th>
			  <th>Payment Status Date</th> 
			  <th>Date</th>
			  <th>Delete</th>
			</tr>';
	
	while($getrefunddata = mysql_fetch_assoc($refundsql)){ 
	     $status = 'N/A';
		 
		// print_r($getrefunddata);
		 
	     $refund_status = getSystemvalueByID($getrefunddata['status'],96);
	     $fault_status = getSystemvalueByID($getrefunddata['fault_status'],97);
		 
		 //$payment_job_status = getSystemvalueByID($getrefunddata['payment_job_status'],98);
		  /* if($getrefunddata['status'] == 2) {
			  
			   $payment_job_status = '<span>'.create_dd("payment_job_status","system_dd","id","name","type=98","Onchange=\"payment_refund_job_status(this.value,".$getrefunddata['id'].");\"",$getrefunddata).'</span>';
	        
		  }  */
		  
		  if($getrefunddata['refund_status'] == '1') {  $payment_job_status =  'SUCCESS'; }else {  $payment_job_status =  'Waiting'; }  
		  
			if($permision == true) {
				$deleteval = '<a onClick= delete_refundamount('.$getrefunddata['id'].'); >Delete</a>';
			}
			
			
			$paymentSdate = 'N/A';
			if($getrefunddata['payment_status_date'] != '0000-00-00 00:00:00') {
				$paymentSdate = changeDateFormate($getrefunddata['payment_status_date'],'datetime');
			}
			
			$cleaner_name = '';
			if($getrefunddata['cleaner_name'] > 0) {
		       $cleaner_name = get_rs_value("staff","name",$getrefunddata['cleaner_name']);	
			}
	
			echo '<tbody><tr id="delete_data_'.$getrefunddata['id'].'">
				  <td> AUD  '.$getrefunddata['amount'].'</td>
				    <td>'.$getrefunddata['transaction_id'].'</td>
				  <td style="width: 40%;">'.$getrefunddata['comment'].'</td>
				  <td>'.$fault_status.'</td>
				  <td>'.$cleaner_name.'</td>
				  <td>'.$refund_status.'</td>
				  <td>'.$payment_job_status.'</td>
				  <td>'.$paymentSdate.'</td>
				  <td>'.changeDateFormate($getrefunddata['created_date'],'datetime').'</td>
				  <td>'.$deleteval.'</td>
				</tr>
				</tbody>';
			}		
	echo '</table>';
	}else{
		echo "No Refund Amount<br><br>";
	}
?>
<script>
  function delete_refundamount(id ){
	   $('#refund_list_data').show();
	  send_data(id , 546 , 'refund_list_data');
	  $('#delete_data_'+id).hide();
  }
  function payment_refund_job_status(statusid , id ){
	  str = statusid +'|'+id;
	   $('#refund_list_data').show();
	  send_data(str , 547 , 'refund_list_data');
  }
</script>