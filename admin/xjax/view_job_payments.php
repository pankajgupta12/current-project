<?php 
	//echo "select * from job_payments where job_id=".$job_id."";
	
    $pgateway_details = mysql_query("select * from job_payments where job_id=".$job_id."");
	
	if(mysql_num_rows($pgateway_details)){ 
    $total_amount_1=0;
	echo '
	
	<table class="start_table_tabe3"> 
			<thead>
          <tr>
			  <th>Date</th>
			  <th>Amount</th>
			  <th>Payment Method</th>
			  <th>Taken By</th>
			  <th>Transaction ID</th>
			  <th>Status</th>
			  <th></th>
			  <th>Pay Status</th>
			</tr>';
	
	while($pgateway = mysql_fetch_assoc($pgateway_details)){ 
			//$total_amount_1+=$pgateway['amount'];
			
			$transid = ($pgateway['transaction_id'] == 0)? 0: $pgateway['transaction_id'];
			//$staff_name  = get_rs_value("staff","name",$jdetails['staff_id']);
			echo '<tbody><tr>
				  <td>'.changeDateFormate($pgateway['date'],'datetime').'</td>
				  <td> AUD  '.$pgateway['amount'].'</td>
				  <td>'.$pgateway['payment_method'].'</td>
				  <td>'.$pgateway['taken_by'].'</td>
                   <td>'.$transid.'</td>				
				   <td>'.create_dd("payment_card_status","system_dd","id","name",'type=46',"onchange=\"javascript:edit_field(this,'job_payments.payment_card_status',".$pgateway['id'].");\"",$pgateway).'</td>
				  <td><a  href="javascript:send_data(\''.$job_id.'|'.$pgateway['id'].'\',30,\'job_payment_div\');">Delete</a></td>
				  <td>'.ucfirst($pgateway['transaction_type']).'</td>
				</tr>
				</tbody>';
			}		
	echo '</table>';
	}else{
		echo "No Payment Received<br><br>";
	}
?>
