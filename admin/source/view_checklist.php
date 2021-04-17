<style>
<style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>

</style>

<!------ Include the above in your HEAD tag ---------->
<div class="body_container">
	<div class="body_back">
	  <span class="main_head" style="margin-bottom: -33px;">CheckList Update</span>
	   <span id="message_show"></span>
		<br/>
		<br/>
		<br/>
		 <?php  
		 
		  $job_id = $_REQUEST['job_id'];
		 $sql = mysql_query("SELECT * FROM `job_checklist` WHERE job_id= ".$job_id." order by checklist_type_id asc");
		 
		
		   $checktypearray = array(1=>'Before Job', 2=>'On the Day' ,3=>'others');
		
		 ?>
         <br>
			<div id="save_clener_notes" class="col-md-12"> 
				<table  border="1" id="customers" width="100%">
					<tr>
						 <td><strong>Id</strong></td>
						 <td><strong>Type</strong></td>
						 <td><strong>Subject</strong></td>
						 <td><strong>Status</strong></td>
						 <td><strong>Comments</strong></td>
						 <td><strong>Send/Start Time</strong></td>
						 <!--<td><strong>CreatedOn</strong></td>-->
					</tr>
				   
				   <?php   

				     
					  $i = 1;
					  $flag = 1;
					  $checkflag = 0;
          while($data = mysql_fetch_assoc($sql)) {
		           
				   if($data['status'] == 1){
					      $img = 'check_agree.png';
				   }else{
					   $img = 'no_icon.png';
				   }
				   
				  
				   
				   ?>
				    <tr>
						<td><?php  echo $data['id']; ?></td>
						<td><?php  if($i== $data['checklist_type_id']){$i++; echo ucfirst($checktypearray[$data['checklist_type_id']]); } ?></td>
						<td><?php  echo $data['check_type_text']; ?></td>
						<td><img src="../admin/images/<?php echo $img; ?>" style="height: 23px;padding: 2px;"></td>
						
						<td><textarea rows="2" cols="75" style="width: 100%;height: 40px;" name="comment" onblur="javascript:edit_field(this,'job_checklist.comment','<?php  echo $data['id']; ?>')"><?php  echo trim($data['comment']); ?></textarea></td>
						
						<td><?php  if($data['send_date_time'] != '0000-00-00 00:00:00') { echo $data['createdOn'];  } ?></td>
						<!--<td><?php  echo $data['createdOn']; ?></td>-->
				    </tr>
           <?php 

		   } ?>				
				
				</table>
				
			</div> 
<br>
</div>

