<?php  

$year = $_GET['year'];
$staffid = $_GET['staff_id'];
$getInfoData = getStaffInvoice($year ,$staffid);

   // echo '<pre>' ; print_r($getInfoData); die;
   
   $staffname1 = get_rs_value('staff', 'name', $staffid);
 ?>
  <span class="staff_text" style="margin-bottom:25px;margin-left: 20px;font-size: 16px;"> <?php echo  $staffname1; ?> Invoice Report </span><br>
  <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">	 
    <tbody>
		<tr class="table_cells">
			  <td><strong>Job Date</strong></td>
			  <td><strong>View</strong></td>
		</tr>
		
	<?php  
	       $i = 1; 
		   foreach($getInfoData as $key=>$value) {
		    $i++;
		 ?>		
		
	        <tr class="table_cells">
			  
			   <td><strong><?php echo $key; ?></strong></td>
			   <td><a  href="javascript:showdiv('ediv<?php echo $i;?>');"> View </a></td>
			   </tr>
                <tr id="ediv<?php echo $i; ?>" style="display:none;">
				 <td colspan="2">
				   	
					        <table border="1px" width="100%" border="0" cellpadding="5"  align="center">
									<tr class="table_cells">
											<td><strong>Job Date</strong></td>
											<td><strong>Job ID</strong></td>
											<td><strong>Type</strong></td>
											<td><strong>Total Amount</strong></td>
											<!--<td><strong>Staff Amount</strong></td>-->
											<td><strong>BCIC Payment</strong></td>
									</tr>
										
								<?php  
								
					$totalamount_total = 0;
					$totalamount_profit = 0;
					$totalamount_staff = 0;
					
								foreach($value as $staffdeta) {  ?>		
										<tr class="table_cells">
											<td><?php echo changeDateFormate($staffdeta['job_date'] , 'datetime'); ?></td>
											<td><?php echo $staffdeta['job_id']; ?></td>
											<td><?php echo $staffdeta['job_type']; ?></td>
											<td><?php echo $staffdeta['amount_total']; ?></td>
											<!--<td><?php echo $staffdeta['amount_staff']; ?></td>-->
											<td><?php echo $staffdeta['amount_profit']; ?></td>
										</tr>
								<?php 

					 $totalamount_total = $totalamount_total + $staffdeta['amount_total'];
					 $totalamount_staff = $totalamount_staff + $staffdeta['amount_staff'];
					 $totalamount_profit = $totalamount_profit + $staffdeta['amount_profit'];

								} ?>	

							<tr class="table_cells">
							   <td colspan="3"><strong>Total</strong></td>
							   <td colspan=""><strong> <?php echo $totalamount_total; ?></strong></td>
							   <!--<td colspan=""><strong>Total <?php echo $totalamount_staff; ?></strong></td>-->
							   <td ><strong> <?php echo $totalamount_profit; ?></strong></td>
							</tr>		
				    </table>
					
					
				 </td>
				
				 </tr>
					
		  <?php  } ?>	
		  </tbody>
		 </table> 