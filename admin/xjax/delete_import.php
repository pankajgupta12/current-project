<?php 
	//$getimport = mysql_query("SELECT * FROM `c3cx_imports` order by id desc"); 
	$getimport = mysql_query("SELECT I.datetime as datetime,I.admin_id as admin_id,  I.id as id,I.filename as filename, I.file_path FROM `c3cx_calls` C,c3cx_imports I WHERE I.id = C.import_id GROUP by C.import_id ORDER by C.call_date DESC limit 0 ,50"); 
	

	
	$CountResult = mysql_num_rows($getimport);
	//SELECT * FROM `c3cx_calls` C,c3cx_imports I WHERE I.id = C.import_id ORDER by C.call_date
 ?>
 
    <table class="user-table">
		<thead>
		   <th>ID</th>
		   <th>Filename</th>
		   <th>Starts date</th>
		   <th>End date</th>
		   <th>Number of calls</th>
		   <th>Calls identified,</th>
		   <th>Calls Not identified,</th>
		   <th>Uploaded Date</th>
		   <th>Uploaded name</th>
		   <th>Status Recheck</th>
		   <th>Admin Recheck</th>
		   <th>View</th>
		   <th>Delete</th>
		  
		</thead>
		<tbody>
			<?php    if(mysql_num_rows($getimport)>0) {
			 while($getData = mysql_fetch_assoc($getimport)) {
			  // print_r($getData);
			  $getarr = GetImport_Start_endDate($getData['id']);
			  
				if( isset($importID) && $importID == $getData['id'] ){
				$recheck = '<font color=red>Re-checked</font>';		
				}else{ $recheck = 'Re-check'; }
				
				if( isset($admiimportID) && $admiimportID == $getData['id'] ){
				$recheckadmin = '<font color=red>Re-checked</font>';		
				}else{ $recheckadmin = 'Re-check'; }
				
				
			 ?>		 
			<tr id="import_delete_<?php echo $getData['id']; ?>">
				<td><?php echo $getData['id']; ?></td>
					<td><a href="<?php echo  $getData['file_path'] ?><?php echo $getData['filename']; ?>" download><?php echo $getData['filename']; ?></a></td>
				<td><?php echo changeDateFormate($getarr['startDate'],'datetime'); ?></td>
				<td><?php echo changeDateFormate($getarr['endDate'],'datetime'); ?></td>
				<td><?php echo $getarr['totalCount']; ?></td>
				<td><?php echo $getarr['getTotalofCallidentify']; ?></td>
				<td><?php echo $getarr['nonidentifycall']; ?></td>
				<td><?php echo changeDateFormate($getData['datetime'],'timestamp'); ?></td>
				<td><?php echo get_rs_value("admin","name",$getData['admin_id']); ?></td>
				<td><a  style="cursor: pointer;" Onclick="send_data('<?php echo $getData['id'];?>','114','quote_view')"><img src="../admin/icones/icone/recheck.png" style="width: 23px;"/><?php echo $recheck; ?></td>
				
				<td><a  style="cursor: pointer;" Onclick="send_data('<?php echo $getData['id'];?>','115','quote_view')"><img src="../admin/icones/icone/recheck.png" style="width: 23px;"/><?php echo $recheckadmin; ?></td>
				
				<td><a href="../admin/index.php?task=importview&import_id=<?php echo $getData['id']; ?>" style="color: blue;"><img src="../admin/icones/icone/view_file.png" style="width: 23px;"/></a></td>
				<td><a  style="cursor: pointer;" Onclick="deleteimportfilesByid('<?php echo $getData['id'];?>','import_delete_<?php echo $getData['id']; ?>')"><img src="../admin/icones/icone/file_delete.png" style="width: 23px;"/></a></td>
			</tr>	
			 <?php  } }else { ?>   
			<tr><td colspan="20"> No found Result</td></tr>
			 <?php  } ?>
		</tbody>
	</table>
		 