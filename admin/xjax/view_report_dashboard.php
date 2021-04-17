<?php 

if(!isset($_SESSION['dashboard_report']['from_date'])){ $_SESSION['dashboard_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['dashboard_report']['to_date'])){ $_SESSION['dashboard_report']['to_date'] = date("Y-m-t"); }


	if($_SESSION['dashboard_report']['from_date'] != '' && $_SESSION['dashboard_report']['to_date']) {
			$fromdate = date('Y-m-d' , strtotime($_SESSION['dashboard_report']['from_date']));
			$to_date = $_SESSION['dashboard_report']['to_date'];

	}
	
	$bool = mysql_query("SELECT *  FROM `system_dd` WHERE `type` in(91,93,94)");
	  $count_denied = mysql_num_rows($bool);
	
		 $a_denied = '';
		 $c_denied = '';
		 $a_others = '';
		$a_denied_type = 0;
		$c_denied_type = 0;
		$others_type = 0;
		while($getdata = mysql_fetch_assoc($bool)) {
			   
			     if($getdata['type'] == 91) {
					 $a_denied_type++;
					  $a_denied .= '<td>'. $getdata['name'].'</td>';
					   $getadeniedInfo[] = $getdata['id'];
				 }
				 if($getdata['type'] == 93) {
					 $c_denied_type++;
					  $c_denied .= '<td>'. $getdata['name'].'</td>';
					   $getcdeniedInfo[] = $getdata['id'];
				 }
				 if($getdata['type'] == 94) {
					 $others_type++;
					  $a_others .= '<td>'. $getdata['name'].'</td>';
					   $getothersdeniedInfo[] = $getdata['id'];
				 }
			   
				
				
		}
	
	//echo $fromdate.$to_date;

echo '<span class="staff_text" style="margin-bottom:25px;">Quotes & Operations</span><br/>';
echo '<table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">';
	
    $sql = "SELECT * FROM `sites` WHERE 1 = 1";	
	
		$getSql= mysql_query($sql);
		
		echo '<tr class="table_cells">
			  <td><strong>Site</strong></td>
			  <td colspan="10"><strong>From Quotes</strong></td>
			  <td colspan="'.$a_denied_type.'"><strong>A-Denied</strong></td>
			  <td colspan="'.$c_denied_type.'"><strong>C-Denied</strong></td>
			  <td colspan="'.$others_type.'"><strong>Others</strong></td>
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
          <td>A - Denied</td>		 
		 <td>C - Denied</td>
		  <td>Others</td>
		 <?php echo $a_denied; ?>
		 <?php echo $c_denied; ?>
		 <?php echo $a_others; ?>
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
			$getInfo_html_c = '';
			$getInfo_html_oth = '';
			
			//print_r($getadeniedInfo);
			
			foreach($getadeniedInfo as $key=>$val) {
			  $getInfo = getTotalQuoteInfoADenied($fromdate ,$to_date , $r['id'] ,$val , 6);
			  $getInfo_html .= '<td>'.$getInfo.'</td>';
			  $totalSum[$val][] = $getInfo;
			}
			
			foreach($getcdeniedInfo as $key=>$val_c) {
			  $getInfo_c = getTotalQuoteInfoADenied($fromdate ,$to_date , $r['id'] ,$val_c , 5);
			  $getInfo_html_c .= '<td>'.$getInfo_c.'</td>';
			  $totalSum_c[$val_c][] = $getInfo_c;
			}
			
			foreach($getothersdeniedInfo as $key=>$val_oth) {
			  $getInfo_oth = getTotalQuoteInfoADenied($fromdate ,$to_date , $r['id'] ,$val_oth , 7);
			  $getInfo_html_oth .= '<td>'.$getInfo_oth.'</td>';
			  $totalSum_oth[$val_oth][] = $getInfo_oth;
			}
			
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
				  <!--<td><?php echo $totala_denied; ?></td>-->
				   <td><?php echo $totala_denied; ?></td>
				   <td><?php echo $totalc_denied; ?></td>
				  <td><?php echo $totala_other; ?></td>
				 
				  <?php  echo $getInfo_html; ?>
				  <?php  echo $getInfo_html_c; ?>
				  <?php  echo $getInfo_html_oth; ?>
				 
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
				  <td><strong><?php echo $totala_deni; ?></strong></td>
				   <td><strong><?php echo $totalc_deni; ?></strong></td>
				  <td><strong><?php echo $totalaoth_other; ?></strong></td>
				  
				  <?php foreach($totalSum as $key1=>$totaldenied){ ?>
				  <td><strong><?php echo array_sum($totaldenied); ?></strong></td>
				  <?php  } ?>
				   <?php foreach($totalSum_c as $key1_c=>$totaldenied_c){ ?>
				  <td><strong><?php echo array_sum($totaldenied_c); ?></strong></td>
				  <?php  } ?>
				   <?php foreach($totalSum_oth as $key1_oth=>$totaldenied_oth){ ?>
				  <td><strong><?php echo array_sum($totaldenied_oth); ?></strong></td>
				  <?php  } ?>
			</tr>
    </table>