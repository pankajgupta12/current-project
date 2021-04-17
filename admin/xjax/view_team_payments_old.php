<?php 

if(!isset($_SESSION['tpayment_report']['from_date'])){ $_SESSION['tpayment_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['tpayment_report']['to_date'])){ $_SESSION['tpayment_report']['to_date'] = date("Y-m-t"); }
if(!isset($_SESSION['tpayment_report']['site_id'])){ $_SESSION['tpayment_report']['site_id'] = "0"; }
if(!isset($_SESSION['tpayment_report']['staff_id'])){ $_SESSION['tpayment_report']['staff_id'] = "0"; }

if(!isset($_SESSION['tpayment_report']['staff_type'])){ $_SESSION['tpayment_report']['staff_type'] = "0"; }



$staff_arg = "select staff_id from job_details where (job_date>='".$_SESSION['tpayment_report']['from_date']."' and job_date<='".$_SESSION['tpayment_report']['to_date']."') ";
if($_SESSION['tpayment_report']['site_id']!="0"){ $staff_arg.= " and site_id=".$_SESSION['tpayment_report']['site_id']; } 
if($_SESSION['tpayment_report']['staff_id']!="0"){ $staff_arg.= " and staff_id=".$_SESSION['tpayment_report']['staff_id']; } 
$staff_arg.= " and job_id in (select id from jobs where status=3 and payment_completed=0) group by staff_id";

//echo $staff_arg;

$staffs = mysql_query($staff_arg);
//$staffs = mysql_query("SELECT staff_id FROM `job_details` WHERE job_id in (select distinct(id) from jobs where status=3 and payment_completed=0) and staff_paid=0 and status!=2 and `payment_check`=0 group by staff_id");
//echo "norows ".mysql_num_rows($staffs);
while($r = mysql_fetch_assoc($staffs)){


	//$staff_name = get_rs_value("staff","name",$r['staff_id']);
	$staff = mysql_fetch_assoc(mysql_query("select * from staff where id=".$r['staff_id'].""));
	$site_name = get_rs_value("sites","name",$staff['site_id']);
	
	echo '<div class="view_quote_back_box">';
	echo '<div class="left_text_box"><span class="add_jobs_text">'.$staff['name'].' ('.$site_name.')</span></div>';
	echo '<div class="userpayment-overflow">';	
	
	
	$job_total = 0; $staff_amount_total = 0; $bcic_amount_total =0; $bcic_rec_total =0; $staff_rec_total=0;
	$balance=0;
	$job_picker_x = "";
	echo '<table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">';
	echo '<tr class="table_cells">
		  <td>Job Id</td>
		  <td>Client Name</td>
		  <td>Job Date</td>
		  <td>Type</td>			  
		  <td>Total Amount</td>
		  <td>Staff Amount</td>
		  <td>Staff Paid Date</td>
		  <td>BCIC Amount</td>
		  <td>Staff Received</td>
		  <td>BCIC Received</td>	  
		</tr>';
		
		
		
		$job_details_arg = "select * from job_details where staff_id=".$r['staff_id']." and job_id in(select id from jobs where status=3 and payment_completed=0) and status!=2";
		$job_details_arg.= " and (job_date>='".$_SESSION['tpayment_report']['from_date']."' and job_date<='".$_SESSION['tpayment_report']['to_date']."') ";
		//echo $job_details_arg;
		$job_details = mysql_query($job_details_arg);
		
        while($jdetails = mysql_fetch_assoc($job_details)){ 
			
			$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".$jdetails['job_id']));			
			$quote = mysql_fetch_array(mysql_query("select * from quote where id=".$jobs['quote_id']));
			$bcic_rec =mysql_fetch_array(mysql_query("select sum(amount) as amount from job_payments where taken_by='BCIC' and job_id=".$jdetails['job_id'].""));
			$staff_rec =mysql_fetch_array(mysql_query("select sum(amount) as amount from job_payments where taken_by='".$staff_name."' and job_id=".$jdetails['job_id'].""));
			
			
			
			echo '<tr class="table_cells" id="jdetails_'.$jdetails['id'].'">
			  <td><a href="javascript:scrollWindow(\'popup.php?task=jobs&job_id='.$jdetails['job_id'].'\',\'1200\',\'850\')">'.$jdetails['job_id'].'</td>
			  <td>'.$quote['name'].'</td>
			  <td>'.$jdetails['job_date'].'</td>
			  <td>'.$jdetails['job_type'].'</td>
			  <td>'.$jdetails['amount_total'].'</td>
			  <td><strong>'.$jdetails['amount_staff'].'</strong> </td>
			  <td id="staff_paid_'.$jdetails['id'].'">';
			  if($jdetails['staff_paid']=="1"){ 
			  	echo ' '.$jdetails['staff_paid_date'];
			  }else{				  
				  echo '<a href="javascript:send_data('.$jdetails['id'].',36,\'staff_paid_'.$jdetails['id'].'\');">Make Paid</a>';
			  }
			  echo '</td>
			  <td>'.$jdetails['amount_profit'].'</td>
			  <td><strong>'.$staff_rec['amount'].'</strong></td>
			  <td>'.$bcic_rec['amount'].'</td>		
			</tr>';
			
			$job_total = ($job_total+$jdetails['amount_total']); 
			$staff_amount_total = ($staff_amount_total+$jdetails['amount_staff']); 
			$bcic_amount_total = ($bcic_amount_total+$jdetails['amount_profit']); 
			$bcic_rec_total = ($bcic_rec_total+$bcic_rec['amount']); 
			$staff_rec_total= ($staff_rec_total+$staff_rec['amount']);
			// <a href="javascript:send_data(\''.$quote['id'].'|'.$jdetails['staff_id'].'|true\',28,\'send_invoice_'.$jdetails['id'].'\');" id="send_invoice_'.$jdetails['id'].'">Send Invoice</a>
		}
		
		echo '<tr class="table_cells">
			  <td></td>
  			  <td></td>
			  <td></td>
			  <td></td>		  
			  <td>'.$job_total.'</td>
			  <td>'.$staff_amount_total.'</td>
			  <td>'.$bcic_amount_total.'</td>
			  <td>'.$staff_rec_total.'</td>
			  <td>'.$bcic_rec_total.'</td>		  
			</tr>';
		$payment_balance = ($staff_amount_total-$staff_rec_total);
		echo '<tr class="table_cells">
			  <td colspan="9" align="center"><strong>Staff Payment : '.($staff_amount_total-$staff_rec_total).'</strong></td>
			</tr>';
		echo '</table></div></div></div>';

	
}

/*$arg = "select staff_id from job_details where job_id in (select id from jobs where status=3 and payment_completed=0)";
$data = mysql_query($arg);
while($r = mysql_fetch_assoc($data)){
		
	
}*/
?>