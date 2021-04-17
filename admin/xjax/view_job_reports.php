<?php 

if(!isset($_SESSION['job_report']['from_date'])){ $_SESSION['job_report']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['job_report']['to_date'])){ $_SESSION['job_report']['to_date'] = date("Y-m-t"); }
//if(!isset($_SESSION['job_report']['better_franchisee'])){ $_SESSION['job_report']['better_franchisee'] = 1; }

    
   //0=>Re-assign 1=> Accept 2=> Deny 3=> Re-Clean 4=> Complete
	   $sqlStaff = "select name,id,no_work from staff where status = 1";
	   //print_r($_SESSION['job_report']);
	   
	    if(isset($_SESSION['job_report']['site_id'])){
	      $sqlStaff.= " AND site_id = ".$_SESSION['job_report']['site_id'];
		  $site_id = $_SESSION['job_report']['site_id'];
		}else{
		  $site_id = 0;
		}
		
		if(isset($_SESSION['job_report']['staff_id']) && $_SESSION['job_report']['staff_id'] != 'undefined'){
	      $sqlStaff.= " AND id = ".$_SESSION['job_report']['staff_id'];
		  $staff_id = $_SESSION['job_report']['staff_id'];
		}else{
		  $staff_id = 0;
		}
		
		//print_r($_SESSION['job_report']);
		
		if(isset($_SESSION['job_report']['better_franchisee'])){
	      $sqlStaff.= " AND better_franchisee = ".$_SESSION['job_report']['better_franchisee'];
		}
     // echo $sqlStaff;
 // print_r($_SESSION['job_report']);
$staffSql = mysql_query($sqlStaff);

