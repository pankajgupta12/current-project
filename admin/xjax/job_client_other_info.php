<?php  
    
	if($j_id != '') {
	   $j_id = $j_id;
	}else {
	   $j_id = $_REQUEST['job_id'];
	}
    
    $client_details_sql =  mysql_query("SELECT * FROM `job_client_other_info` where job_id = ".$j_id."");
?>		
				   <table border="1" cellpadding="10" >
					    <tr>
							 <th>ID</th>
							 <th>Name</th>
							 <th>Email</th>
							 <th>Number</th>
							 <th>CreatedOn</th>
							 <th>Delete</th>
						</tr> 
						
				<?php  if(mysql_num_rows($client_details_sql) > 0) {
                  $j = 1;  while($getClientDetails = mysql_fetch_assoc($client_details_sql)) {
  				?>		
						<tr>
						   <td><?php echo $j; ?></td>
						   <td><?php echo $getClientDetails['secondary_name']; ?></td>
						   <td><?php echo $getClientDetails['secondary_email']; ?></td>
						   <td><?php echo $getClientDetails['secondary_number']; ?></td>
						   <td><?php echo date('d M h:i' , strtotime($getClientDetails['createdOn'])); ?></td>
						   <td><a href="javascript:delete_client_info('<?php echo $getClientDetails['id']; ?>|<?php echo $getClientDetails['job_id']; ?>');">Delete</td>
						</tr>
					<?php $j++; } }else { ?>
						<tr>
							   <td colspan="6">No Records</td>
						</tr>
					<?php  } ?>					
					 </table>