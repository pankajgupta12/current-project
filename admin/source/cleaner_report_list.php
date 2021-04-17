<?php 

//print_r($_REQUEST);
$staff_id = mysql_real_escape_string($_REQUEST['staff_id']);
$date = explode('/' , mysql_real_escape_string($_REQUEST['date']));
$from_date = $date[0];
$to_date = $date[1];

$getjobsdetails = get_total_job($from_date , $to_date, $staff_id);

 $staff_details = mysql_fetch_array(mysql_query("SELECT name , mobile  FROM `staff` WHERE `id` = '".$staff_id."'"));
?>

    <div>
	  <span style="float: left;font-size: 16px;font-weight: 600;"><?php echo $staff_details['name']; ?> (<a href="tel:"><?php echo $staff_details['mobile']; ?></a>)</span> 
      
	  <span style="float: right;font-size: 16px;font-weight: 600;">Job List From (<?php echo changeDateFormate($from_date , 'datetime');  ?>) To (<?php echo changeDateFormate($to_date , 'datetime');  ?>) </span>
	 <br><br>

			<table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">
					
					<tr class="table_cells">
					  <td><strong>Job ID</strong></td>
					  <td><strong>Client Name</strong></td>
					  <td><strong>Client Number</strong></td>
					  <td><strong>Job date</strong></td>
					  <td><strong>Job Type</strong></td>
					  <td><strong>Issue type</strong></td>
					  <td><strong>Issue Notes</strong></td>
					  
					</tr>  
					<tbody>		
					 <?php 
					foreach($getjobsdetails['jobs'] as $key=>$jobs_id) {

					   $quote = mysql_fetch_array(mysql_query("SELECT *  FROM `quote_new` WHERE `booking_id` = '".$jobs_id."'"));
					  $getissue_type =  get_issue_type($jobs_id ,$staff_id);
					 ?>
					 
						<tr class="table_cells ">
						   <td><?php echo $jobs_id;  ?></td>
						   <td><?php echo $quote['name'] ?></td>
						   <td><a href="tel:<?php echo $quote['phone'] ?>"><?php echo $quote['phone'] ?></a></td>
						   <td><?php echo changeDateFormate($quote['booking_date'] , 'datetime'); ?></td>
						   <td><?php echo get_job_type_name($jobs_id ,$staff_id); ?></td>
						   <td> <?php  if(!empty($getissue_type['heading'])) { echo $getissue_type['heading']; }else { echo 'N/A' ; }  ?> </td>
						   <td> <?php  if(!empty($getissue_type['comment'])) { echo $getissue_type['comment']; }else { echo 'N/A' ; }  ?> </td>
						</tr>
					 <?php  } ?>
					 
					</tbody> 
			</table>		 
	</div>