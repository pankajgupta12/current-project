<?php 

if(!isset($_SESSION['calling_date']['date'])){ $_SESSION['calling_date']['date'] = date("Y-m-d" , strtotime('-1 day')); }
if(!isset($_SESSION['calling_date']['admin_id'])){ $_SESSION['calling_date']['admin_id'] = 0; }


  $arg = "SELECT * FROM `c3cx_calls` WHERE   to_number in (SELECT 3cx_extension_number FROM `c3cx_users` WHERE is_active = 1 and team_type = 1 ) ";
  
   if(isset($_SESSION['calling_date']['date']) && $_SESSION['calling_date']['date'] != NULL )
	{ 
       $arg .= " AND call_date = '".$_SESSION['calling_date']['date']."' ";
	}
	
	if(isset($_SESSION['calling_date']['admin_id']) && $_SESSION['calling_date']['admin_id'] != 0 )
	{ 
       $arg .= "    AND admin_id = ".$_SESSION['calling_date']['admin_id']."";
	}
	 
	  $arg .= "  ORDER BY call_date_time ASC";
	//echo $arg;
	$sqlquery = mysql_query($arg);
  $count = mysql_num_rows($sqlquery);
  
  //echo  $count;
?>  
<div id="daily_view">
 <span class="staff_text" style="margin-bottom:25px;"> Daily Incomming Call report  </span>
<h5 style="margin-left: 615px;margin-top: -50px;font-size: 16px;color: #5abece;">Total Result <?php echo $count; ?></h5>
<br/>
  <table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-table">
       <tbody>
	     <tr class="table_cells">
			  <th>ID</th>
			  <th>Phone (From)</th>
			  <th>Admin Name (To)</th>
			  <th>Quote id</th>
			  <th>job id</th>
			  <th>Staff id</th>
			  <th>Duration</th>
			  <th>Call date</th>
		</tr>
			
	 <?php  

   $i = 1;
     if($count > 0) {

	   while($getdata = mysql_fetch_assoc($sqlquery)) {
       
	      
				 
	   ?>	 
	   
	   
		<tr>	
			  <td><?php echo $i; ?></td>
			  <td><?php echo $getdata['from_number']; ?></td>
			  <td><?php echo get_rs_value('c3cx_users', '3cx_extension_number', $getdata['admin_id']); ?></td>
			  <td><?php echo $getdata['quote_id']; ?></td>
			  <td><?php echo $getdata['job_id']; ?></td>
			  <td><?php echo get_rs_value('staff', 'name' , $getdata['staff_id']); ?></td>
			  <td><?php echo $getdata['duration']; ?></td>
			  <td><?php echo changeDateFormate($getdata['call_date_time'] , 'timestamp'); ?></td>
		</tr>
		
	   <?php $i++; } }else { ?>
		 <tr>	
			  <td colspan="20">No Result Found</td>
			  
		</tr>
	 <?php  } ?>
		 </tbody>
    </table>		
	</div>