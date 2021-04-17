<table>
				    <tr>
					  <th>Bed</th>
					  <th>Bath</th>
					  <th>Living</th>
					  <th>Study</th>
					  <th>Amount</th>
					  <th>Full Amt</th>
				    </tr>  
				    <tbody>
					    <?php 
							$sqlrates = mysql_query("SELECT * FROM `staff_fixed_rates` where status = 1 AND site_id = ".$site_id."");
							if(mysql_num_rows($sqlrates) > 0) {
							while($getrates = mysql_fetch_assoc($sqlrates)) {	
					    ?>
							<tr>
							   <td><?php echo $getrates['bed']; ?></td>
							   <td><?php echo $getrates['bath']; ?></td>
							   <td><?php echo $getrates['living']; ?></td>
							   <td><?php echo $getrates['study']; ?></td>
							   <td><?php echo '$ '.$getrates['amount']; ?></td>
							   <td><?php echo '$ '.$getrates['full_amount']; ?></td>
							</tr>  
						<?php } } ?>
				    </tbody>
				</table>