<?php  
$cartsql = mysql_query("SELECT * FROM `payment_gateway`  WHERE job_id = ".$jobid." AND status = 1 AND charge_type = 1   ORDER by id desc ");
  if(mysql_num_rows($cartsql)) {
	 
?>
 <span class="payment_required">Credit Card Details</span>
    <div class="tab3_table1">
		<table class="start_table_tabe3">
			<thead>
			  <tr>
				<th>Default Card</th>
				<th>Card Holder Name</th>
				<th>Card Number</th>
				<th>Card Type</th>
				<th>Last Amount Received </th>
				<th>Charge Date</th>
			  </tr>
			</thead>
			
			<tbody>	
				<?php  while($cartDetails = mysql_fetch_assoc($cartsql)) { ?>
					<tr>
						<td>
						<?php  if($cartDetails['token_id'] != '' && $cartDetails['cc_num'] != '') { ?>
						   <input type="radio" name="default_Cart" id="default_Cart_<?php echo $cartDetails['id']; ?>" onChange="get_default_cart('<?php echo $cartDetails['token_id']; ?>' , '<?php echo $cartDetails['job_id']; ?>' , '<?php echo $cartDetails['id']; ?>');" value="" <?php echo ($cartDetails['token_id']== $eway_token) ?  "checked" : "" ;  ?>>
						<?php  } ?>
						</td>
						<td><?php  echo $cartDetails['cc_name']; ?></td>
						<td><?php  echo $cartDetails['cc_num']; ?></td>
						<td><?php  echo $cartDetails['cc_type']; ?></td>
						<td><?php  echo $cartDetails['amount']; ?></td>
						<td><?php  echo $cartDetails['timestamp']; ?></td>
					</tr>
				<?php  } ?>
			</tbody>
		</table>
    </div>	  
  <?php  } ?>
  
  
  <script>
    function get_default_cart(tokid , jib , id)
	{
		 //var str = obj.value+"|"+field+"|"+id;
		//this,'jobs.customer_amount',4744
		var str = tokid+'|jobs.eway_token|'+id;
		// alert(tokid + ' == '+ jib);
		 divid = 'default_Cart_'+id;
		 $('#loaderimage_1').show();
	     $('.full_loader').attr('id','bodydisabled_1');
		 
		send_data(str,21,divid); 
	}
  </script>