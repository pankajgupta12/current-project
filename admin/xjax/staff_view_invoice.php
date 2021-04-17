    <?php  
    /*  echo $staff_id;
	 print_r($_SESSION['staff_invoice_1']); */
	  if(!isset($_SESSION['staff_invoice_1']['from_date'])){ $_SESSION['staff_invoice_1']['from_date'] = date("Y-m-1"); }
      if(!isset($_SESSION['staff_invoice_1']['to_date'])){ $_SESSION['staff_invoice_1']['to_date'] = date("Y-m-t"); }

      $sql = "SELECT job_date , job_id , amount_staff ,  job_type,amount_total , amount_profit  FROM `job_details` WHERE `staff_id` = ".$staff_id." and status != 2  AND job_id in (SELECT id from jobs WHERE status = 3 AND customer_paid = 1)";
	  
	    if(isset($_SESSION['staff_invoice_1']['from_date']) && $_SESSION['staff_invoice_1']['to_date'] != '' )
	{ 
		$sql .= "  AND job_date >= '".date('Y-m-d',strtotime($_SESSION['staff_invoice_1']['from_date']))."' AND job_date <= '".$_SESSION['staff_invoice_1']['to_date']."'  "; 
	} 
	$sql .= " ORDER BY job_date asc";
	 $query = mysql_query($sql);
	 
    ?>
	  <span class="staff_text" style="margin-bottom:25px;margin-left: 20px;font-size: 16px;"> <?php echo get_rs_value("staff","name",$staff_id); ?> Invoice Report </span><br>
   <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">	 
    <tbody>
		<tr class="table_cells">
			  <td><strong>Job Date</strong></td>
			  <td><strong>Job ID</strong></td>
			  <td><strong>Type</strong></td>
			  <td><strong>Total Amount</strong></td>
			  <!--<td><strong>Staff Amount</strong></td>-->
			  <td><strong>BCIC Payment</strong></td>
		</tr>
	<?php  if(mysql_num_rows($query) > 0) { 
	$totalamount_total = 0;
	$totalamount_profit = 0;
	$totalamount_staff = 0;
	     while($data = mysql_fetch_assoc($query)) {
	?>	
			<tr class="table_cells">
			   <td><?php echo changeDateFormate($data['job_date'] , 'datetime'); ?></td>
			   <td><?php echo $data['job_id']; ?></td>
			   <td><?php echo $data['job_type']; ?></td>
			   <td><?php echo $data['amount_total']; ?></td>
			   <!--<td><?php echo $data['amount_staff']; ?></td>-->
			   <td><?php echo $data['amount_profit']; ?></td>
			</tr>
		 <?php 

	$totalamount_total = $totalamount_total + $data['amount_total'];
     $totalamount_staff = $totalamount_staff + $data['amount_staff'];

     $totalamount_profit = $totalamount_profit + $data['amount_profit'];
		 } ?>
		    <tr class="table_cells">
			   <td colspan="3"></td>
			   <td colspan=""><strong>Total <?php echo $totalamount_total; ?></strong></td>
			   <!--<td colspan=""><strong>Total <?php echo $totalamount_staff; ?></strong></td>-->
			   <td ><strong>Total  <?php echo $totalamount_profit; ?></strong></td>
			</tr>


		 <?php   }else { ?>		
			<tr class="table_cells">
			   <td colspan="10">No result</td>
			   
			</tr>
			
	<?php  } ?>
    </tbody>
	</table>
  