<?php 
session_start();
include("../../source/functions/functions.php");
include("../../source/functions/config.php");

if(isset($_POST['page'])) 
{
    $today = date('Y-m-d');
    
	$pageid = $_POST['page'];
	
 	 $job_arg = "select job_details.job_date as jobDate,job_details.job_acc_deny as WorkStatus, jobs.id as jobid, jobs.quote_id as quoteid,jobs.site_id as siteid from jobs , job_details where jobs.id = job_details.job_id and job_details.status!=2 "; 
  
     if($_SESSION['status_action']=="")
	{
		
	  $job_arg .= ' AND jobs.status=1  AND job_details.staff_id= 0 ';
	 //  $job_arg .= ' AND job_details.job_date  >="'.$today.'"';
	
		
	}elseif($_SESSION['status_action']=="1")
	{
		
	//$job_arg .= ' AND job_details.staff_id != 0 AND jobs.status=1  AND   job_details.job_acc_deny = 0 AND job_details.job_type_id = 1';
	$job_arg .= ' AND job_details.staff_id != 0 AND jobs.status=1  AND   job_details.job_acc_deny = 0 ';
	//  $job_arg .= ' AND job_details.job_date  >="'.$today.'"';
		
	}elseif($_SESSION['status_action']=="2")
	{
		
		$job_arg .= ' AND job_details.staff_id != 0 AND job_details.staff_id != 0  AND jobs.status=1  AND   job_details.job_acc_deny = 1';	
		 
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
	
	if(count($_SESSION['view_unassigned']) > 0 )
		{
			foreach($_SESSION['view_unassigned'] as $key=>$value){
				if($value != '') {
					if($key == 'site_id' || $key == 'job_date') {
						  $job_arg.= " AND   job_details.".$key."  = '".$value."'";
						 
						} elseif($key != 'job_type_id'){
						  $job_arg.= " AND   job_details.".$key."  Like '%".$value."%'";
						 
						} 
					
				}
			}
		}

		        if($_SESSION['view_unassigned']['job_type_id'] == 1 && $_SESSION['status_action']== "1") {
		 			 
					$job_arg.=  " AND job_details.job_type_id = 1";
					
				}elseif($_SESSION['view_unassigned']['job_type_id'] == 2 && $_SESSION['status_action']== "1") {
					
					$job_arg.= " AND job_details.job_type_id = 11";
					$job_type_data = 11;
				}elseif($_SESSION['view_unassigned']['job_type_id'] == 3 && ($_SESSION['status_action']== "" || $_SESSION['status_action']== 1)) {
					
					$job_arg.= " AND  job_details.quote_id in ( SELECT id FROM `quote_new` WHERE real_estate_id != 0 And booking_id != 0 )";
					
					$job_type_data = 1; 
					
				}

  
	$resultsPerPage = resultsPerPage;
	 $job_arg .= " group by job_details.job_id  ORDER BY job_details.job_date , job_details.job_id asc";
   // $resultsPerPage = 2;
	if($pageid>0)
	{
		$page_limit=$resultsPerPage*($pageid - 1);
		$job_arg.=" LIMIT  $page_limit , $resultsPerPage";
	}
	else
	{
		$job_arg.=" LIMIT 0 , $resultsPerPage";
	}
  // echo $job_arg;  die;

	$jobs_data = mysql_query($job_arg);

	   if (mysql_num_rows($jobs_data)>0){ 
	     $counter = 0;
	    while($jobs = mysql_fetch_assoc($jobs_data)){  
	           $counter++;
				     $bgcolor = ($counter % 2 === 0) ? 'alert_even_tr' : 'alert_odd_tr';
	        
	        $quote = mysql_fetch_array(mysql_query("select * from quote_new where id=".$jobs['quoteid'].""));
			$site_name = get_rs_value("sites","name",$jobs['siteid']);
			
			$recleanData = mysql_fetch_array(mysql_query("SELECT job_id,reclean_date FROM `job_reclean` where status != 2 AND job_id = ".$jobs['jobid']." GROUP by job_id ORDER by reclean_date asc"));
			
			$nextjobdate = date('Y-m-d', strtotime($jobs['jobDate'].'-48 hour')); 
			
	    ?>
          <tr  class="parent_tr <?php if(callPaytype($jobs['jobid']) == 'No Payment Found!' || ($nextjobdate <= date('Y-m-d'))) {echo "alert_danger_tr";}else{ echo $bgcolor;} ?> <?php// echo $bgcolor; ?>">
            <?php if($_SESSION['status_action']!= 5){ ?>		  
			   <td class="bc_click_btn"><a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $jobs['jobid']; ?>','1200','850')"><?php // echo $nextjobdate.'<='. date('Y-m-d'); ?> <?php echo $jobs['jobid']; ?></a></td>
			   
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
			
			<?php  if($_SESSION['status_action']== 5){   ?>
			
			 <td class="bc_click_btn tdLastChild"><?php echo getRecleandetails($jobs['jobid']); ?></td>
			 
			<?php }else {  if($_SESSION['status_action']=="" ||  $_SESSION['status_action']==6){  ?>
			
			    <td class="bc_click_btn tdLastChild"><?php echo getJobType($quote['id']); ?></td>
				
			 <?php  } else {?>
			 
			    <td class="bc_click_btn tdLastChild"><?php echo getJobTypewaiting($quote['id'],$job_type_data); ?></td>
				
			<?php  } } ?>
             <?php  if($_SESSION['status_action']== '' ||  $_SESSION['status_action']==6){   ?>
			  <td class="bc_click_btn"><?php echo check_staff($quote['id']); ?></td>
			 <?php  } ?>
			 
			  </tr>	
		<?php }?>
	<tr>
		<td colspan="10" class="load_more"><button class="loadmore" data-page="<?php echo  $pageid+1 ;?>">Load More</button></td>
	</tr>
			  
	<?php 
	} 
	else
	{
	?> 
	<tr>
		<td colspan="10" >No Report Found</td>
	</tr>
	<?php
	}
}
?>