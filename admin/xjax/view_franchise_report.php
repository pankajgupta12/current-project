	<style>
	 
		#message_show{
			color: green;
			margin-left: 966px;
			margin-bottom: 0px;
		}
		 
	</style>

    <div id="daily_view">
	   <span class="staff_text" style="margin-bottom:25px;"> Invoice Report </span><br>
	
		<span id="message_show"></span>
		<?php  
		  
		  $arg = "SELECT * from staff where better_franchisee = 2"; 
		  $sql = mysql_query($arg);
		  
		?>
	  
	<table width="100%" border="0" cellpadding="5" cellspacing="5" class="staff-table">	 
		<tbody>
			<tr class="table_cells">
				  <td><strong>ID</strong></td>
				  <td><strong>Staff name</strong></td>
				  <td><strong>Email</strong></td>
				  <td><strong>Mobile</strong></td>
				  <td><strong>Status</strong></td>
				  <td><strong>View</strong></td>
				  <td><strong>View List</strong></td>
			</tr>
			<?php  
			if(mysql_num_rows($sql) > 0) { 
				 while($data = mysql_fetch_assoc($sql)) {
				
					
			?>	
				<tr class="table_cells" <?php if($data['status'] == 0) { echo 'style="background-color:#cab3b3;"';} ?> >
				   <td><?php echo $data['id']; ?></td>
				   <td><?php echo $data['name']; ?></td>
				   <td><?php echo $data['email']; ?></td>
				   <td><?php echo $data['mobile']; ?></td>
				   <td><?php echo getSystemvalueByID($data['status'],1); ?></td>
				   <td><a href="javascript:scrollWindow('franchise_report_popup.php?task=view_franchise_report&year=<?php echo date('Y'); ?>&staff_id=<?php echo $data['id']; ?>','1200','850')">View</a></td>
				   <td><a href="javascript:scrollWindow('franchise_report_list.php?task=view_franchise_report_list&year=<?php echo date('Y'); ?>&staff_id=<?php echo $data['id']; ?>','1200','850')">View List</a></td>
				</tr>
			 <?php  } }else { ?>		
				<tr class="table_cells">
				   <td colspan="20">No result</td>
				   
				</tr>
				
		<?php  } ?>
		</tbody></table>
	</div>
	
	
	