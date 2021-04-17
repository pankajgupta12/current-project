<?php 

if(!isset($_SESSION['message_board']['from_date'])){ $_SESSION['message_board']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['message_board']['to_date'])){ $_SESSION['message_board']['to_date'] = date("Y-m-t"); }

  $arg = "select * from message_board where 1 = 1 AND status = 1 ";
  
 if(isset($_SESSION['message_board']['from_date']) && $_SESSION['message_board']['to_date'] != NULL )
	{ 
       $arg .= " AND createdOn >= '".date('Y-m-d',strtotime($_SESSION['message_board']['from_date']))."' AND createdOn <= '".date('Y-m-d',strtotime($_SESSION['message_board']['to_date']))."'";
	}
	
	if(isset($_SESSION['message_board']['job_id']) && $_SESSION['message_board']['job_id'] != NULL )
	{ 
       $arg .= "    AND (subject Like '%".$_SESSION['message_board']['job_id']."%' OR message Like '%".$_SESSION['message_board']['job_id']."%')";
	}
	
	//echo $arg;
	$sqlquery = mysql_query($arg);
  $count = mysql_num_rows($sqlquery);
  
  //echo  $count;
?>  
<div id="daily_view">
 <span class="staff_text" style="margin-bottom:25px;"> Message Board </span>
<h5 style="margin-left: 615px;margin-top: -50px;font-size: 16px;color: #5abece;">Total Result <?php echo $count; ?></h5>
<br/>
  <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-table">
       <tbody>
	     <tr class="table_cells">
			  <td>ID</td>
			  <td>Message From</td>
			  <td>Message To</td>
			  <td>Subject</td>
			  <td>Message</td>
			  <!--<td>Priority</td>-->
			  <td>Message Sent date</td>
			  <td>Message read By</td>
			  <td>Message read Date</td>
			  <td>Reply Message</td>
			  <td>Reply Date</td>
		</tr>
			
	 <?php  

     if($count > 0) {

	   while($getdata = mysql_fetch_assoc($sqlquery)) {
       
	       $getadminto =  explode(',', $getdata['message_to']); 
		   $str = '';
		   
		 //  print_r($getadminto);
			      foreach($getadminto as $value) {
					$str .= get_rs_value('admin' , 'name' , $value).' , ';
				 } 
				 
	   ?>	 
	   
	   
		<tr>	
			  <td><?php echo $getdata['id']; ?></td>
			  <td><?php echo get_rs_value('admin' , 'name' , $getdata['message_from']); ?></td>
			  <td><?php 
			     echo rtrim($str , ' ,');
			     ?></td>
			  <td><?php echo $getdata['subject']; ?></td>
			  <td><?php echo $getdata['message']; ?></td>
			  <!--<td><?php //echo getSystemDDname($getdata['priority'] , 53); ?></td>-->
			  <td><?php echo changeDateFormate($getdata['createdOn'] , 'timestamp'); ?></td>
			  <td><?php echo explode('_' , $getdata['message_read_user'])[0]; ?></td>
			  <td><?php echo changeDateFormate(str_replace(')' , '' , str_replace('(' , '' , explode('_' , $getdata['message_read_user'])[1])) , 'timestamp');  ?></td>
			  <td><?php echo $getdata['replay_text']; ?></td>
			  <td><?php if($getdata['replay_date'] != '0000-00-00 00:00:00') { echo changeDateFormate($getdata['replay_date'] , 'timestamp'); }?></td>
		</tr>
		
	   <?php  } }else { ?>
		 <tr>	
			  <td colspan="20">No Result Found</td>
			  
		</tr>
	 <?php  } ?>
		 </tbody>
    </table>		
	</div>