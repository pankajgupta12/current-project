<?php  
 $resultsPerPage = resultsPerPage;

 
  $today = date('Y-m-d');
  $job_arg = "select job_details.job_date as jobDate, job_details.staff_id as staffid, job_details.job_acc_deny as WorkStatus, jobs.id as jobid, jobs.quote_id as quoteid,jobs.site_id as siteid from jobs , job_details, quote_new  where jobs.id = job_details.job_id  AND job_details.job_id = quote_new.booking_id  and job_details.status!=2  AND job_details.job_id != 0";
    if($_SESSION['status_action']=="")
	{
		 
		 $job_arg .= ' AND jobs.status=1  AND job_details.staff_id= 0 AND job_type_id != 11 ';
		 
	}elseif($_SESSION['status_action']=="1")
	{
		
	  $job_arg .= ' AND job_details.staff_id != 0 AND jobs.status=1  AND   job_details.job_acc_deny = 0 ';
	  
	}elseif($_SESSION['status_action']=="2")
	{
		$job_arg .= ' AND job_details.staff_id != 0  AND jobs.status=1  AND   job_details.job_acc_deny = 1 AND job_details.job_type_id = 1';	

		$job_arg .= ' AND job_details.job_date  >="'.$today.'"';
		 
	}elseif($_SESSION['status_action']=="3")
	{
		 $job_arg .= ' AND job_details.staff_id != 0   AND jobs.status=1  AND    job_details.job_acc_deny = 2';	
		
	}
	elseif($_SESSION['status_action']=="4")
	{
		 $job_arg .= ' AND job_details.staff_id != 0  AND jobs.status=1  AND job_details.job_acc_deny = 4';	
		
		
	}elseif($_SESSION['status_action']=="5")
	{
		 $job_arg .= ' AND job_details.staff_id != 0  AND jobs.status=5  AND job_details.reclean_job = 2';	
		
		
	}elseif($_SESSION['status_action']== "6")
	{
		 
		 $job_arg .= ' AND jobs.status=1  AND  job_details.staff_truck_id = 0 AND job_type_id = 11 ';
	}
	
	//print_r($_SESSION['view_unassigned']);
	
	    if($_SESSION['view_unassigned']['job_date'] != '' && $_SESSION['view_unassigned']['from_to'] != '') 
		{
			$job_arg.= " AND job_details.job_date >= '".$_SESSION['view_unassigned']['job_date']."' AND  job_details.job_date  <= '".$_SESSION['view_unassigned']['from_to']."' ";
		}
	
	   if(count($_SESSION['view_unassigned']) > 0 )
		{
			foreach($_SESSION['view_unassigned'] as $key=>$value){
				if($value != '') {
						if($key == 'site_id') {
						    $job_arg.= " AND   job_details.".$key."  = '".$value."'";
							
						}elseif($key == 'job_id') {
							
						   $job_arg.= " AND   job_details.".$key."  Like '%".$value."%'";
						} 
				}
			}
		}
		
		//echo  $_SESSION['view_unassigned']['job_type_id'];
		
		        if($_SESSION['view_unassigned']['job_type_id'] == 1 && $_SESSION['status_action']== "1") {
					 
					$job_arg.=  " AND job_details.job_type_id = 1";
					
				}elseif($_SESSION['view_unassigned']['job_type_id'] == 2 && $_SESSION['status_action']== "1") {
					
					$job_arg.= " AND job_details.job_type_id = 11";
					$job_type_data = 11;
				}elseif($_SESSION['view_unassigned']['job_type_id'] == 3 && ($_SESSION['status_action']== "" || $_SESSION['status_action']== 1)) {
					
					$job_arg.= " AND  job_details.quote_id in ( SELECT id FROM `quote_new` WHERE real_estate_id != 0 And booking_id != 0 )";
					
					$job_type_data = 1; 
					
				}

  
 $job_arg .= " group by job_details.job_id  ORDER BY job_details.job_date  asc ";
 $countsql = $job_arg;
 // echo $countsql;
 $job_arg .= " limit 0,$resultsPerPage ";
 
 //echo "<br/><br/><br/>".$job_arg;
 
$jobs_data = mysql_query($job_arg);

 $countResult  = mysql_num_rows(mysql_query($countsql));
 
 
?>
<script>
$(document).on('click','.loadmore',function () 
{
  $(this).text('Loading...');
	$.ajax({
		url: 'xjax/ajax/loadmore_job_unassinged.php',
		type: 'POST',
		datatype: 'html',
		data:{page:$(this).data('page'),},
		success: function(response)
		{
			if(response)
			{
			   // alert(response);
			    
			  $('.load_more').remove();
			  $( "tr.parent_tr:last" ).after( response );
			}
		}
   }); 
});
</script>

	<div class="right_text_boxData right_text_box">
		  <div class="midle_staff_box"><span class="midle_text">Total Records <?php echo  $countResult; ?></span></div>
	</div>

