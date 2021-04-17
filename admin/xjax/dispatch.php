<?php 


  //   print_r($_SESSION['dispatch']);

	if($_SESSION['dispatch']['from_date']==""){ $_SESSION['dispatch']['from_date'] = date("Y-m-d"); }
	if($_SESSION['dispatch']['quote_for']==""){ $_SESSION['dispatch']['quote_for'] = 1; }

	$start_date_ts = strtotime($_SESSION['dispatch']['from_date']);
	$end_date_ts = $start_date_ts+(86400*7);
	$start_date_ts_h = $start_date_ts;

	//$staff_arg = "select * from staff where status=1";
	$staff_arg = "select id, name ,do_not_call, email ,site_id ,job_types, mobile , nick_name, team_of , staff_member_rating , no_work from staff where status=1";
	
	if(isset($_SESSION['dispatch']['site_id']) && $_SESSION['dispatch']['site_id']!="0"){
	    
 		$staff_arg.=" and (site_id=".$_SESSION['dispatch']['site_id']." or site_id2=".$_SESSION['dispatch']['site_id'].")"; 
		$get_site_id = $_SESSION['dispatch']['site_id'];
	} 
	
	if(isset($_SESSION['dispatch']['job_type']) && $_SESSION['dispatch']['job_type']!="0"){ 
	    
    	$staff_arg.=" and job_types like '%".$_SESSION['dispatch']['job_type']."%'"; 
    	
	}
	
	if(isset($_SESSION['dispatch']['staff_id']) && $_SESSION['dispatch']['staff_id']!="0"){
		$staff_arg.=" and id =".$_SESSION['dispatch']['staff_id'].""; 
	}
	
	if(isset($_SESSION['dispatch']['quote_for']) && $_SESSION['dispatch']['quote_for'] =="1"){
		 $staff_arg.=" and better_franchisee in (1,2) "; 
		
	}else{
		$staff_arg.=" and better_franchisee =".$_SESSION['dispatch']['quote_for'].""; 
	}

	 $staff_arg.= ' order by staff_member_rating desc';
	 //echo $staff_arg."<br>";

	$staff_table = mysql_query($staff_arg);
	$countResult = mysql_num_rows($staff_table);

	
	
	    $getjobSql =   mysql_query("SELECT id , job_icon , name,short_name FROM `job_type`");
					while ($getjobname = mysql_fetch_assoc($getjobSql))
					{ 
					   $find_arr[] = $getjobname['name'];
					   $rep_arr[] = $getjobname['short_name'];
					   $jobtype[$getjobname['id']] = $getjobname['job_icon'];
					}
					
				$sitedata = getSite();
                $teamarrdata = system_dd_type(48);	
			
	?>
	<div class="table-scroll">
		<table id="stafforderSet">
			<thead class="thead-row"> 
				<tr>
				  <th>STAFF</th>
				  <?php 
				  		
							for($i=1;$i<=7;$i++)
							{							
								//for red and greem dot 							
								$getBookedColorWithRegion = getQuoteBookedByDate($start_date_ts_h,'dispatch',$get_site_id);
								
								 if( $getBookedColorWithRegion['dot_color'] == 1 )
								{
									$dotColor = '<span class="greennew"></span>';
								}
								else
								{
									$dotColor = '<span class="rednew"></span>';
								}
								if($_SESSION['dispatch']['site_id'] == '0' || $_SESSION['dispatch']['site_id'] == '') {	
									echo '<th>'. $dotColor . '<p>'.date("l",$start_date_ts_h).'</p><span class="table_span">'.date("dS M Y",$start_date_ts_h).'</span>' . $getBookedColorWithRegion['tool_outer'] . '</th>';
									
								}else{
									echo '<th>'. $dotColor . '<p>'.date("l",$start_date_ts_h).'</p><span class="table_span">'.date("dS M Y",$start_date_ts_h).'</span></th>';
									
								}
								
								 $start_date_ts_h = ($start_date_ts_h+86400);
									unset($getBookedColorWithRegion);
									$getBookedColorWithRegion = '';
							}
						?>
				</tr>
			</thead>
	    <tbody class="thead-col">
		<?php
		
		//die;
			if($countResult > 0) {	
				
				$rating = 1;
				$zzz=0;
			//	echo $start = microtime(true); // time in Microseconds
			//	echo "<br />";
				while ($staff = mysql_fetch_assoc($staff_table))
				{ 
					//$staff_location = get_rs_value("sites","name",$staff['site_id']);
					$staff_location = $sitedata[$staff['site_id']];
					$job_type = str_replace($find_arr,$rep_arr,$staff['job_types']);
		?>
		<tr>
			<td>
				<div class="td_back" <?php if($staff['do_not_call'] == '2') { ?>  style="background: #ebde71;" title="DO Not Call"   <?php  }else if($staff['no_work'] == '2') {  ?> style="background: #f7baba;" title="Not Work" <?php }   ?> ><strong><?php if($staff['nick_name'] &&  $staff['nick_name'] !='') { echo $staff['nick_name']; }else {echo $staff['name'];}?></strong><br>
				   <span class="text11">(<?php echo $staff_location;?>)  (<?php echo $job_type;?>)</span>
					<div class="tooltip_div">
						<span class="name_text">Name : <?php echo $staff['name'];?></span>
						<span class="name_text">Email : <?php echo $staff['email'];?> </span>
						<span class="name_text">Phone : <a style="color: #fff;" href="tel:<?php echo $staff['mobile'];?>"><?php echo $staff['mobile'];?></a> </span>
						<span class="name_text">Team of : <?php  echo  $teamarrdata[$staff['team_of']];  //echo getSystemvalueByID($staff['team_of'],48);?> </span>
						<span class="name_text">
							<select id="soflow-color" name="ratingPoint" onChange="RatingStaffDispatchborad(this.value,'<?php echo $staff['id'];?>');">
							   <option>Select Rating</option>
								 <?php for($rating = 0; $rating<=5; $rating++) {?>
								   <option value="<?php echo $rating; ?>" <?php if($staff['staff_member_rating'] == $rating) {echo  "selected";} ?>><?php echo $rating; ?></option>
								 <?php } ?>
							</select>
						</span>
						
						<ul class="tooltip_ul">
							<li><a onclick="javascript:scrollWindow('staff_details.php?task=edit_staff&id=<?php echo $staff['id'];?>','1200','850')" >Modify</a></li>
							<li><a onclick="javascript:scrollWindow('staff_details.php?task=staff_roster&id=<?php echo $staff['id'];?>','1200','850')" >Roster</a></li>
							<li><a Onclick="javascript:scrollWindow('staff_details.php?task=staff_docs&id=<?php echo $staff['id'];?>','1200','850')">Staff FIle</a></li>
						</ul>
					</div>
				</div>
			</td>
		  <?php
    	 $zzz++;
			$sdate_staff = $start_date_ts;
			
		$jobdetails = getDIspatchReport($_SESSION['dispatch']['job_type'] , $staff['id'], $sdate_staff);	
		
	    //echo '<pre>';	print_r($jobdetails);  die;
			
			for($i=1;$i<=7;$i++)
			{
			   
			
			/*	$jd_arg = "select job_id,quote_id , reclean_job from job_details where status!=2 ";
				
				if(isset($_SESSION['dispatch']['job_type']) && $_SESSION['dispatch']['job_type']!="0"){
					
				     $jd_arg.= " and job_type='".$_SESSION['dispatch']['job_type']."'"; 
					 
				}
				
				$jd_arg.= " and staff_id=".$staff['id']." and job_date='".date("Y-m-d", $sdate_staff)."'";
				$jd_arg.= " and job_id in (select id from jobs where status in(1,3,4,5)) OR job_id in (select job_id from job_reclean where status!=2 and staff_id=".$staff['id']."";
				$jd_arg.= " and reclean_date='".date("Y-m-d", $sdate_staff)."')";
				
				
				$jd_arg.= "  GROUP by job_id";

				$job_details_data = mysql_query($jd_arg);*/
				
				//die;
				//index done
				
			
				
				$castatus = "";
				 $getStaffCheck = mysql_query("SELECT status FROM `staff_roster` where staff_id ='".$staff['id']."' and date = '".date("y-m-d", $sdate_staff)."'");
					if(mysql_num_rows($getStaffCheck)>0){ 			
					  $CheckAvil = mysql_fetch_array($getStaffCheck);
					  $castatus = $CheckAvil['status'];
					}else{
						$castatus = '0';
					}
				
				if($castatus == '0'){ echo "<td style = 'background-color: #ebccd1;' >"; } else{ echo "<td>"; } 
				//echo "<td>";
				
				$currentdate = date("Y-m-d", $sdate_staff);
				
				
					
			   //	$job_details1 = $jobdetails[$staff['id']];
				  $job_details1 = $jobdetails[$staff['id']][$currentdate];
				  
				
				  
				if(!empty($job_details1) && count($job_details1) > 0) {
				    
				   foreach($job_details1 as $key=>$job_details) {
				    
				 	    $job_status = get_rs_value("jobs","status",$job_details['job_id']);	
						
						$job_payment_data = mysql_query("SELECT sum(amount) as total_amt FROM `job_payments` WHERE job_id=".mysql_real_escape_string($job_details['job_id'])." and deleted=0");
						$job_payment = mysql_fetch_array($job_payment_data);
						
						
						// total payment for the job
						$job_details_data1 = mysql_query("SELECT sum(amount_total) as total_amt FROM `job_details` WHERE job_type_id in(select id from job_type where inv=1) and job_id=".mysql_real_escape_string($job_details['job_id'])." and status!=2");
						$job_details_amt = mysql_fetch_array($job_details_data1);
					
  					    if($job_payment['total_amt']==""){ 
							$payment_status = "(Not Paid)";
						}else if($job_payment['total_amt']<$job_details_amt['total_amt']){
							$payment_status = "(Semi)";
						}else if($job_payment['total_amt']>=$job_details_amt['total_amt']){
							$payment_status = "(Paid)";
						}
						
					    $getQuote = mysql_fetch_array(mysql_query("Select name,suburb, bbcapp_staff_id,booking_date,date from quote_new where id = ".$job_details['quote_id']));
						
							$q_name   = $getQuote['name'];
							$q_suburb   = $getQuote['suburb'];
							$bbcapp_staff_id   = $getQuote['bbcapp_staff_id'];
							$booking_date   = $getQuote['booking_date'];
							$date   = $getQuote['date'];
					
							if($job_status=="5"){ 
							
								  $page = 'job_reclean';
								  $type = '';
								  $tol_type = 'Re-Clean';
								  
								  $argSql  = "select quote_id,staff_id,job_type_id ,  (SELECT CONCAT(mobile ,'----' , name) from staff  WHERE id = staff_id) as staffinfo , sub_staff_id from job_reclean where job_id=".$job_details['job_id']." and status!=2";		
	 
							}else { 
								  $argSql  = "select quote_id,staff_id,job_type_id , (SELECT CONCAT(mobile ,'----' , name) from staff  WHERE id = staff_id) as staffinfo, sub_staff_id from job_details where job_id=".$job_details['job_id']." and status!=2";							
								   $page = 'jobs';
								   $type = '';
								   $tol_type = 'Job';
							} 
							
						  $reclean_job = get_sql("job_details","reclean_job"," where job_id = '".$job_details['job_id']."'  and job_type_id = '1' AND status != 2");
							
					  ?>
					 
					    <div <?php   if($bbcapp_staff_id === $staff['id']) {  ?> style="background: #7bd67f;"  <?php  } else { ?>   class="td_back td_back_<?php if($reclean_job == "2" && $job_status == 3) { echo 're_dark'; }elseif($job_status=="3" && $reclean_job == 1){ echo 'green'; }elseif($job_status=="1"){ echo 'red'; }else if($job_status=="4"){ echo 'orange'; }else if($job_status=="5"){ echo 'darkred'; } } ?>">
						    <a href="javascript:scrollWindow('popup.php?task=<?php echo $page; ?>&job_id=<?php echo $job_details['job_id'];?>','1200','850')">
						    <p>( <?php echo $type;?>#<?php echo $job_details['job_id'];?> ) <?php echo $q_name;?></p>
							 <?php echo $q_suburb;?> <?php  //echo $jd_arg; ?> <?php echo $payment_status; ?>	</a>
							
							<?php  
								  
								 //echo $argSql;
								  $job_details1 = mysql_query($argSql);
								  
								  if(mysql_num_rows($job_details1)>0) {
								      
										while($jdetails = mysql_fetch_assoc($job_details1)) { 
										    
										
										 $job_icon =  $jobtype[$jdetails['job_type_id']];
										
										 $staffinfo = explode('----',$jdetails['staffinfo']);
										 
										  $staff_mobile = $staffinfo[0];
										  $staff_name = $staffinfo[1];
										  
										  /*$staffdetails = mysql_fetch_array(mysql_query("Select mobile,name from staff where id = ".$jdetails['staff_id']));
										  $staff_mobile  = $staffdetails['mobile'];
										  $staff_name  = $staffdetails['name'];*/
										
										 if($jdetails['staff_id'] != 0) {
											 $get_desc = get_sql("quote_details","description"," where quote_id = '".$jdetails['quote_id']."'  and job_type_id=".$jdetails['job_type_id']." AND status != 2");
											 
											if($jdetails['sub_staff_id'] != 0) {
                                               $substaffdetails = mysql_fetch_array(mysql_query("Select mobile,name from sub_staff where id = ".$jdetails['sub_staff_id']));
											   $substaffname = $substaffdetails['name'];
											   $substaffmobile = $substaffdetails['mobile'];
											   
											   $substaff = '<br/><hr><p style="margin-left: 8px;padding: 6px;">  <b> Sub staff :</b>'.$substaffname.',<a href="tel:'.$substaffmobile.'" style="color:#fff;">'.$substaffmobile.'</a></p><hr>';
											} else{
												$substaff = '';
											}
											 
										    // $staffmobile = "<a href='tel:'.$staff_mobile.'>'.$staff_mobile.'</a>";
											 $job_alldetails1[] = $staff_name.' , <a href="tel:'.$staff_mobile.'" style="color:#fff;">'.$staff_mobile.'</a>'.$substaff.' <br>  <span style="margin-left: 27px;">'.$get_desc.'</span> <hr>';
											  $staffassig1[] = 'job_icone/'.$job_icon;
										 }else{
											// $staffassig = 'job_type_red'; 
											 $staffassig1[] = 'job_type_red/'.$job_icon; 
											 $job_alldetails1[] = 'N/A , N/A';
										 ///public_html/admin/icones/job_icone
										 }
										 
									} }?>
								
								    <div class="tooltip_div tooltip_div_New">
									 <span class="name_text"><a style="color:#fff;" href="javascript:scrollWindow('popup.php?task=<?php echo $page; ?>&job_id=<?php echo $job_details['job_id'];?>','1200','850')"><?php echo $tol_type; ?> (J#<?php echo $job_details['job_id']; ?>) </a></span>	
										
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
					//}
				} // end while 
			} // end if 
			
					echo "</td>";
				
				
				$sdate_staff = ($sdate_staff+86400);
			} // end for 
		?>
		</tr>
		<?php }  ?>	
	    </tbody>
		<?php  }else { ?>
		 <div class="no_record">
			<span>No Record Found</span>
		 </div>
	<?php  } ?> 
	</table>
	
	
	</div>
		<script>
		  document.querySelector('.table-scroll').addEventListener('scroll', function(e){
				this.querySelector('.thead-row').style.top = this.scrollTop +"px";
			});
		</script>
		