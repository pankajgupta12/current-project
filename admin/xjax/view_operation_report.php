<?php 

if(!isset($_SESSION['dashboard_report']['from_date'])){ $_SESSION['dashboard_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['dashboard_report']['to_date'])){ $_SESSION['dashboard_report']['to_date'] = date("Y-m-t"); }


	if($_SESSION['dashboard_report']['from_date'] != '' && $_SESSION['dashboard_report']['to_date']) {
			$fromdate = date('Y-m-d' , strtotime($_SESSION['dashboard_report']['from_date']));
			$to_date = $_SESSION['dashboard_report']['to_date'];

	}
	
	/* $bool = mysql_query("SELECT *  FROM `system_dd` WHERE `type` = 91");
	  $count_denied = mysql_num_rows($bool);
	 $a_denied = '';
	 $a_denied_val = '';
	 $total_a_denied_val = '';
		
		while($getdata = mysql_fetch_assoc($bool)) {
			 $a_denied .= '<td>'. $getdata['name'].'</td>';
			 $getadeniedInfo[] = $getdata['id'];
		} */
	
	//echo $fromdate.$to_date;

echo '<span class="staff_text" style="margin-bottom:25px;">Quotes & Operations</span><br/>';
echo '<table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">';
	
    $sql = "SELECT * FROM `sites` WHERE 1 = 1";	
	
		$getSql= mysql_query($sql);
		
	/* 	echo '<tr class="table_cells">
			  <td><strong>Site</strong></td>
			  <td colspan="10"><strong>From Quotes</strong></td>
			  <td colspan="'.$count_denied.'"><strong>A-Denied</strong></td>
			  <td colspan="15"><strong>Operations</strong></td>
			</tr>'; */
			
		echo '<tr class="table_cells">
			  <td><strong>Site</strong></td>
			  <td colspan="10"><strong>From Quotes</strong></td>
			  <td colspan="15"><strong>Operations</strong></td>
			</tr>';	
			
	 ?>
	<tr class="table_cells">
		  <td>Site</td>
		  <td>Total Quotes</td>
		  <td>Quotes By Phone</td>
		  <td>Quotes By Site</td>
		  <td>Jobs Booked</td>
		  <td>Total Jobs</td>
		  <td>Jobs booked By Sites</td>
		  <td>Jobs booked By Phone</td>
		  <td>C - Denied</td>
		  <td>Others</td>
		  <td>A - Denied</td>
		  
		  <?php
          $sql = mysql_query("SELECT *  FROM `system_dd` WHERE `type` = 26");
		  while($statusdata = mysql_fetch_assoc($sql)) {
		  ?>
		       <td><?php echo $statusdata['name'] ?></td>
		  <?php  } ?>
		  
	</tr>

		<?php  	
		
			 $totalQ = 0;
			 $totalB = 0;
			 $totalS = 0;
			 $totalP = 0;
		 
		while($r = mysql_fetch_assoc($getSql)){
			
		
			
			$getdata = getTotalQuoteInfo($fromdate ,$to_date , $r['id']);
			$jobDetails = getTotalJobsDetails($fromdate ,$to_date , $r['id']);
			
			$getInfo_html = '';
			
			
			/* $totala_deniedval = 0;
			foreach($getadeniedInfo as $key=>$val) {
			  $getInfo = getTotalQuoteInfoADenied($fromdate ,$to_date , $r['id'] ,$val);
			  $getInfo_html .= '<td>'.$getInfo.'</td>';
			  $totalSum[$val][] = $getInfo;
			} */
			
			//$totalQuote = $getdata['totalquote'];
			$booked = $getdata['booked'];
			$totalQuote = $getdata['totalquote'];
			$totalsite = $getdata['site'];
			$phone = $getdata['phone'];
			$totalc_denied = $getdata['totalc_denied'];
			$totala_denied = $getdata['totala_denied'];
			$totala_other = $getdata['totala_other'];
			
			$totalQ += $totalQuote;
			$totalB += $booked;
			$totalS += $totalsite;
			$totalP += $phone;
			$totalc_deni += $totalc_denied;
			$totala_deni += $totala_denied;
			$totalaoth_other += $totala_other;
			
			
			$total_jobs = $jobDetails['total_jobs'];
			$jobs_site = $jobDetails['jobs_site'];
			$jobs_phone = $jobDetails['jobs_phone'];
			$jobs_cancelled = $jobDetails['jobs_cancelled'];
			
			
			$totalJQ += $total_jobs;
			$totalJS += $jobs_site;
			$totalJP += $jobs_phone;
			$totalJC += $jobs_cancelled;
			
			?>
			<tr class="table_cells">
				  <td><?php echo $r['name']; ?></td>
				  <td><?php echo $totalQuote; ?></td>
				  <td><?php echo $phone; ?></td>
				  <td><?php echo $totalsite; ?></td>
				  <td><?php echo $booked; ?></td>
				  <td><?php echo $total_jobs; ?></td>
				  <td><?php echo $jobs_site; ?></td>
				  <td><?php echo $jobs_phone; ?></td>
				  <td><?php echo $totalc_denied; ?></td>
				  <td><?php echo $totala_other; ?></td>
				  <td><?php echo $totala_denied; ?></td>
				  <?php // echo $getInfo_html; ?>
				 
				   <?php
				  $sql = mysql_query("SELECT *  FROM `system_dd` WHERE `type` = 26");
				  while($statusdata = mysql_fetch_assoc($sql)) {
					$jobstatusReport  = getjobStatusData($fromdate ,$to_date , $statusdata['id'] ,$r['id']);
					
					$getTotalopretion[$statusdata['id']] += $jobstatusReport;
			  ?>
				 <td><?php echo $jobstatusReport; ?></td>
		  <?php  } ?>
			</tr>
		<?php 

     
		}  
		?>	
		    <tr class="table_cells">
				  <td><strong>Total</td>
				  <td><strong><?php echo $totalQ; ?></strong></td>
				  <td><strong><?php echo $totalP; ?></strong></td>
				  <td><strong><?php echo $totalS; ?></strong></td>
				  <td><strong><?php echo $totalB; ?></strong></td>
				  <td><strong><?php echo $totalJQ; ?></strong></td>
				  <td><strong><?php echo $totalJS; ?></strong></td>
				  <td><strong><?php echo $totalJP; ?></strong></td>
				  <td><strong><?php echo $totalc_deni; ?></strong></td>
				  <td><strong><?php echo $totalaoth_other; ?></strong></td>
				  <td><strong><?php echo $totala_deni; ?></strong></td>
				  <?php /* foreach($totalSum as $key1=>$totaldenied){ ?>
				  <td><strong><?php echo array_sum($totaldenied); ?></strong></td>
				  <?php  }  */?>
				  <?php  foreach($getTotalopretion as $key=>$value) { ?>
				  <td><strong><?php echo $value; ?></strong></td>
				  <?php  } ?>
			</tr>
    </table>