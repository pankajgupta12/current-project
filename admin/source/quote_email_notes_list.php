<div id="daily_view">
<span class="staff_text" style="margin-bottom:25px;margin-left: 19px;">Email Notes List</span>
	<?php  
	 
		 $getsql =    mysql_query("SELECT * FROM `quote_email_notes`");
	  
	?>
     <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
        <thead>
          <tr>
				<th style="text-align: center;">Id</th>
				<th style="text-align: center;">Quote For</th>
				<th style="text-align: center;">Email Type</th>
				<th style="text-align: center;">Last Updated Date</th>
				<th style="text-align: center;">Modify</th>
          </tr>
        </thead>
        <tbody>
		  <?php  while($getData = mysql_fetch_array($getsql)) { ?>
					<tr> 
						<td><?php  echo $getData['id'];?></td>
						<td><?php  if($getData['quote_for_type_id'] == '0') { echo 'BCIC-BR'; }else { echo  get_rs_value("quote_for_option","name",$getData['quote_for_type_id']); } ?></td>
						<td><?php  echo $getData['emal_type'];?></td>
						<td><?php  echo changeDateFormate($getData['createdOn'],'timestamp');?></td>
						<td><a href="../admin/index.php?task=quote_email_notes&id=<?php echo $getData['id']; ?>">Modify</a></td>
					</tr>
		  <?php  } ?>
        </tbody>
      </table>
	    
</div>