//$getStaffno_work = array();
 while($getStatff = mysql_fetch_assoc($staffSql)) {
	 //print_r($getStatff);
	  $getStaffName[] = $getStatff['name'];
	  $getStaffID[] = $getStatff['id']; 
	  $getStaffno_work[] = $getStatff['no_work'];
	 // unset($getStaffno_work);
 }
 
 //print_r($getStaffName);
 //print_r($_SESSION['job_report']);
 if(isset($_SESSION['job_report']['from_date']) && $_SESSION['job_report']['to_date'] != NULL )
	{ 
        /* $from_date = date('Y-m-d 23:59:00',strtotime($_SESSION['job_report']['from_date']));
        $to_date = date('Y-m-d 00:00:00',strtotime($_SESSION['job_report']['to_date'])); */
		
		$from_date = date('Y-m-d',strtotime($_SESSION['job_report']['from_date']));
        $to_date = date('Y-m-d',strtotime($_SESSION['job_report']['to_date']));
		
		
		$fromdate = date('Y-m-d',strtotime($_SESSION['job_report']['from_date']));
        $todate = date('Y-m-d',strtotime($_SESSION['job_report']['to_date']));
		
		// $getJobDetails .= " AND job_date >= '".date('Y-m-d',strtotime($from_date))."' AND job_date <= '".date('Y-m-d',strtotime($to_date))."'";
	}
	
	
	echo '<span class="staff_text" style="margin-bottom:25px;margin-left: 20px;"> Job Report </span><br/>';
	echo '<h4 style="margin-left: 615px;margin-top: -50px;font-size: 16px;color: #5abece;">Quote date : '.date("dS M",strtotime($_SESSION['job_report']['from_date'])).' ('.date("D",strtotime($_SESSION['job_report']['from_date'])).')  to  '.date("dS M",strtotime($_SESSION['job_report']['to_date'])).' ('.date("D",strtotime($_SESSION['job_report']['to_date'])).')</h4>';
    
	
	//print_r (getJobStatus());
	$JobStatusName = JobStatusName();
	//echo $getJobDetails;
    echo '<table width="100%" border="0" cellpadding="5" cellspacing="5" class="user-payment-table">';
  	
	
	
	 ?>
	 <tr class="table_cells">
		  <td colspan="2"><strong>Staff ID & Name</strong></td>
		  <td colspan="10"><strong>Staff App</strong></td>
		  <td colspan="8"><strong>Job Status</strong></td>
	</tr>
	<tr class="table_cells">
	
		  <td><strong>Staff ID</strong></td>
		  <td><strong>Staff</strong></td>
		  <td><strong>Offered</strong></td>
		  <td><strong>Accepted</strong></td>
		  <td><strong>Denied</strong></td>
		  <td><strong>Denied In PostCode</strong></td>
		  <td><strong>Re-Assigned</strong></td>
		  <td><strong>Job Finish <br/> (Staff)</strong></td>
		  <td><strong>Job Complete <br/>(Admin)</strong></td>
		  <td><strong>Re-Clean <br/> Offered</strong></td>
		  <td><strong>Re-Clean <br/> Finish (staff)</strong></td>
		  <td><strong>Re-Clean <br/> Complete (Admin)</strong></td>
		  
		   <?php   foreach($JobStatusName as $jobStatusid=>$jobStatusvalue) { ?>
		   <td><strong><?php echo $jobStatusvalue; ?></strong></td>
		  <?php  } ?>
		
	</tr>
	
		<?php 
     $i = 0;
		 foreach($getStaffName as $key=>$value) {
            $i++;
		
		$totalofferedRecleanjob = totalofferedjob($getStaffID[$key],$from_date,$to_date,2); 
		$AllTotaltotalofferedRecleanjob += totalofferedjob($getStaffID[$key],$from_date,$to_date,2,$site_id); 
		
		
		/* $totalofferedjob_old = totalofferedjob($getStaffID[$key],$from_date,$to_date,1); 
		$AllTotaltotalofferedjob_old += totalofferedjob($getStaffID[$key],$from_date,$to_date,1,$site_id);  */
		
		 $totalacceptedofferjob  =  TotalJobOffer($getStaffID[$key],$from_date,$to_date,1);
        $alltotalacceptedofferjob  +=  TotalJobOffer($getStaffID[$key],$from_date,$to_date,1); 
		
		// Total Offer job
        $totalofferjob  =  TotalJobOffer($getStaffID[$key],$from_date,$to_date,5);
        $alltotalofferjob  +=  TotalJobOffer($getStaffID[$key],$from_date,$to_date,5);
		
		
		$totaldeniedjob  =  TotalJobOffer($getStaffID[$key],$from_date,$to_date,2);
		
		//print_r($totaldeniedjob);
		
        $alltotaldeniedjob  +=  TotalJobOffer($getStaffID[$key],$from_date,$to_date,2);
		
		$totalreAssignjob  =  TotalJobOffer($getStaffID[$key],$from_date,$to_date,0);
        $alltotalreAssignjob  +=  TotalJobOffer($getStaffID[$key],$from_date,$to_date,0);
		
		$totalfinishjob  =  TotalJobOffer($getStaffID[$key],$from_date,$to_date,4);
        $alltotalfinishjob  +=  TotalJobOffer($getStaffID[$key],$from_date,$to_date,4);
		
		
		$TotalcompeteByadmin    = TotalCompleteJob($getStaffID[$key],$fromdate,$todate); 
		$AllTotalcompeteByadmin   += TotalCompleteJob($getStaffID[$key],$fromdate,$todate); 
		
		$totalofferedRecleanfinish = totalofferedjob($getStaffID[$key],$from_date,$to_date,4); 
		$alltotalofferedRecleanfinish += totalofferedjob($getStaffID[$key],$from_date,$to_date,4); 

        
		$totalofferedRecleanComplete = totalofferedjob($getStaffID[$key],$from_date,$to_date,3); 
		$AllTotaltotalofferedRecleanComplete += totalofferedjob($getStaffID[$key],$from_date,$to_date,3); 
		
		$getRsult  =  getdeniedJob($getStaffID[$key],$from_date,$to_date,2);
		$totalgetRsult  +=  getdeniedJob($getStaffID[$key],$from_date,$to_date,2);
		?>
		
			<tr class="table_cells <?php  if($getStaffno_work[$key] == 2) { echo 'alert_danger_tr ';}  ?>" >
				   <td><?php  echo $getStaffID[$key];?></td>
				   <td style="text-align: justify;padding: 4px 5px;width:15%"><a style="cursor: pointer;color: blue;" onclick="javascript:scrollWindow('staff_details.php?task=4&action=modify&id=<?php  echo $getStaffID[$key];?>','1200','850')"><?php  echo $value;?></a></td>
				   <td><?php if($totalofferjob > 0)  { echo $totalofferjob; }else {echo "-"; } ?></td>
				   <td><?php if($totalacceptedofferjob > 0) { echo  $totalacceptedofferjob; }else { echo "-"; }?></td>
				   <td><?php if($totaldeniedjob > 0) { echo  $totaldeniedjob; }else { echo "-"; }?></td>
				   <td><?php if($getRsult > 0) { echo  $getRsult; }else { echo "-"; }?></td>
				   <td><?php if($totalreAssignjob > 0) { echo  $totalreAssignjob; }else { echo "-"; }?></td>
				   <td><?php if($totalfinishjob > 0) { echo  $totalfinishjob; }else { echo "-"; }?></td>
				   <td><?php  if($TotalcompeteByadmin > 0) { echo  $TotalcompeteByadmin; }else { echo "-"; }?></td>
				   <td><?php  if($totalofferedRecleanjob > 0) { echo  $totalofferedRecleanjob; }else{ echo "-";  } ?></td>
				   <td><?php  if($totalofferedRecleanfinish > 0) { echo  $totalofferedRecleanfinish; }else{ echo "-";  } ?></td>
				   <td><?php  if($totalofferedRecleanComplete > 0) { echo  $totalofferedRecleanComplete; }else{ echo "-";  } ?></td>
				   
				   <?php   foreach($JobStatusName as $jobStatusid=>$jobStatusvalue) { 
					 $sumTotalStatus[$jobStatusid]  += getJobStatus($getStaffID[$key],$fromdate,$todate ,$jobStatusid)
				   ?>
				   <td><?php if(getJobStatus($getStaffID[$key],$fromdate,$todate ,$jobStatusid) > 0) { echo getJobStatus($getStaffID[$key],$fromdate,$todate ,$jobStatusid); }else { echo "-"; }?></td>
				  <?php  } ?>
			</tr>
		<?php  }  ?>
		
		<tr class="table_cells">
			<td colspan="2"><strong>Total Staff Active in BCIC  (  <?php echo $i; ?>)</strong></td>
			<td><strong><?php echo $alltotalofferjob; //echo $alltotalofferjob;  ?></strong></td>
			<td><strong><?php echo  $alltotalacceptedofferjob; //$AllTotaltotalAccepted; ?></strong></td>
			<td><strong><?php echo $alltotaldeniedjob; ?></strong></td>
			<td><strong><?php echo $totalgetRsult; ?></strong></td>
			<td><strong><?php echo $alltotalreAssignjob; ?></strong></td>
				
			<td><strong><?php echo $alltotalfinishjob; ?></strong></td>
		   <td><strong><?php  echo $AllTotalcompeteByadmin; ?></strong></td>
			<td><strong><?php echo $AllTotaltotalofferedRecleanjob; ?></strong></td>
			<td><strong><?php echo $alltotalofferedRecleanfinish; ?></strong></td>
			<td><strong><?php echo $AllTotaltotalofferedRecleanComplete; ?></strong></td>
			<?php   foreach($JobStatusName as $jobStatusid=>$jobStatusvalue) { ?>
					 <td><strong><?php echo $sumTotalStatus[$jobStatusid]; ?></strong></td>
			<?php  } ?>
			<tr>
				 <td colspan="11"><strong> </strong></td>
				 <td colspan="10"><strong>Total job <?php echo array_sum($sumTotalStatus); ?></strong></td>
			</tr>  
	    </tr>
    
    </table>