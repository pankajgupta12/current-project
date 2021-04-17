<?php 

if(!isset($_SESSION['urgent_notification']['login_id'])){ $_SESSION['urgent_notification']['login_id'] = 0; }
if(!isset($_SESSION['urgent_notification']['message_status'])){ $_SESSION['urgent_notification']['message_status'] = 0; }


    $getdatainf=  GetAlownotification();
    $str = '5,6 ';
	
	if(in_array($_SESSION['admin'] , $getdatainf)) {
     $str = '5,6,7 ,8';
    }
	
	$staff_notification= "select id,quote_id , app_id ,  notifications_type, job_id ,p_order , login_id , heading, comment , date , (SELECT name from admin WHERE id = site_notifications.login_id) as adminid , staff_name, message_status ,  (SELECT name  FROM `system_dd` WHERE `type` = '135' AND site_notifications.message_status = id ) as messageStatus from site_notifications where notifications_status = '0' AND message_status != 3 AND notifications_type IN (".$str.")  "; 
	
	if($_SESSION['urgent_notification']['login_id'] != '' && $_SESSION['urgent_notification']['login_id'] != 0) { 
	    $staff_notification .= "  AND login_id = ".$_SESSION['urgent_notification']['login_id']."";
	}
	
	if($_SESSION['urgent_notification']['message_status'] != '' && $_SESSION['urgent_notification']['message_status'] != 0)
	{ 
	    $staff_notification .= " AND  message_status = ".$_SESSION['urgent_notification']['message_status']."";
	}
	
	
		if($_SESSION['urgent_notification']['p_order'] != '' && $_SESSION['urgent_notification']['p_order'] != 0)
	{ 
	    $staff_notification .= " AND  p_order = ".$_SESSION['urgent_notification']['p_order']."";
	}
	
	$staff_notification .= "  ORDER BY p_order ASC";
	
	$sqlquery = mysql_query($staff_notification);
	
	$count = mysql_num_rows($sqlquery);
