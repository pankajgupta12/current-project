<?php 

 
//$booking_date1 = rotatedate($booking_date);
//echo $booking_date;
$start_date_ts = strtotime($booking_date);
$start_date_ts = ($start_date_ts-86400);
$end_date_ts = $start_date_ts+(86400*3);
$start_date_ts_h = $start_date_ts;
$quote_for = $quote_for;

//echo $getjob_type_id;

	 
	$jobtype = 'Removal';
    $getPostCode =  mysql_fetch_assoc(mysql_query("SELECT postcode  FROM `postcodes` WHERE `suburb` Like '%".$suburb."%' Limit 0 ,1"));
	
   $staff_arg = "select * from staff where status=1 and (site_id =".$site_id." OR site_id2 = ".$site_id.") AND no_work = 1 AND  FIND_IN_SET  ('".$jobtype."',job_types)";
   $staff_arg .= " order by staff_member_rating desc";
 
	$staff_table = mysql_query($staff_arg);
	$totalCount = mysql_num_rows($staff_table);
	
?>

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
							
							echo '<th>'. $dotColor . '<p>'.date("l",$start_date_ts_h).'</p><span class="table_span">'.date("dS M Y",$start_date_ts_h).'</span>
								</th>';
							
							$start_date_ts_h = ($start_date_ts_h+86400);
							
							unset($getBookedColorWithRegion);
							$getBookedColorWithRegion = ''; 
							
							
					/* echo '<th><p>'.date("l",$start_date_ts_h).'</p><span class="table_span">'.date("dS M Y",$start_date_ts_h).'</span>
								</th>';	
								$start_date_ts_h = ($start_date_ts_h+86400); */
				}
				
			
			?>
    </tr>
  </thead>
    <?php
	
	
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

              $truckstaff =  mysql_query("SELECT * FROM `staff_trucks` WHERE staff_id = ".$staff['id']." ");
			  
			    // $getstaffid[] = $staff['id'];
		$staff_location = get_rs_value("sites","name",$staff['site_id']);
		$job_type1 = str_replace($find_arr,$rep_arr,$staff['job_types']);
		$job_name = str_replace($find_arr,$find_arr,$staff['job_types']);
		
			  
			while($gettruckdata =mysql_fetch_assoc($truckstaff))   {
		
	?>
    <tr>
        <td>
	      <strong><?php echo ucfirst($staff['name']);?> <br/>(<?php echo $gettruckdata['cubic_meters']; ?>)Cm3 </strong>
	      <br><span class="text11" title="<?php echo $staff_location;?> | <?php echo  $job_name; ?>"> (<?php echo $job_type1;?>)</span></br>
		   <span><?  echo get_rs_value("quote_for_option","name",$staff['better_franchisee']);?></span>
        </td>
		
		
      <?php
	
        $sdate_staff = $start_date_ts;
        for($i=1;$i<=3;$i++)
		{
						
					$jd_arg = "select *  from job_details where status!=2 ";
					$jd_arg.= " and staff_id=".$staff['id']." AND staff_truck_id = '".$gettruckdata['id']."'  AND job_date='".date("Y-m-d", $sdate_staff)."' and job_id in (select id from jobs where status in(1,3,4))";
					$jd_arg.= "  GROUP by job_id";
			
			
			//echo $jd_arg;
			
				$job_details_data = mysql_query($jd_arg);
					
			
			if(mysql_num_rows($job_details_data)>0){
			
			echo "<td>";
			
				while($job_details = mysql_fetch_assoc($job_details_data))
				{				
					
					
					
					$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".$job_details['job_id'].""));			
					$job = mysql_fetch_array(mysql_query("select * from jobs where id=".$job_details['job_id'].""));
					
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
						$page = 'jobs';
						$type = '';
						$tol_type = 'Job';	
						 $job_details1 = mysql_query($argSql);
						    if(mysql_num_rows($job_details1)>0) {
								
										while($jdetails = mysql_fetch_assoc($job_details1)){ 
										
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
						
					
				?>
     
					
					<div class="td_back td_back_<?php if($job['status']=="3"){ echo 'green'; }elseif($job['status']=="1"){ echo 'red'; }else if($job['status']=="4"){ echo 'orange'; } ?>">
					
					<?php  
						
                            $stafftrucks  = explode(',' , $getsubstaff1[0]);
							unset($stafftrucks[array_search($job_details['staff_truck_id'], $stafftrucks)]);
					 ?>
						
					<a href="javascript:scrollWindow('popup.php?task=jobs&job_id=<?php echo $job_details['job_id'];?>','1200','850')">
						#<?php echo $job_details['job_id'];?> <?php echo $quote['name'];?><br>
						<?php echo $quote['suburb'];?> <?php echo $payment_status; ?><br>
						<?php  if($getjob_type_id == 11) {	 ?>					
							(<?php echo get_rs_value("staff_trucks","cubic_meters",$job_details['staff_truck_id']); ;?>Cm3)
						<?php  } ?></a>	
							
					
						
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
			    }
		
		        echo "</td>";
			}
			  else
			{
				$AllPostCode = explode(',' , $staff['primary_post_code']);
			if(in_array($getPostCode['postcode'] , $AllPostCode)) { $codeStatus = 1;}else{ $codeStatus = 2;} 
					
				$makedata = date("Y-m-d", $sdate_staff);

				$getStaffCheck = mysql_query("SELECT * FROM `staff_roster` where staff_id ='".$staff['id']."' and date = '".$makedata."'");
				$CheckAvil = mysql_fetch_assoc($getStaffCheck);	
				
			  
			   
			 
				?>
				
				
		    <?php  if($CheckAvil['status'] == '1') { 
			
			  $quote_type = $quote_type;
			
			    $string = $get_quote_id.'__'.$gettruckdata['depot_address'].'__'.$makedata.'__'.$staff['id'].'__'.$gettruckdata['id'].'__'.$quote_type;
				
				echo $string;
			?>
			
                <td class="calculate_depot_distance" for="<?php echo $string; ?>_##$$_show_travell_time_<?php echo $makedata; ?>_<?php echo $staff['id']; ?>_<?php echo $gettruckdata['id']; ?>_<?php echo $quote_type; ?>" id="show_travell_time_<?php echo $makedata; ?>_<?php echo $staff['id']; ?>_<?php echo $gettruckdata['id']; ?>_<?php echo $quote_type; ?>">
				    <a style="cursor: pointer;" onclick="send_data('<?php echo $string; ?>' , 407 , 'show_travell_time_<?php echo $makedata; ?>_<?php echo $staff['id']; ?>_<?php echo $gettruckdata['id']; ?>_<?php echo $quote_type; ?>');"> Calculate </a>
					<div class="loader-content">
					<div class="loader"></div>
					</div>
				</td>
				
			<?php  } else {?>		 
				<td style = 'background-color: #ebccd1;'></td>
			<?php  } ?>
      <?php
			}
			
            $sdate_staff = ($sdate_staff+86400);
        }
    ?>
    </tr>
    <?php	
	}
	// 
    }
		}else{  ?>
	<tr>	
	  <td><strong>No Staff Available</strong></td>		
	</tr>  
	<?php 	}	?>
</table>
</div>

<style>
.table_dispatch table tbody tr td {
    position: relative;
}
.loader-content {
	position:absolute;    
	background: rgba(0,0,0,0.5);
    position: absolute;
    content: '';
    left: 0;
    right: 0;
    top: 0;
    height: 100%;
    width: 100%;
}
.loader {
  border: 6px solid #ddd;
  border-radius: 50%;
  border-top: 6px solid #00b8d4;
  width: 20px;
  height: 20px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;    
  position: absolute;
    left: 0;
    right: 0;
    margin: auto;
    top: 0;
    bottom: 0;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>