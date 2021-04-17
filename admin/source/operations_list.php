<br/>
<br/>
<br/>
<br/>
  <span class="add_jobs_text" style="margin-left: -31px;"><input onclick="javascript:window.location='../admin/index.php?task=operation_question';" type="button" class="staff_button" value="List Application"></span>

<?php  
  $query = mysql_query("SELECT *  FROM `operation_checklist` "); 
   $gettrackdata =  dd_value(112);
   $statusdata =  dd_value(57);
   
 
 ?>

	<table class="user-table" style="">
		  <thead>
				  <tr>
					<th>Id</th>
					<th>Track ID</th>
					<th>Track heading</th>
					<th>Question</th>
					<th>Status</th>
					<th>Edit</th>
				</tr>
		 </thead>
		   <tbody id="get_loadmoredata">
		   <?php  if(mysql_num_rows($query) > 0) { 
		     while($data = mysql_fetch_assoc($query)) {
				 
				 $getsubdata = getsubheading($data['tracks_id']);
		   ?>
					 <tr class="parent_tr <?php if($data['status'] == 2) {  echo 'alert_danger_tr '; } // echo $bgcolor; ?> >">
						<td><?php  echo $data['id'];?></td>
						<td><?php  echo $gettrackdata[$data['tracks_id']];?></td>
						<td><?php  echo $getsubdata[$data['track_heading']];?></td>
						<td><?php  echo $data['qus'];?></td>
						<td><?php  echo $statusdata[$data['status']];?></td>
						<td><a href="../admin/index.php?task=operation_question&opid=<?php echo $data['id']; ?>">Edit</a></td>
						
					</tr>	
			 <?php  } } ?>		
			</tbody>	
	</table>	
	

		
						   
		