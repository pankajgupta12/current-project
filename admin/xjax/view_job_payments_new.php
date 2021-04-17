<?php 
	//echo "select * from job_payments where job_id=".$job_id."";
	
    $pgateway_details = mysql_query("SELECT P.date as Pdate , P.amount as Pamount ,P.payment_card_status as P_payment_card_status ,  P.payment_method as Ppayment_method ,  P.taken_by as Ptaken_by , P.id as Pid ,G.cc_type  as Gcc_type , G.cc_num  as Gcc_num   FROM payment_gateway as G , job_payments as P WHERE   G.job_id = P.job_id AND  P.job_id = ".$job_id." AND G.status = 1  GROUP by Pid");
	
	if(mysql_num_rows($pgateway_details)){ 
    $total_amount_1=0;
	echo '
	
	<table class="start_table_tabe3"> 
			<thead>
          <tr>
			  <th>Date</th>
			  <th>Amount</th>
			  <th>Payment Method</th>
			  <th>Card Type</th>
			  <th>Cart Number</th>
			  <th>Taken By</th>
			  <th>Status</th>
			   <th></th>
			</tr>';
	
	while($pgateway = mysql_fetch_assoc($pgateway_details)){ 
	
	          // print_r($pgateway);
			$total_amount_1+=$pgateway['Pamount'];
			 $pgateway['id'] = $pgateway['Pid'];
			 $pgateway['payment_card_status'] = $pgateway['P_payment_card_status'];
			//$staff_name  = get_rs_value("staff","name",$jdetails['staff_id']);
			echo '<tbody><tr>
				  <td>'.changeDateFormate($pgateway['Pdate'],'datetime').'</td>
				  <td> AUD  '.$pgateway['Pamount'].'</td>
				  <td>'.$pgateway['Ppayment_method'].'</td>
				  <td>'.$pgateway['Gcc_type'].'</td>
				  <td>'.$pgateway['Gcc_num'].'</td>
				  <td>'.$pgateway['Ptaken_by'].'</td>
				  <td>'.create_dd("payment_card_status","system_dd","id","name",'type=46',"onchange=\"javascript:edit_field(this,'job_payments.payment_card_status',".$pgateway['id'].");\"",$pgateway).'</td>
				  <td><a  href="javascript:send_data(\''.$job_id.'|'.$pgateway['id'].'\',30,\'job_payment_div\');">Delete</a></td>
				</tr>
				</tbody>';
			}		
	echo '</table>';
	}else{
		echo "No Payment Received<br><br>";
	}
?>
