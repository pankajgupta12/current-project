    <table class="start_table_tabe3">
        <thead>
          <tr>
            <th>Date</th>
            <th>Amount</th>
            <th>Cart type</th>
            <th>Cart Number</th>
            <th>Result text</th>
            <th>IP address</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
		<?php  
         while($gethistory = mysql_fetch_assoc($h_sql)) {
		?>
			<tr class="<?php if($gethistory['status'] == 0) { echo 'alert_danger_tr'; } ?>">
			  <td><?php echo changeDateFormate($gethistory['timestamp'] , 'timestamp'); ?></td>
			  <td><?php echo $gethistory['amount']; ?></td>
			  <td><?php echo $gethistory['cc_type']; ?></td>
			  <td><?php echo $gethistory['cc_num']; ?></td>
			  <td><?php echo $gethistory['result_text']; ?></td>
			  <td><?php echo $gethistory['ip']; ?></td>
			  <td><?php if($gethistory['status'] == 1) { echo 'Success'; }else {echo 'failed';} ?></td>
			</tr>
		 <?php  } ?>
        </tbody>
    </table>