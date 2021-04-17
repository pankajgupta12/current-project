<?php 

if(!isset($_SESSION['daily_report']['from_date'])){ $_SESSION['daily_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['daily_report']['to_date'])){ $_SESSION['daily_report']['to_date'] = date("Y-m-t"); }
if(!isset($_SESSION['daily_report']['site_id'])){ $_SESSION['daily_report']['site_id'] = "0"; }
if(!isset($_SESSION['daily_report']['staff_id'])){ $_SESSION['daily_report']['staff_id'] = "0"; }
if(!isset($_SESSION['daily_report']['job_type'])){ $_SESSION['daily_report']['job_type'] = "1"; }

//print_r($_SESSION['daily_report']);
// create full report of each site from date to date 
// if site id is selected, will show day by day report of the site 
// if staff id is selected will show how much work that staff member have done in that period of time 

$checkadmin = array(1,4,5);
echo '<span class="staff_text" style="margin-bottom:25px;">Quotes & Jobs</span><br/>';

$arg = "Select * from sites ";
$sites = mysql_query($arg);
echo '<table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">';
	
	echo '<tr class="table_cells">
		  <td><strong>Site</strong></td>
		  <td colspan="6"><strong>From Quotes</strong></td>
		  <td colspan="15"><strong>From Jobs</strong></td>
		</tr>';
	 ?>
	<tr class="table_cells">
		  <td>Site</td>
		  <td>Total Quotes</td>
		  <td>Quotes By Phone</td>
		  <!--<td>Quotes By Email</td>-->
		  <td>Quotes By Site</td>
		  <!--<td>Quotes By Chat</td>
		  <td>Quotes By Others</td>-->
		  <td>Jobs Booked</td>
		  <td>Total Jobs</td>
		  <td>Cancelled</td>
		  <td>Jobs Finished</td>
		  <td>Hours Worked</td>
	  <?php  if (in_array($_SESSION['admin'], $checkadmin)) { ?>
		  <td>Sales</td>
		  <?php   if($_SESSION['daily_report']['job_type'] == 1) { ?>
		  <td>Cleaning</td>
		  <td>Cleaning Profit</td>
		  <td>Carpet</td>
		  <td>Carpet Profit</td>
		  <td>Pest</td>
		  <td>Pest Profit</td>
		  <td>Others</td>
		  <td>Others Profit</td>
          <td>Total Profit</td>		  
		  <?php  }else { ?> 
		  <td>Total Removal</td>
		  <td> Removal Profit</td>
		  <?php  }  ?>
	  <?php  } ?>
	</tr>

<?php  		
while($r = mysql_fetch_assoc($sites)){
	
	$q_chat = 0;
	$cleaning_amt = 0;
	$amount_profit = 0;
	$carpet_amt = 0;
	$carpet_profit = 0;
	$pest_amt = 0;
	$pest_profit = 0;
	$other_amt = 0;
	$other_profit = 0;
	$removal_profit = 0;
	
	
	//AND id in (SELECT quote_id from quote_details WHERE job_type_id = 11 )
	//$_SESSION['daily_report']['from_date']
	
	   /* ================================================================================== */
			$total_quotes_data_sql = "SELECT count(*) as total_quotes FROM `quote_new` WHERE date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and date<='".$_SESSION['daily_report']['to_date']."'  AND step not in (7) and site_id=".$r['id']."";
		
			if($_SESSION['daily_report']['job_type'] == 2) {
				$total_quotes_data_sql .= " AND id in (SELECT quote_id from quote_details WHERE job_type_id = 11 )";
			}else{
				$total_quotes_data_sql .= " AND id in (SELECT quote_id from quote_details WHERE job_type_id != 11 )";
			}
			
			//echo $total_quotes_data_sql;

		   $total_quotes_data = mysql_query($total_quotes_data_sql);
		   $total_quotes_row = mysql_fetch_array($total_quotes_data);
		   $total_quotes = $total_quotes_row['total_quotes'];
	   
	   /* ================================================================================== */
	
			$q_phone_data_sql = "SELECT count(*) as q_phone FROM `quote_new` WHERE job_ref='Phone' AND step not in (7) and date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and date<='".$_SESSION['daily_report']['to_date']."' and site_id=".$r['id']."";
			
			 if($_SESSION['daily_report']['job_type'] == 2) {
					$q_phone_data_sql .= " AND id in (SELECT quote_id from quote_details WHERE job_type_id = 11 )";
				}else{
					$q_phone_data_sql .= " AND id in (SELECT quote_id from quote_details WHERE job_type_id != 11 )";
				}
			$q_phone_data = mysql_query($q_phone_data_sql);
			$q_phone_row = mysql_fetch_array($q_phone_data);
			$q_phone = $q_phone_row['q_phone'];
     /* ================================================================================== */	
	
		/* $q_email_data_sql = "SELECT count(*) as q_email FROM `quote_new` WHERE job_ref='Email' AND step not in (7)  and date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and date<='".$_SESSION['daily_report']['to_date']."' and site_id=".$r['id']."";
		
		        if($_SESSION['daily_report']['job_type'] == 2) {
					$q_email_data_sql .= " AND id in (SELECT quote_id from quote_details WHERE job_type_id = 11 )";
				}else{
					$q_email_data_sql .= " AND id in (SELECT quote_id from quote_details WHERE job_type_id != 11 )";
				}
				
		$q_email_data = mysql_query($q_email_data_sql);
		$q_email_row = mysql_fetch_array($q_email_data);
		$q_email = $q_email_row['q_email']; */
	
	 /* ================================================================================== */	
			// FROM Site
			$q_site_data_sql = "SELECT count(*) as q_site FROM `quote_new` WHERE job_ref='Site' AND step not in (7)  and date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and date<='".$_SESSION['daily_report']['to_date']."' and site_id=".$r['id']."";
			
			    if($_SESSION['daily_report']['job_type'] == 2) {
						$q_site_data_sql .= " AND id in (SELECT quote_id from quote_details WHERE job_type_id = 11 )";
				}else{
					 $q_site_data_sql .= " AND id in (SELECT quote_id from quote_details WHERE job_type_id != 11 )";
				}
			
			$q_site_data = mysql_query($q_site_data_sql);
			
			$q_site_row = mysql_fetch_array($q_site_data);
			$q_site = $q_site_row['q_site'];
	
	 /* ================================================================================== */	
	
			// From chat
			/* $q_chat_data_sql = mysql_query("SELECT count(*) as q_chat FROM `quote_new` WHERE job_ref='Chat' AND step not in (7)  and date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and date<='".$_SESSION['daily_report']['to_date']."' and site_id=".$r['id']."");
			
			  if($_SESSION['daily_report']['job_type'] == 2) {
					$q_chat_data_sql .= " AND id in (SELECT quote_id from quote_details WHERE job_type_id = 11 )";
				}else {
					$q_chat_data_sql .= " AND id in (SELECT quote_id from quote_details WHERE job_type_id != 11 )";
				}
				
			$q_chat_data = mysql_query($q_chat_data_sql);
			$q_chat_row = mysql_fetch_array($q_chat_data);
			$q_chat = $q_chat_row['q_chat']; */
	
	// From Others 
	 /* ================================================================================== */	
	/* $q_others_data_sql = "SELECT count(*) as q_others FROM `quote_new` WHERE job_ref='0' AND step not in (7)  and date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and date<='".$_SESSION['daily_report']['to_date']."' and site_id=".$r['id']."";
	
	            if($_SESSION['daily_report']['job_type'] == 2) {
					 $q_others_data_sql .= " AND id in (SELECT quote_id from quote_details WHERE job_type_id = 11 )";
				}else{
					 $q_others_data_sql .= " AND id in (SELECT quote_id from quote_details WHERE job_type_id != 11 )";
				}
	$q_others_data = mysql_query($q_others_data_sql);
	$q_others_row = mysql_fetch_array($q_others_data);
	$q_others = $q_others_row['q_others']; */
	
	
 /* ================================================================================== */	
	$jobs_booked_data_sql = "SELECT count(*) as jobs_booked FROM `quote_new` WHERE booking_id!=0  AND step not in (7)  and date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and date<='".$_SESSION['daily_report']['to_date']."' and site_id=".$r['id']."";
	
	            if($_SESSION['daily_report']['job_type'] == 2) {
						$jobs_booked_data_sql .= " AND id in (SELECT quote_id from quote_details WHERE job_type_id = 11 )";
				}else{
					 $jobs_booked_data_sql .= " AND id in (SELECT quote_id from quote_details WHERE job_type_id != 11 )";
				}
				
	//echo $jobs_booked_data_sql;			
	$jobs_booked_data = mysql_query($jobs_booked_data_sql);
	
	$jobs_booked_row = mysql_fetch_array($jobs_booked_data);
	$jobs_booked = $jobs_booked_row['jobs_booked'];
	
	
	 /* ================================================================================== */	
	
	$jobs_cancelled_data_sql = "SELECT count(*) as jobs_cancelled FROM `jobs` WHERE status=2 and date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and date<='".$_SESSION['daily_report']['to_date']."' and site_id=".$r['id']."";
	
	             if($_SESSION['daily_report']['job_type'] == 2) {
						$jobs_cancelled_data_sql .= " AND id in (SELECT job_id from job_details WHERE job_type_id = 11 )";
				}else{
					$jobs_cancelled_data_sql .= " AND id in (SELECT job_id from job_details WHERE job_type_id != 11 )";
				}
	$jobs_cancelled_data = mysql_query($jobs_cancelled_data_sql);
	
	$jobs_cancelled_row = mysql_fetch_array($jobs_cancelled_data);
	$jobs_cancelled = $jobs_cancelled_row['jobs_cancelled'];
	
	
	 /* ================================================================================== */	
	$total_jobs_data_sql = "SELECT count(*) as total_jobs FROM `jobs` WHERE date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and date<='".$_SESSION['daily_report']['to_date']."' and site_id=".$r['id']."";
	
	            if($_SESSION['daily_report']['job_type'] == 2) {
						$total_jobs_data_sql .= " AND id in (SELECT job_id from job_details WHERE job_type_id = 11 )";
				}else{
						$total_jobs_data_sql .= " AND id in (SELECT job_id from job_details WHERE job_type_id != 11 )";
				}
				
	$total_jobs_data = mysql_query($total_jobs_data_sql);			
	
	$total_jobs_row = mysql_fetch_array($total_jobs_data);
	$total_jobs = $total_jobs_row['total_jobs'];
	
	
	 /* ================================================================================== */	
	$jobs_done_data_sql = "SELECT count(*) as jobs_done FROM `jobs` WHERE status in(1,3) and date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and date<='".$_SESSION['daily_report']['to_date']."' and site_id=".$r['id']."";
	
	
	            if($_SESSION['daily_report']['job_type'] == 2) {
						$jobs_done_data_sql .= " AND id in (SELECT job_id from job_details WHERE job_type_id = 11 )";
				}else{
						$jobs_done_data_sql .= " AND id in (SELECT job_id from job_details WHERE job_type_id != 11 )";
				}
				
	//echo  $jobs_done_data_sql;			
	$jobs_done_data = mysql_query($jobs_done_data_sql);	
	$jobs_done_row = mysql_fetch_array($jobs_done_data);
	$jobs_done = $jobs_done_row['jobs_done'];

	 /* ================================================================================== */	
	$hours_done_arg = "SELECT sum(hours) as hours_done FROM `quote_details` where quote_id in (SELECT quote_id FROM `jobs` WHERE status in(1,3) and date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and date<='".$_SESSION['daily_report']['to_date']."' and site_id=".$r['id'].")";	
	
	 if($_SESSION['daily_report']['job_type'] == 2) {
						$hours_done_arg .= " AND job_type_id = 11";
				}else{
					$hours_done_arg .= " AND job_type_id != 11";
				}
	//echo $hours_done_arg;			
	$hours_done_data = mysql_query($hours_done_arg);	
	$hours_done_row = mysql_fetch_array($hours_done_data);	
	$hours_done=$hours_done_row['hours_done'];
	
	 /* ================================================================================== */	
	
	$sales_data_sql = "SELECT sum(customer_amount) as sales FROM `jobs` WHERE status in(1,3) and date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and date<='".$_SESSION['daily_report']['to_date']."' and site_id=".$r['id']."";
	
	 if($_SESSION['daily_report']['job_type'] == 2) {
						$sales_data_sql .= " AND id in (SELECT job_id from job_details WHERE job_type_id = 11 )";
				}else{
					$sales_data_sql .= " AND id in (SELECT job_id from job_details WHERE job_type_id != 11 )";
				}
	$sales_data = mysql_query($sales_data_sql);	
	

	$sales_row = mysql_fetch_array($sales_data);
	$sales = $sales_row['sales'];
	
	
	
    if($_SESSION['daily_report']['job_type'] == 1) {
			/* ================================================================================== */	

		$job_details_data_sql = "SELECT sum(amount_total) as cleaning_amt  FROM `job_details` WHERE job_type='Cleaning' and status!=2 and job_date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and job_date<='".$_SESSION['daily_report']['to_date']."' 
			and site_id=".$r['id']."   AND (end_time != '0000-00-00 00:00:00' OR job_id in (select id from jobs where status = 3))";


			$job_details_data = mysql_query($job_details_data_sql);	

			$job_details_row = mysql_fetch_array($job_details_data);
			$cleaning_amt = $job_details_row['cleaning_amt'];

			/* ================================================================================== */	

			$job_details_data_sql = "SELECT sum(amount_profit) as amount_profit  FROM `job_details` WHERE job_type='Cleaning' and status!=2 and job_date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and job_date<='".$_SESSION['daily_report']['to_date']."' 
			and site_id=".$r['id']."  AND (end_time != '0000-00-00 00:00:00' OR job_id in (select id from jobs where status = 3))";	

			$job_details_data = mysql_query($job_details_data_sql);	
			$job_details_row = mysql_fetch_array($job_details_data);
			$amount_profit = $job_details_row['amount_profit'];

			/* ================================================================================== */	

			$job_details_data_sql = "SELECT sum(amount_total) as carpet_amt  FROM `job_details` WHERE job_type='Carpet' and status!=2 and job_date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and job_date<='".$_SESSION['daily_report']['to_date']."' 
			and site_id=".$r['id']."  AND (end_time != '0000-00-00 00:00:00' OR job_id in (select id from jobs where status = 3))";	

			$job_details_data = mysql_query($job_details_data_sql);	
			$job_details_row = mysql_fetch_array($job_details_data);
			$carpet_amt = $job_details_row['carpet_amt'];

			/* ================================================================================== */	

			$job_details_data = mysql_query("SELECT sum(amount_profit) as carpet_profit  FROM `job_details` WHERE job_type='Carpet' and status!=2 and job_date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and job_date<='".$_SESSION['daily_report']['to_date']."' 
			and site_id=".$r['id']."  AND (end_time != '0000-00-00 00:00:00' OR job_id in (select id from jobs where status = 3))");	
			$job_details_row = mysql_fetch_array($job_details_data);
			$carpet_profit = $job_details_row['carpet_profit'];

			/* ================================================================================== */	
			$job_details_data = mysql_query("SELECT sum(amount_total) as pest_amt  FROM `job_details` WHERE job_type='Pest' and status!=2 and job_date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and job_date<='".$_SESSION['daily_report']['to_date']."' 
			and site_id=".$r['id']."  AND (end_time != '0000-00-00 00:00:00' OR job_id in (select id from jobs where status = 3))");	
			$job_details_row = mysql_fetch_array($job_details_data);
			$pest_amt = $job_details_row['pest_amt'];
			/* ================================================================================== */	

			$job_details_data = mysql_query("SELECT sum(amount_profit) as pest_profit  FROM `job_details` WHERE job_type='Pest' and status!=2 and job_date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and job_date<='".$_SESSION['daily_report']['to_date']."' 
			and site_id=".$r['id']."  AND (end_time != '0000-00-00 00:00:00' OR job_id in (select id from jobs where status = 3))");	
			$job_details_row = mysql_fetch_array($job_details_data);
			$pest_profit = $job_details_row['pest_profit'];
			/* ================================================================================== */	

			$job_details_data = mysql_query("SELECT sum(amount_total) as other_amt  FROM `job_details` WHERE job_type not in('Pest','Carpet','Cleaning') and status!=2 and job_date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and job_date<='".$_SESSION['daily_report']['to_date']."' 
			and site_id=".$r['id']."  AND (end_time != '0000-00-00 00:00:00' OR job_id in (select id from jobs where status = 3))");	
			$job_details_row = mysql_fetch_array($job_details_data);
			$other_amt = $job_details_row['other_amt'];
			/* ================================================================================== */	

			$job_details_data = mysql_query("SELECT sum(amount_profit) as other_profit  FROM `job_details` WHERE job_type not in('Pest','Carpet','Cleaning') and status!=2 and job_date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and job_date<='".$_SESSION['daily_report']['to_date']."' 
			and site_id=".$r['id']."  AND (end_time != '0000-00-00 00:00:00' OR job_id in (select id from jobs where status = 3))");	
			$job_details_row = mysql_fetch_array($job_details_data);
			$other_profit = $job_details_row['other_profit'];
			/* ================================================================================== */	
    }else {
	 
	   $job_details_data = mysql_query("SELECT sum(amount_profit) as removal_profit  FROM `job_details` WHERE  job_type_id = 11 AND  status!=2 and job_date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and job_date<='".$_SESSION['daily_report']['to_date']."' 
		and site_id=".$r['id']."  AND (end_time != '0000-00-00 00:00:00' OR job_id in (select id from jobs where status = 3))");	
		$job_details_row = mysql_fetch_array($job_details_data);
		$removal_profit = $job_details_row['removal_profit'];
		
		/* =========================================================================== */
	    $job_details_data = mysql_query("SELECT sum(amount_total) as removal_amt  FROM `job_details` WHERE  job_type_id = 11 AND  status!=2 and job_date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and job_date<='".$_SESSION['daily_report']['to_date']."' 
		and site_id=".$r['id']."  AND (end_time != '0000-00-00 00:00:00' OR job_id in (select id from jobs where status = 3))");	
		$job_details_row = mysql_fetch_array($job_details_data);
		$removal_amt = $job_details_row['removal_amt'];	
		
		/* =================================================================== */
		
		/* $job_details_data_sql = "SELECT sum(amount_profit) as amount_profit  FROM `job_details` WHERE job_type_id= 11  and status!=2 and job_date>='".date('Y-m-d' , strtotime($_SESSION['daily_report']['from_date']))."' and job_date<='".$_SESSION['daily_report']['to_date']."' 
			and site_id=".$r['id']." and job_id in (select id from jobs where status in (1,3))";	

			$job_details_data = mysql_query($job_details_data_sql);	
			$job_details_row = mysql_fetch_array($job_details_data);
			$amount_profit = $job_details_row['amount_profit']; */
	}
		
	
	//   Sum Add Records Quote
	$totals['total_quotes']+=$total_quotes;  $totals['q_phone']+=$q_phone; 	$totals['q_email']+=$q_email; 	$totals['q_site']+=$q_site;  $totals['q_chat']+=$q_chat;  $totals['q_others']+=$q_others;  $totals['jobs_booked']+=$jobs_booked; $totals['total_jobs']+=$total_jobs; 
	
	
	$totals['jobs_cancelled']+=$jobs_cancelled; 
	
	$totals['jobs_done']+=$jobs_done;
	$totals['hours_done']+=$hours_done;
	$totals['sales']+=$sales;
	$totals['cleaning_amt']+=$cleaning_amt;
	$totals['amount_profit']+=$amount_profit;
	$totals['carpet_amt']+=$carpet_amt;
	$totals['carpet_profit']+=$carpet_profit;
	
	$totals['pest_amt']+=$pest_amt;
	$totals['pest_profit']+=$pest_profit;
	$totals['other_amt']+=$other_amt;
	$totals['other_profit']+=$other_profit;
	$totals['removal_profit']+=$removal_profit;
	$totals['removal_amt']+=$removal_amt;
	 $totals['profit']+=($amount_profit+ $carpet_profit+ $pest_profit+$other_profit);
	/*  if($_SESSION['daily_report']['job_type'] == 1) { 
	  $totals['profit']+=($amount_profit+ $carpet_profit+ $pest_profit);
	 }else{
		 $totals['profit']+= $amount_profit;
	 } */
	?>
	 <tr class="table_cells">
		  <td><?php  echo  $r['name'];?></td>
		  <td><?php  echo  $total_quotes;?></td>
		  <td><?php  echo  $q_phone;?></td>
		  <!--<td><?php  echo  $q_email;?></td>-->
		  <td><?php  echo  $q_site; ?></td>
		  <!--<td><?php  echo  $q_chat; ?></td>
		  <td><?php  echo  $q_others; ?></td>-->
		  <td><?php  echo  $jobs_booked;?></td>
		  <td><?php  echo  $total_jobs;?></td>
		  <td><?php  echo  $jobs_cancelled;?></td>
		  <td><?php  echo  $jobs_done;?></td>
		  <td><?php  echo  $hours_done; ?></td>
		<?php  if (in_array($_SESSION['admin'], $checkadmin)) { ?>  
          <td><?php  if($sales !='') { echo  number_format($sales ,2); } ?></td>	
       <?php  if($_SESSION['daily_report']['job_type'] == 1) { ?>		  
		  <td><?php  if($cleaning_amt !='') { echo  number_format($cleaning_amt ,2); } ?></td>
		  <td><?php  if($amount_profit !='') { echo  number_format($amount_profit ,2); }?></td>
		  <td><?php  if($carpet_amt !='') { echo  number_format($carpet_amt ,2);} ?></td>
		  <td><?php  if($carpet_profit !='') { echo  number_format($carpet_profit ,2);} ?></td>
		  <td><?php  if($pest_amt !='') { echo  number_format($pest_amt ,2);} ?></td>
		  <td><?php  if($pest_profit !='') { echo  number_format($pest_profit ,2); }?></td>	
		  <td><?php  if($other_amt !='') { echo  number_format($other_amt ,2); }?></td>
		  <td><?php  if($other_profit !='') { echo  number_format($other_profit ,2); } ?></td>	
         <td><?php  echo  number_format(($amount_profit+ $carpet_profit+ $pest_profit+$other_profit) ,2); ?></td>		  
	   <?php  } else {?>		  
		   <td><?php  if($removal_amt !='') { echo  number_format($removal_amt ,2); } ?></td>		  
		  <td><?php  if($removal_profit !='') { echo  number_format($removal_profit ,2); } ?></td>		  
	   <?php  }   } ?>  
		</tr>
<?php } ?>		
	  <tr class="table_cells">
		  <td></td>
		  <td><?php  echo  $totals['total_quotes'];?></td>
		  <td><?php  echo $totals['q_phone']; ?></td>
		  <!--<td><?php  echo $totals['q_email']; ?>--></td>
		  <td><?php  echo $totals['q_site']; ?></td>
		  <!--<td><?php  echo $totals['q_chat']; ?></td>
		  <td><?php  echo $totals['q_others']; ?></td>-->
		  <td><?php  echo $totals['jobs_booked']; ?></td>
		  <td><?php  echo $totals['total_jobs']; ?></td>
		  <td><?php  echo $totals['jobs_cancelled']; ?></td>
		  <td><?php  echo $totals['jobs_done']; ?></td>
		  <td><?php  echo $totals['hours_done']; ?></td>
		<?php  if (in_array($_SESSION['admin'], $checkadmin)) { ?>
		  <td><?php  echo number_format($totals['sales'] ,2); ?></td>		
      <?php  if($_SESSION['daily_report']['job_type'] == 1) { ?>				  
		  <td><?php  echo number_format($totals['cleaning_amt'] , 2); ?></td>
		  <td><?php  echo number_format($totals['amount_profit'] ,2); ?></td>
		  <td><?php  echo number_format($totals['carpet_amt'] ,2); ?></td>
		  <td><?php  echo number_format($totals['carpet_profit'] ,2); ?></td>
		  <td><?php  echo number_format($totals['pest_amt'] ,2); ?></td>
		  <td><?php  echo number_format($totals['pest_profit'] ,2); ?></td>	
		  <td><?php  echo number_format($totals['other_amt'] ,2); ?></td>
		  <td><?php  echo number_format($totals['other_profit'] ,2); ?></td>		 
		  <td><?php  echo number_format($totals['profit'] ,2); ?></td>
	    <?php  }else { ?>		  
		  <td><?php  echo number_format($totals['removal_amt'] ,2); ?></td>		  
		  <td><?php  echo number_format($totals['removal_profit'] ,2); ?></td>		  
	   <?php  }   } ?>
		</tr>
    </table>