<?
	if(!isset($_SESSION['reclean']['reclean_from_date_1'])){ $_SESSION['reclean']['reclean_from_date_1'] = date("Y-m-1"); }
	if(!isset($_SESSION['reclean']['to_date_1'])){ $_SESSION['reclean']['to_date_1'] = date("Y-m-t"); }
	if(!isset($_SESSION['reclean']['status'])){ $_SESSION['reclean']['status'] = 5; }
	
	
	
		
		$arg = "SELECT * FROM `job_details` WHERE status != 2 and job_id in (SELECT id from jobs WHERE status IN (5 ,9))";
		
		
		if(isset($_SESSION['reclean']['reclean_from_date_1']) && $_SESSION['reclean']['to_date_1'] != NULL && $_SESSION['reclean']['to_date_1'] != 0 )
		{
			
			$arg .= " AND job_date <= '".date('Y-m-d')."'";
		}
		$arg .=	" Group by job_id Order by job_date desc";
	
	$data = mysql_query($arg);
	
	$countResult1 = mysql_num_rows($data);
	
	//echo $countResult1;
	 
	 
?>

		<div class="right_text_box" >
		    <div class="midle_staff_box"> <span class="midle_text">Total Records Found <?php  getTotalrecord($arg); ?> </span></div>
		</div>
	<div class="usertable-overflow">
			<table class="user-table">
			
				<thead>
				  <tr>
					<th>Job Id</th>
					<th>Site</th>
					<th>Staff name</th>
					<th>Quote Name</th>
					<th>job Date</th>
					<th>Total Amount</th> 
					<th>Job Status</th>  
					<th>Client Email</th>  
				  </tr>	  
				</thead>
				
				<tbody id="get_loadmoredata">
					<?php if (mysql_num_rows($data)>0){ 
						
						$row1 = 1;
						$counter = 0;
						while( $row = mysql_fetch_assoc($data) ) 
						{ 
						   
					   
						 $argSql  = mysql_query("select * from job_reclean where job_id=".$row['job_id']." and status!=2");	
						 
						 $status = get_rs_value("jobs","status",$row['job_id']);
						 if(mysql_num_rows($argSql) == 0 || $status == 9)	{	 
						
						$siteDetails =  mysql_fetch_assoc(mysql_query("select name, abv from sites  where id = ".$row['site_id'].""));
						
						$quotedetails =  mysql_fetch_assoc(mysql_query("select name  from quote_new  where booking_id = ".$row['job_id'].""));
						
						
						
						$unassign_email_date = get_rs_value("jobs","unassign_email_date",$row['job_id']);
						    if($unassign_email_date != '0000-00-00 00:00:00') {echo  changeDateFormate($unassign_email_date,'datetime');}
					?>
						<tr class="parent_tr <?php if(callPaytype($row['job_id']) == 'No Payment Found!') {echo "alert_danger_tr";} ?>">
							 <td ><a href="javascript:scrollWindow('popup.php?task=job_reclean&job_id=<?php echo $row['job_id']; ?>','1200','850')"><?php echo $row['job_id']; ?></a></td>
							 <td><?php echo $siteDetails['name']; ?></td>
							 <td><?php echo getjobstaff($row['job_id']);//echo get_rs_value("staff","name",$row['staff_id']);  ?></td>
							 <td><?php echo ucwords($quotedetails['name']); ?></td>
							 <td ><?php echo changeDateFormate($row['job_date'],'datetime'); ?></td>
							 <td ><?php echo callPaytype($row['job_id']);   ?></td>
							 <td rowspan=''><?php echo  getSystemDDname($status,26);  ?></td>
							 
							 <td title="<?php if($unassign_email_date != '0000-00-00 00:00:00') {echo  changeDateFormate($unassign_email_date,'timestamp');} ?>"><a style="color:blue;cursor: pointer;" href="javascript:scrollWindow('reclean_unassign_email.php?job_id=<?php echo $row['job_id']; ?>','750','750')">Email Client</a><br/>
							    <?php if($unassign_email_date != '0000-00-00 00:00:00') {echo  changeDateFormate($unassign_email_date,'datetime');} ?>
							 </td>
						</tr>	
					   <?php 
					   
					   } 
					   } } ?>	
					  
				</tbody>
			</table>
	</div>

<style>
   .buttone_msgsend
   {
        width: 50px;
        border: 1px solid;
        background: green;
        cursor: pointer;
        padding: 3px;

    }

</style>
