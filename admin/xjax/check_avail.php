 <?php 
//$booking_date1 = rotatedate($booking_date);
//echo $booking_date;
$start_date_ts = strtotime(date('Y-m-d' ,strtotime($booking_date. ' - 1 days')));
$end_date_ts = $start_date_ts+(86400*3);
$start_date_ts_h = $start_date_ts;

$quote_for = $quote_for;
$get_quote_id = $get_quote_id;

//echo $get_quote_id;
//echo $getjob_type_id;

  //print_r($_GET);
/* echo $suburb;
echo $site_id; */
if($getjob_type_id != '11'  || $getjob_type_id == '') {
	 
	$jobtype = 'Cleaning';

    $getPostCode =  mysql_fetch_assoc(mysql_query("SELECT postcode , region,postcode  FROM `postcodes` WHERE `suburb` Like '%".$suburb."%' AND site_id = ".$site_id." Limit 0 ,1"));
	
   $staff_arg = "select * from staff where status=1 and (site_id =".$site_id." OR site_id2 = ".$site_id.") AND no_work = 1 AND  FIND_IN_SET  ('".$jobtype."',job_types)";

 /* if($quote_for > 0) {
  $staff_arg .= " AND better_franchisee = ".$quote_for." ";
}  */

 $staff_arg .= " order by staff_member_rating desc";

//echo  $staff_arg;
 
$staff_table = mysql_query($staff_arg);
$totalCount = mysql_num_rows($staff_table);
?>

<style>
  .confirm_availability{
	padding: 3px;
    margin-top: 15px;
    cursor: pointer;
    background: #e6a6b8;
    color: black;
    font-size: 15px;
  }
</style>

<span id="get_avail_sms" style="font-size: 12px; color: red; float: right; margin-top: -16px;margin-left: -26px;"></span>

<div style="margin-top: -17px;"><h3>Quote For  : <?php echo $quotefor = get_rs_value("quote_for_option","name",$quote_for); ?></h3>
<div><h3>Site id : <?php echo $site_name = get_rs_value("sites","name",$site_id); ?></h3>
<strong>Total Staff (<?php echo $totalCount; ?>)  available in <?php echo get_rs_value("sites","abv",$site_id); ?></strong></div></br></br>
<div class="table_dispatch table-scroll" style="margin-top: -24px;">
<table id="stafforderSet">
 <?php  if($totalCount > 0) { ?>
		<thead class="thead-row"> 
			<tr>
      <th>STAFF</th>
      <?php 
	   
				for($i=1;$i<=3;$i++){ 
				//for red and greem dot 							
							$getBookedColorWithRegion = getQuoteBookedByDate($start_date_ts_h,'check_avil',$site_id);
							//print_r($getBookedColorWithRegion);
							
							if( $getBookedColorWithRegion['dot_color'] == 1 )
							{
								$dotColor = '<span class="greennew"></span>';
							}
							else
							{
								$dotColor = '<span class="rednew"></span>';
							}
							
							echo '<th>'. $dotColor . '<p>'.date("l",$start_date_ts_h).'</p><span class="table_span">'.date("dS M Y",$start_date_ts_h).'</span>' . $getBookedColorWithRegion['tool_outer'] . '</th>';
							
							/* echo '<th>'. $dotColor . '<p>'.date("l",$start_date_ts_h).'</p><span class="table_span">'.date("dS M Y",$start_date_ts_h).'</span></th>'; */
							
							$start_date_ts_h = ($start_date_ts_h+86400);
							
							unset($getBookedColorWithRegion);
							$getBookedColorWithRegion = '';
							
					/* echo '<th>'.date("l",$start_date_ts_h).'<br><span class="table_span">'.date("dS M Y",$start_date_ts_h).'</span></th>';
					$start_date_ts_h = ($start_date_ts_h+86400); */
				}
			?>
    </tr>
  </thead>
    <?php
	/* $find_arr = array("Cleaning","Carpet","Uphostry","Upholstry","Pest","Gardening","Oven");
	$rep_arr = array("C","Ca","U","U","P","G","O"); */
	
	   $getjobSql =   mysql_query("SELECT id,name,short_name FROM `job_type`");
	  
		while ($getjobname = mysql_fetch_assoc($getjobSql))
		{ 
	       $find_arr[] = $getjobname['name'];
	       $rep_arr[] = $getjobname['short_name'];
	       $jobid[] = $getjobname['id'];
		}
	
	 $getstaffid = array();
	while ($staff = mysql_fetch_assoc($staff_table))
	{ 
       // $getstaffid[] = $staff['id'];
		$staff_location = get_rs_value("sites","name",$staff['site_id']);
		$job_type1 = str_replace($find_arr,$rep_arr,$staff['job_types']);
		$job_name = str_replace($find_arr,$find_arr,$staff['job_types']);
		
		if($getjob_type_id == '11') {
		  $getallcubic = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(cubic_meters) as cubimeter FROM `staff_trucks` where staff_id  = ".$staff['id']." "));
		}
		
		if($get_quote_id > 0) {
		    
		     $from_address = get_rs_value("quote_new","address",$get_quote_id);
		    
		    if(trim($from_address) == '') {
		         $from_address = $suburb." ".$getPostCode["region"]." ".$getPostCode["postcode"]." ,Australia";
		    }
		    	
		}else{
		
		   $from_address = $suburb." ".$getPostCode["region"]." ".$getPostCode["postcode"]." ,Australia";
		}
		
		//$from_address  = $suburb .''.$getPostCode['region'].', Australia';
	//	$from_address = $suburb." ".$getPostCode["region"]." ".$getPostCode["postcode"]." , Australia";
		//$from_address  = $suburb .''.$getPostCode['region'].', Australia';
		
		$toaddress = $staff['from_address'].', Australia';
		
		//echo  $staff['id'] . '======='. $from_address . ' == ' . $toaddress .'<br/>' ; 
		
		//$getdist = Calculategetdisctance($from_address , $toaddress);
		if($get_quote_id > 0 && $toaddress != '') {
		  $getdist = getDistancedata_forstaff($from_address , $toaddress ,  $staff['id']);
		}else{
		        $getdist['time'] = '';
          $getdist['distance'] = '';
		}
		
		
		
		
		/* echo '<pre>'; 	print_r($getdist);
		echo '<br/>'; */

		
	?>
    <tr <?php  if($get_quote_id > 0) { ?> style="border: 2px solid #dd1616;" <?php  } ?> >
        <td <?php if($staff['do_not_call'] == '2') { ?>  style="background: #ebde71;" title="DO Not Call"   <?php  } ?>>
	      <strong><a href="tel:<?php echo $staff['mobile']; ?>"><?php echo ucfirst($staff['name']);?></a></strong>
	       <br><span class="text11" title="<?php echo $staff_location;?> | <?php echo  $job_name; ?>"> (<?php echo $job_type1;?>)</span></br>
		    <span><?  echo get_rs_value("quote_for_option","name",$staff['better_franchisee']);?>
		   
			  <?php if($getjob_type_id == '11') { ?>
			    <br/>
				Cm3 (<?php echo $getallcubic['cubimeter']; ?>)
			  <?php  } ?>	
		    </span>
        </td>
		
		
      <?php
	
        $sdate_staff = $start_date_ts;
        for($i=1;$i<=3;$i++)
		{
		    if($getjob_type_id != 11) {	
			
				$jd_arg = "select * from job_details where status!=2 ";
				$jd_arg.= " and staff_id=".$staff['id']." and job_date='".date("Y-m-d", $sdate_staff)."' and job_id in (select id from jobs where status in(1,3,4))";
				$jd_arg.= "  GROUP by job_id";
				
		    }
			else
			{
				$substaffsql = mysql_query("SELECT GROUP_CONCAT(id) as cubimeter FROM `staff_trucks` where staff_id  = ".$staff['id']." ");
						
						$getsubstaff1 = array();
						
							while($getsubstaff = mysql_fetch_assoc($substaffsql)){
								$getsubstaff1[] = $getsubstaff['cubimeter'];
							}
				
                //  print_r($getsubstaff1);				
					  $jd_arg = "select *  from job_details where status!=2 ";
					  $jd_arg.= " and staff_id=".$staff['id']." AND staff_truck_id in  (".$getsubstaff1[0].")  AND job_date='".date("Y-m-d", $sdate_staff)."' and job_id in (select id from jobs where status in(1,3,4))";
					  $jd_arg.= "  GROUP by job_id";
			}
			
			
					$job_details_data = mysql_query($jd_arg);
					
			
			if(mysql_num_rows($job_details_data)>0){
			
			echo "<td>";
			  
			  				$i_i = 1;
				while($job_details = mysql_fetch_assoc($job_details_data))
				{				
					
					
					
					$quote = mysql_fetch_array(mysql_query("select name,suburb, bbcapp_staff_id,booking_date,date  from quote_new where booking_id=".$job_details['job_id'].""));			
					
					$job = mysql_fetch_array(mysql_query("select status from jobs where id=".$job_details['job_id'].""));
					
					$job_payment_data = mysql_query("SELECT sum(amount) as total_amt FROM `job_payments` WHERE job_id=".mysql_real_escape_string($job_details['job_id'])." and deleted=0");
					$job_payment = mysql_fetch_array($job_payment_data);
					
					// total payment for the job
					$job_details_data1 = mysql_query("SELECT sum(amount_total) as total_amt FROM `job_details` WHERE job_type_id=1 and job_id=".mysql_real_escape_string($job_details['job_id'])." and status!=2");
					$job_details_amt = mysql_fetch_array($job_details_data1);
					
					//echo $job_payment['total_amt'];
					//echo "Payment Rec:".$job_payment['total_amt']." Total_Amt".$job_details_amt['total_amt']."<br>";
					if($job_payment['total_amt']==""){ 
						$payment_status = "(Not Paid)";
					}else if($job_payment['total_amt']<$job_details_amt['total_amt']){
						$payment_status = "(Semi Paid)";
					}else if($job_payment['total_amt']>=$job_details_amt['total_amt']){
						$payment_status = "(Paid)";
					}
					
						$argSql  = "select quote_id,staff_id,job_type_id from job_details where job_id=".$job_details['job_id']." and status!=2";					
  //echo $argSql;
  
						$page = 'jobs';
						$type = '';
						$tol_type = 'Job';	
						 $job_details1 = mysql_query($argSql);
						        if(mysql_num_rows($job_details1)>0) {
								
										while($jdetails = mysql_fetch_assoc($job_details1)){ 
										
										
									    //print_r($jdetails);		
										
										$job_icon =  get_rs_value("job_type","job_icon",$jdetails['job_type_id']);
										  $staffdetails = mysql_fetch_array(mysql_query("Select mobile,name from staff where id = ".$jdetails['staff_id']));
										
										
										  $staff_mobile  = $staffdetails['mobile'];
										  $staff_name  = $staffdetails['name'];
										
										 if($jdetails['staff_id'] != 0) {
											 $get_desc = get_sql("quote_details","description"," where quote_id = '".$jdetails['quote_id']."'  and job_type_id=".$jdetails['job_type_id']." AND status != 2");
											 
										    // $staffmobile = "<a href='tel:'.$staff_mobile.'>'.$staff_mobile.'</a>";
											 $job_alldetails1[] = $staff_name.' , <a href="tel:'.$staff_mobile.'" style="color:#fff;">'.$staff_mobile.'</a> <br>  <span style="margin-left: 27px;">'.$get_desc.'</span> <hr>';
											  $staffassig1[] = 'job_icone/'.$job_icon;
										 }else{
											// $staffassig = 'job_type_red'; 
											 $staffassig1[] = 'job_type_red/'.$job_icon; 
											 $job_alldetails1[] = 'N/A , N/A';
										 ///public_html/admin/icones/job_icone
										 }
										 
									} 
								}
						
					
					$bbcapp_staff_id   = $quote['bbcapp_staff_id'];
					$booking_date   = $quote['booking_date'];
					$date   = $quote['date'];	
					
				?>
     
					
					<div <?php  if(($bbcapp_staff_id == $staff['id']) && $date == date('Y-m-d')) {  ?>  style="background: #7bd67f;"  <?php  } else { ?>  class="td_back td_back_<?php if($job['status']=="3"){ echo 'green'; }elseif($job['status']=="1"){ echo 'red'; }else if($job['status']=="4"){ echo 'orange'; } } ?>">
					
					<?php  
					
					
					 
					
					    if($getjob_type_id == 11) {	
						
                            $stafftrucks  = explode(',' , $getsubstaff1[0]);
							unset($stafftrucks[array_search($job_details['staff_truck_id'], $stafftrucks)]);
							
							 /* $staff_truckscubic = array();
							 foreach($stafftrucks as $truckid){
									$staff_truckscubic[] =  get_rs_value("staff_trucks","cubic_meters",$truckid);
							 } */
						}
                            
     
						//echo explode(',' , $getsubstaff1[0]) . $jd_arg; ?>
						
					<a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $job_details['job_id'];?>','1200','850')">
						#<?php echo $job_details['job_id'];?> <?php echo $quote['name'];?><br>
						<?php echo $quote['suburb'];?> <?php echo $payment_status; ?><br>
						<?php  if($getjob_type_id == 11) {	 ?>					
							(<?php echo get_rs_value("staff_trucks","cubic_meters",$job_details['staff_truck_id']); ;?>Cm3)
						<?php  } ?></a>	
						
						
						<?php  
						
						
						
						if($getjob_type_id == 11) {	 ?>	
						<?php // echo "<br/>==============<br/>".implode('|' , $staff_truckscubic); ?>
					<?php  } ?> 	
					
						
					        <div class="tooltip_div tooltip_div_New">
							
									 <span class="name_text"><a style="color:#fff;" href="javascript:scrollWindow('popup.php?task=<?php echo $page; ?>&job_id=<?php echo $job_details['job_id'];?>','1200','850')"><?php echo $tol_type; ?> (J#<?php echo $job_details['job_id']; ?>)
										  <?php  if($getjob_type_id == 11) {	 ?>		
											(<?php echo get_rs_value("staff_trucks","cubic_meters",$job_details['staff_truck_id']); ;?>Cm3)
										  <?php  } ?>	
									 </a></span>	
										
										<?php  
										
										if(!empty($job_alldetails1)) {
										
										foreach($job_alldetails1 as $key=>$value) { ?>
										<span class="name_text">
										   <img class="image_icone" src="icones/<?php echo $staffassig1[$key]; ?>"/> - <?php echo $job_alldetails1[$key]; ?>
										</span>
										<?php  unset($staffassig1[$key]); unset($job_alldetails1[$key]);
										} }else { ?>
										<span class="name_text">
										   No job assign for staff.
										</span>
										<?php  } ?>
							</div>
						
					</div>
					
					
      
                    <?php	
				if($get_quote_id > 0 && $getjob_type_id != 11)  {	
					echo '<br/>';	
					echo  'Time =>'.$getdist['time'];  
					echo '<br/>';
					echo  'Dis =>'.$getdist['distance'];  	
					
					if($i_i == 2) {
					  echo '<hr>';
					}
				
					$i_i++;
				 ?>	
				 </br>
				 <span  ></span>
				<a  href="javascript:void(0)"  class="confirm_availability" onClick="send_data('<?php echo  $get_quote_id.'|'.$staff['id'].'|'.date("Y-m-d", $sdate_staff).'|'.$suburb; ?>' , 564 , 'get_avail_sms')">Send SMS</a>
				</br>
			<?php 	
				}			
			}
		
		
		
		        echo "</td>";
			}else{
				
				

				
					$AllPostCode = explode(',' , $staff['primary_post_code']);
					if(in_array($getPostCode['postcode'] , $AllPostCode)) { $codeStatus = 1;}else{ $codeStatus = 2;} 
					
				$makedata = date("Y-m-d", $sdate_staff);
				$getStaffCheck = mysql_query("SELECT * FROM `staff_roster` where staff_id ='".$staff['id']."' and date = '".$makedata."'");
				$CheckAvil = mysql_fetch_assoc($getStaffCheck);	
				
				?>
				
				
				
         <td  <?php  if($CheckAvil['status'] == '1'){ ?> <?php }else { ?>style = 'background-color: #ebccd1;'  <?php  } ?> 
		 
		 <?php   if($staff['better_franchisee'] == '2'&& $codeStatus == 1){ ?> style = 'background-color: #9c9494;' <?php } ?>>
		 <br>
		 <?php 
		 if($get_quote_id > 0 && $getjob_type_id != 11) {
			echo  'Time =>'.$getdist['time'];  
			echo '<br/>';
			echo  'Dis =>'.$getdist['distance'];  
			?>
			
			 </br>
			  <span ></span>
				<a  href="javascript:void(0)"  class="confirm_availability"  onClick="send_data('<?php echo  $get_quote_id.'|'.$staff['id'].'|'.date("Y-m-d", $sdate_staff).'|'.$suburb; ?>' , 564 , 'get_avail_sms')">Send Noti</a>
				</br>
			  <?php   }
		  ?>
		</td>
      <?php
			}
			
            $sdate_staff = ($sdate_staff+86400);
        }
    ?>
    </tr>
    <?php	
	// 
    }
		}else{  ?>
	<tr>	
	  <td><strong>No Staff Available</strong></td>		
	</tr>  
	<?php 	}	?>
</table>
</div>
<?php  }else { 
  include('removal_check.php');

  } ?>
