    <?php  
     
	$sql  = mysql_query(" SELECT id, name, mobile, email FROM `staff` WHERE status = 1 ");
	//$sql .= " and better_franchisee = 2 ";
	
	 
    ?>
	  <span class="staff_text" style="margin-bottom:25px;margin-left: 20px;font-size: 16px;"> <?php echo get_rs_value("staff","name",$staff_id); ?> Invoice Report </span><br>
   <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">	 
    <tbody>
		<tr class="table_cells">
			  <td><strong>Staff Id</strong></td>
			  <td><strong>Name</strong></td>
			  <td><strong>Email</strong></td>
			  <td><strong>Mobile</strong></td>
			  <td><strong>View</strong></td>
		</tr>
			<?php 
				 if(mysql_num_rows($sql)) { 
				  while($data = mysql_fetch_assoc($sql)) {
			?>	
			<tr class="table_cells">
			
			   <td><?php echo $data['id']; ?></td>
			   <td><?php echo $data['name']; ?></td>
			   <td><?php echo $data['email']; ?></td>
			   <td><?php echo $data['mobile']; ?></td>
			   
			   <td><a href="javascript:scrollWindow('franchise_report_list.php?task=view_staff_invoice&year=2020&staff_id=<?php echo $data['id']; ?>','1200','850')">View List</a></td>
			</tr>
				  <?php   } }else { ?>		
			<tr class="table_cells">
			   <td colspan="10">No result</td>
			   
			</tr>
			
	<?php  } ?>
    </tbody>
	</table>
  