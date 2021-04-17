<div class="body_container">
	<div class="body_back">
		<span class="main_head" style="margin-bottom: -33px;">Add New Staff</span>
		    <div class="container">   
			<br/>
				<?php 
				
				//echo "SELECT * FROM `staff` WHERE application_id =".$_GET['appl_id'];
                $sql =   mysql_query("SELECT * FROM `staff` WHERE application_id =".$_GET['appl_id']);
				$Countresult = mysql_num_rows($sql);
				//echo 'sddddddddddddd'.$Countresult;
				
				$days = array('sun'=>'Sunday','mon'=>'Monday','tue'=>'Tuesday','wed'=>'Wednesday','thu'=>'Thursday','fri'=>'Friday','sat'=>'Saturday');
				//$newdays = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
				
				    if($Countresult == 0) {
						
						$getnew = mysql_query("SELECT * FROM `staff_applications` WHERE id =".$_GET['appl_id']);
						$getNewStaffDetails = mysql_fetch_assoc($getnew);
						
						
						
						if($getNewStaffDetails['job_types'] != '') {
							$jobType =  explode(',',$getNewStaffDetails['job_types']);
							
							if(!empty($jobType)) {
								$jobValue = '';
								$jobValueid = '';
								foreach($jobType as $value) {
									 $job_type =  explode('_',$value);	
									 $jobTypeByTbale =  mysql_fetch_assoc(mysql_query("SELECT * FROM `job_type` WHERE name like '%".$job_type[1]."%'"));
									 $jobValue .= $jobTypeByTbale['name'].',';
									 $jobValueid .= $jobTypeByTbale['id'].',';
								}
								
								$jobtypes =  rtrim($jobValue , ',');
								$job_type_id  =  rtrim($jobValueid , ',');
							}
						}else{
							$jobtypes =  '';
							$job_type_id  =  '';
						}

                   
                 						
						//print_r($days);
						
						if($getNewStaffDetails['days_available'] != "") { 
						    
							$working_day = '';
						    $dayAvail =  explode(',', str_replace('avail_','',$getNewStaffDetails['days_available']));
						    //print_r($dayAvail);	

								foreach($dayAvail as $dayvalue) {
									//echo $dayvalue;
									if (array_key_exists($dayvalue,$days))
                                    {
									    $working_day .= $days[$dayvalue].',';	
									}
								}							
						     $working_daye = rtrim($working_day , ',');
							
						}else{
							$working_daye = '';
						}
						
						if($getNewStaffDetails['first_name'] != ''){ 
						   $fullname =  $getNewStaffDetails['first_name'].' '.$getNewStaffDetails['last_name']; 
						}else { 
						   $fullname = $getNewStaffDetails['given_name']; 
						}
						
						if($getNewStaffDetails['first_name'] != ''){ 
						   $nick_name =  $getNewStaffDetails['first_name']; 
						}else { 
						   $nick_name = $getNewStaffDetails['given_name']; 
						}
						
						$adminid = $_SESSION['admin'];
						$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
						
						$sql1 = "INSERT INTO `staff` 
						    ( 
						     `site_id`, `application_id`, `add_admin_name`, `name`,`address`,
							 `email`, `password`, 
							 `company_name`, `bsb`,  `account_number`, `staff_gst`, 
							 `mobile`, `abn`,  `status`, `job_types`, `amt_share_type`, 
							 `nick_name`, `avaibility`, `better_franchisee`, `electronic_consent`, `primary_post_code`,`team_of`,`created_date`,`staff_created_date`
							) 
							 
							 VALUES
							  
							(
								'".$getNewStaffDetails['site_id']."', '".$getNewStaffDetails['id']."','".$adminid."', '".mysql_real_escape_string($fullname)."', '".mysql_real_escape_string($getNewStaffDetails['address'])."','".$getNewStaffDetails['email']."', '12345',
								 '".mysql_real_escape_string($getNewStaffDetails['business_name'])."', '".$getNewStaffDetails['bsb']."',  '".$getNewStaffDetails['account_number']."', '".$getNewStaffDetails['staff_gst']."', 
								 '".$getNewStaffDetails['mobile']."', '".$getNewStaffDetails['abn']."',  '1', '".$jobtypes."',  '".$job_type_id."', 
								 '".mysql_real_escape_string($nick_name)."', '".$working_daye."',  '1', '1',  '".$getNewStaffDetails['post_code']."', '".$getNewStaffDetails['team_of']."', '".date('Y-m-d H:i:s')."' ,  '".date('Y-m-d')."'
							)";
						//echo $sql1;
						$bool = mysql_query($sql1); 
						$laststaffid = mysql_insert_id();
						
						$getInfo['fullname'] = $fullname;
						$getInfo['bsb'] = $getNewStaffDetails['bsb'];
						$getInfo['account_number'] = $getNewStaffDetails['account_number'];
						$getInfo['abn'] = $getNewStaffDetails['abn'];
						
						sendInfo($getInfo);
						
						$comment = " Application to staff Added by ".mysql_real_escape_string($staff_name);
						add_application_notes($getNewStaffDetails['id'],$comment,$comment ,'','','', 0);
						$boolstaffapp = mysql_query("update staff_applications set staff_is_added = '1' , admin_id = ".$adminid."  where id=".$getNewStaffDetails['id'].""); 
						//$boolstaffapp = mysql_query("update application_notes set application_id = ".$laststaffid." where id=".$getNewStaffDetails['id'].""); 
						
						
						
						 $Rostrmonth = array(1=>date('m') , 2=>date('m' , strtotime('+1 month')) , 3=>date('m' , strtotime('+2 month')));
						 
                            foreach($Rostrmonth as $key=>$month) {
							   $rosterNext = checkRosterNext($laststaffid  , $month);	
							} 
							
					        allpFiletransfer($_GET['appl_id'] , $laststaffid); 
							UpdateSearAmount($laststaffid);
					     
					
						if(isset($bool)){
							
							echo '<h4 style="margin-bottom: 10px;"> Staff is added Successfully</h4>';
						}else{
						  echo '<h4 style="color: red;margin-bottom: 10px;">Something Going Wrong Please Cehck</h4>';	
						}
						
						
					}else{
						echo '<h4 style="margin-bottom: 10px;">Staff is allready added </h4>';
					}
					
				?>
		    </div>
		
    </div>
</div>