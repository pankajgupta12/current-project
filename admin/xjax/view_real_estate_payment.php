<?php  
if(!isset($_SESSION['re_payment_report']['from_date'])){ $_SESSION['re_payment_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['re_payment_report']['to_date'])){ $_SESSION['re_payment_report']['to_date'] = date("Y-m-t"); }

//print_r($_SESSION['re_payment_report']);

      $arg = "SELECT count(real_estate_id) as totalre_job , real_estate_id  FROM `quote_new` WHERE booking_id > 0 AND real_estate_id  > 0";
 
	 if($_SESSION['re_payment_report']['from_date'] != '' && $_SESSION['re_payment_report']['to_date']) {
	    $arg.= " AND booking_date >= '".$_SESSION['re_payment_report']['from_date']."' and booking_date <= '".$_SESSION['re_payment_report']['to_date']."'";
	 }
	 
	   if($_SESSION['re_payment_report']['site_id'] != '' && $_SESSION['re_payment_report']['site_id'] != 0) {
	      $arg.= " AND site_id = '".$_SESSION['re_payment_report']['site_id']."'";
		
	    }
	 
	 if($_SESSION['re_payment_report']['real_estate_id'] != '' && $_SESSION['re_payment_report']['real_estate_id'] != 0) {
	    $arg.= " AND real_estate_id = '".$_SESSION['re_payment_report']['real_estate_id']."'";
		
	 }
	 
	 $arg.= " GROUP by real_estate_id";
 
  // echo $arg;
 
  $re_query = mysql_query($arg);
  $countresult = mysql_num_rows($re_query);
  
   if($countresult > 0) {
    while($result = mysql_fetch_assoc($re_query)) {
	  
	   $get_re_details =  mysql_fetch_assoc(mysql_query("SELECT * FROM `real_estate_agent` WHERE id  = '".$result['real_estate_id']."'"));

	 
	   $getjobdetailssql = "SELECT booking_id , id ,  booking_date  from quote_new where real_estate_id = ".$result['real_estate_id']." AND booking_id > 0 ";
	   
	    if($_SESSION['re_payment_report']['from_date'] != '' && $_SESSION['re_payment_report']['to_date']) {
	      $getjobdetailssql.= " AND booking_date >= '".$_SESSION['re_payment_report']['from_date']."' and booking_date <= '".$_SESSION['re_payment_report']['to_date']."'";
	    }
		
		if($_SESSION['re_payment_report']['site_id'] != '' && $_SESSION['re_payment_report']['site_id'] != 0) {
	      $arg.= " AND site_id = '".$_SESSION['re_payment_report']['site_id']."'";
		
	    }
	   
	    $getjobdetails =  mysql_query($getjobdetailssql);
	   
?>

	 <div class="view_quote_back_box">
	   <div class="left_text_box"><span class="add_jobs_text" style="white-space: nowrap;"><a style="cursor: pointer;" onclick="javascript:scrollWindow('real_staff_details.php?task=edit_real_estate&action=modify&id=<?php echo $result['real_estate_id']; ?>','1200','850')" ><?php  echo  $get_re_details['name']; ?> ( <?php  echo  get_rs_value("sites","name",$get_re_details['site_id']); ?> )</a></span></div>
	 
	   <div class="userpayment-overflow">
		  <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table staff-table">
			 <tbody>
				<tr class="table_cells re_payment_table">
				   <th>Job Id</th>
				   <th>Job Date</th>
				   <th>Amount</th>
				   <th>Re office</th>
				   <th>Create RE Inv</th>
				</tr>
				
			<?php 
           
				$total_amount = 0;
				while($getre_details = mysql_fetch_array($getjobdetails)) { 
			
			    $total_amount = $total_amount + get_rs_value("jobs","customer_amount",$getre_details['booking_id']);
			    $email_client_invoice = get_rs_value("jobs","email_client_invoice",$getre_details['booking_id']);
			?>	
				<tr class="table_cells">
				   <td><a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $getre_details['booking_id']; ?>','1200','850')"><?php echo $getre_details['booking_id']; ?></a></td>
				   <td><?php echo date('dS M Y' ,strtotime($getre_details['booking_date'])); ?></td>
				   <td>$<?php echo number_format(get_rs_value("jobs","customer_amount",$getre_details['booking_id']) , 2); ?></td>
				   <td><?php echo $get_re_details['office_address']; ?></td>
				   
				   <?php if($email_client_invoice != '0000-00-00 00:00:00') { ?>
						<td>
							<?php echo $email_client_invoice; ?>
						</td>
				   <?php  }else{ ?>
				      <td id="re_invoice_id_<?php echo $getre_details['id']; ?>"><input type="checkbox" name="invoice_check" value="" onclick="javascript:send_data('<?php echo $getre_details['id']; ?>' ,515 , 're_invoice_id_<?php echo $getre_details['id']; ?>');"></td>
				   <?php  } ?>
				</tr>
			<?php  } ?>	
				
				<tr>
				   <td colspan="2" style="text-align: left;"></td>
				   <td colspan="3" ><strong style="margin-left: -665px;">Total Amount  $<?php  echo number_format($total_amount ,2); ?> </strong></td>
				</tr>
			
			 </tbody>
		  </table>
	   </div>
	</div>
  <?php  } }else { ?>	
		<span>	No Record found..  </span>
	<?php  } ?>

	<style>
	.re_payment_table th{
		text-align: center;
		padding: 8px;
	}
	</style>