?>  

 <script>
   function deleteNotification(id, divid){
	    send_data(id,620,divid);
   }
 </script>

	<div id="daily_view">
		<span class="staff_text" style="margin-bottom:25px;"> Urgent Notification List </span>
		<br/>
		
		    <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-table">
		         <tr>
				    <td width="75%">
				           <h3 style="font-weight: bold;margin: 11px;font-size: 17px;color: #00b8d4;">  Urgent Notification List (<?php echo $count; ?>) </h3>
						<table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-table">
							
							<thead>
								<tr class="table_cells">
								      <th>ID</th>
									  <th>Delete</th>
									  <th>Job id</th>
									  <th>Quote ID</th>
									  <th>App ID</th>
									  <th>Date</th>
									  <th>Time</th>
									  <th>Assign Name</th>
									  <th>Priority</th>
									   <th>Status</th>
									  <th>Subject</th>
									  <th>Comment</th>
									 
								</tr>
							</thead>	
								<?php  
									if($count > 0) {
										$i = 0;
									while($getdata = mysql_fetch_assoc($sqlquery)) {
										$i++;
    										if($getdata['login_id'] > 0 ) {
    											  //$auto_role = get_rs_value('admin','auto_role',$getdata['login_id']);
    											  $auto_role = get_rs_value("admin","auto_role",$getdata['login_id']);
    										      $infoUser[$auto_role][$getdata['login_id']][$getdata['p_order']][] = $getdata['login_id'];
    										      
    										 }else{
    										      $infoUser[0][0][$getdata['p_order']][] = $getdata['login_id'];
    										 }
    										
										
								?>	 
								
								
							
							<tbody>	
								<tr id="urgent_notification_remove_<?php echo $getdata['id']; ?>" class = "<?php  if($getdata['login_id'] == 0) { ?> alert_danger_tr   <?php  } ?>" >	
								     <td><?php echo $i; ?></td>
								     <?php if($getdata['message_status'] == 3) { ?>
									  <td><b><a href="javascript:deleteNotification('<?php echo $getdata['id']; ?>' , 'urgent_notification_remove_<?php echo $getdata['id']; ?>');" style="color:red;">X</a></b></td>
									  <?php  }else{ ?> 
									  <td>N/A</td>
									  <?php  } ?>
									  <td>
									      <?php if($getdata['job_id'] > 0) { ?>
									      <a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $getdata['job_id']; ?>','1200','850')"><?php echo $getdata['job_id']; ?></a>
									    <?php } ?> 
									  </td>
									   <td>
									    <?php if($getdata['quote_id'] > 0) { ?>
									      <a href="../admin/index.php?task=edit_quote&quote_id=<?php echo $getdata['quote_id'];  ?>"><?php echo $getdata['quote_id'];  ?></a>
									    <?php } ?> 
									   </td>  
									  <td>
									    <?php if($getdata['app_id'] > 0) { ?>
									        <a href="javascript:scrollWindow('application_popup.php?task=appl&appl_id=<?php echo $getdata['app_id'];  ?>','800','700')"><?php echo $getdata['app_id'];  ?></a>
									    <?php  } ?>
									   </td>
									  <td><?php echo date('M d Y', strtotime($getdata['date'])); ?></td>
									  <td><?php echo date('H:i:s', strtotime($getdata['date'])); ?></td>
									   <td><?php echo create_dd("login_id","admin","id","name"," status = 1 AND is_call_allow = 1","onchange=\"javascript:edit_field(this,'site_notifications.login_id','".$getdata['id']."')\"",$getdata,'field_id'); ?></td>
									  <td><?php echo create_dd("p_order","system_dd","id","name"," type = 151","onchange=\"javascript:edit_field(this,'site_notifications.p_order','".$getdata['id']."')\"",$getdata,'field_id');?></td>
									  <td><?php echo create_dd("message_status","system_dd","id","name"," type = 135","onchange=\"javascript:edit_field(this,'site_notifications.message_status','".$getdata['id']."')\"",$getdata,'field_id');?></td>
									  <td><?php echo $getdata['heading']; ?></td>
									  <td><?php echo $getdata['comment']; ?></td>
									  
								</tr>
								<?php  } }else { ?>
								<tr>	
									<td colspan="20">No Result Found</td>
								</tr>
								<?php  } ?>
							</tbody>
						</table>
				    </td>
					
			<td width="35%" style="font-weight: bold;margin: 11px;font-size: 15px;color: #00b8d4;" valign="top">
			     <h3>Task Assigned (<?php echo $count; ?>)</h3>
				<table width="100%" border="1">
				<tbody>
				    
					<tr>
                            <td>Role</td>
                            <td>Name</td>
                            <td>Total</td>
                            <td style="background: #f08181;">P1</td>
                            <td style="background: #894b00;color: #fff;">P2</td>
                            <td style="background: rgb(255 165 0 / 52%);">P3</td>
                            <td style="background: #ffb66b;">P4</td>
                            <td style="background: #FFFF00;">P5</td>
                            
						</tr>    
				    
				  <?php  
				  
				  foreach($infoUser as $key=>$value) { 
				  
				  ?>
						<tr>
						    <td><?php if($key > 0) { echo getSystemvalueByID($key, '102'); } else {echo 'Not assigned ';}?></td> 
						    <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            
						</tr>
						
						<?php  foreach($value as $key1=>$data1) { 
						
                            $count = 0;
                            foreach ($data1 as $type) {
                                 $total_count[] =  count($type);
                            }
						
						?>
						<tr>
							<td>&nbsp;</td>
							<td><?php  if($key1 > 0) { echo get_rs_value("admin","name",$key1); } ?></td>
							<td><?php  if($key1 > 0) { echo array_sum($total_count); } ?></td>
							<td><?php if(count($data1[1]) >0) { echo count($data1[1]); } ?></td>
							<td><?php if(count($data1[2]) >0) { echo count($data1[2]); } ?></td>
							<td><?php if(count($data1[3]) >0) { echo count($data1[3]); }  ?></td>
							<td><?php if(count($data1[4]) >0) { echo count($data1[4]); }  ?></td>
							<td><?php if(count($data1[5]) >0) { echo count($data1[5]); }  ?></td>
					    </tr>
						<?php unset($total_count); } 
						 ?>
						
				  <?php  } ?>
				</tbody>
				</table>

				</td>
				 </tr>
				
		    </table>		
	</div>