<div class="usertable-overflow">
	<table class="user-table" id="get_panel">
	    <thead>
    	  <tr> 
    		<th>Job ID</th>
    		<th>Quote ID</th>
    		<th>Quote For</th>
            <th>Site</th>
			<th>PostCode</th>
            <th>Name</th>
            <th>Job Date</th>
           	<th>Phone</th>
    		<th>Address</th>
    	    <th>Job Amount</th>
    	    <th>Amount Received</th>
    	    <?php // if($_SESSION['status_action']== 1){   ?>	
    	      <th>Job Assinged</th>
    	    <?php // } ?>
    	    <th>Job For</th>
			<?php  if($_SESSION['status_action']== '' || $_SESSION['status_action']== 6){   ?>
    	    <th>Staff Type</th>
			<?php  } ?>
    	    
    		<!--<th>Site/Suburb</th>-->
    	
    	  </tr>
	    </thead>
	  <tbody id="get_loadmoredata">
	    <?php 
	   if (mysql_num_rows($jobs_data)>0){ 
	     $counter = 0;
	    while($jobs = mysql_fetch_assoc($jobs_data)){  
	           $counter++;
				     $bgcolor = ($counter % 2 === 0) ? 'alert_even_tr' : 'alert_odd_tr';
	        
	        $quote = mysql_fetch_array(mysql_query("select * from quote_new where id=".$jobs['quoteid']." ORDER By booking_date Desc"));
			$site_name = get_rs_value("sites","name",$jobs['siteid']);
			
				
			$recleanData = mysql_fetch_array(mysql_query("SELECT job_id,reclean_date FROM `job_reclean` where status != 2 AND job_id = ".$jobs['jobid']." GROUP by job_id ORDER by reclean_date asc"));
			
			/*  $assigndate = $getdata['staff_assign_date'];	
            $job_date = $getdata['job_date'];	 */
			//return array('job_date'=>$job_date ,'assigndate'=>$assigndate);
			/*  $checkAcceted = checkJobAccepted($jobs['jobid']); */
			 
			 $nextjobdate = date('Y-m-d', strtotime($jobs['jobDate'].'-48 hour')); 
			//echo  '============='.$jobs['staffid'];
	    ?>
          <tr  class="parent_tr <?php if(callPaytype($jobs['jobid']) == 'No Payment Found!' || ($nextjobdate <= date('Y-m-d') &&  $jobs['staffid'] != 0)) {echo "alert_danger_tr";}else{ echo $bgcolor;} ?> <?php// echo $bgcolor; ?>">
            <?php if($_SESSION['status_action']!= 5){ ?>		  
			   <td class="bc_click_btn"><a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $jobs['jobid']; ?>','1200','850')"><?php // echo $nextjobdate.'<='. date('Y-m-d'); ?><?php echo $jobs['jobid']; ?></a></td>
			   
			<?php  }else { ?>
		 	  <td class="bc_click_btn"><a href="javascript:scrollWindow('popup.php?task=job_reclean&job_id=<?php echo $jobs['jobid']; ?>','1200','850')"><?php echo $jobs['jobid']; ?></a></td>
			<?php }?>
			
			<td class="bc_click_btn"><?php echo $quote['id']; ?></a></td>
			<td class="bc_click_btn"><?php echo get_rs_value("quote_for_option","name",$quote['quote_for']); ?></a></td>
			<td class="bc_click_btn"><?php echo $site_name; ?></td>
			<td class="bc_click_btn"><?php echo $quote['postcode']; ?></td>
			<td class="bc_click_btn"><?php echo $quote['name']; ?></td>
			<?php if($_SESSION['status_action']!= 5){ ?>
			<td class="bc_click_btn" title="<?php echo changeDateFormate(($jobs['jobDate']),'datetime'); ?>"><?php echo changeDateFormate(($jobs['jobDate']),'dm'); ?></td>
			<?php  }else { ?>
			<td class="bc_click_btn" title="<?php echo changeDateFormate(($recleanData['reclean_date']),'datetime'); ?>"><?php echo changeDateFormate(($recleanData['reclean_date']),'dm'); ?></td>
			<?php } ?>
			
			<td class="bc_click_btn"><?php echo $quote['phone']; ?></td>
			<td class="bc_click_btn"><?php echo $quote['address']; ?></td>
			<td class="bc_click_btn"><?php echo get_rs_value("jobs","customer_amount",$jobs['jobid']); ?><?php //echo $quote['amount']; ?></td>
			
			
			<?php // if($_SESSION['status_action']== 1){   ?>	
			<td class='bc_click_btn'><?php echo callPaytype($jobs['jobid']); ?></td>
			<?php //} ?>
			
			<?php  if($_SESSION['status_action']== 5) {   ?>
			
		     	 <td class="bc_click_btn tdLastChild"><?php echo getRecleandetails($jobs['jobid']); ?></td>
			 
			<?php } else {  if($_SESSION['status_action']=="" ||  $_SESSION['status_action']==6){  ?>
			
			    <td class="bc_click_btn tdLastChild"><?php echo getJobType($quote['id']); ?></td>
				
			 <?php  } else { ?>
			 
			    <td class="bc_click_btn tdLastChild"><?php echo getJobTypewaiting($quote['id'],$job_type_data); ?></td>
				
			<?php  } }  ?>
			
             <?php  if($_SESSION['status_action']== '' ||  $_SESSION['status_action']==6) {   ?>
			  <td class="bc_click_btn"><?php echo check_staff($quote['id']); ?></td>
			 <?php  } ?>
			 
			  </tr>	
		<?php  } ?> 
			<?php if($countResult >= $resultsPerPage) { ?>
			<tr class="load_more">
	         <td colspan="15"><button class="loadmore" data-page="2" >Load More</button></td>
			</tr>
			<?php } }else { ?>
          <tr>
	         <td colspan="15">No records</td>
			</tr>
			<?php  } ?>
		</tbody>	
	</table>
	
	<div id="quote_div3">
	
	</div>
</div>	

<style>
 table td.text12_cehck_staff{
	border: 1px solid;
	background: #b7d1ec;
	font-size: 12px;
	cursor: pointer;
	padding: 1px;
 }
</style>
