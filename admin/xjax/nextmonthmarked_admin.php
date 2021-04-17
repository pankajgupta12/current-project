<?php  
 include("../source/functions/functions.php");
include("../source/functions/config.php");
 //print_r($_POST);
  if($_POST['id'] && $_POST['month'] && $_POST['year'] != '') {
	  
		$admin_id = mysql_real_escape_string($_POST['id']);
		$month = mysql_real_escape_string($_POST['month']);
		$year = mysql_real_escape_string($_POST['year']);
		
		 
		 
		$sql  = mysql_query("SELECT * FROM admin_roster   WHERE MONTH(date) = '".$month."' AND YEAR(date) = '".$year."' AND admin_id = ".$admin_id);
		$numCount = mysql_num_rows($sql);
		
		        $getdateInarray = WEEK_DAYS_ARRAY;
				$rosterdata = getdefualRoster($admin_id, $getdateInarray);
	//	echo mysql_num_rows($sql);
		if(mysql_num_rows($sql) == 0) 
			{
				
				
				//$getdateInarray = explode(',' , ($getdata['avaibility']));
				$getdate = array();

				foreach($getdateInarray as $value) {
				  $getdate[] =  substr($value,0,3);
				}  	
			  //print_r($getdate); die;	
				$numberday=cal_days_in_month(CAL_GREGORIAN,date($month),date($year));
				
				for($d=1; $d<=$numberday; $d++)
					{
							$time=mktime(12, 0, 0, date($month), $d, date($year));
							if (date($month, $time)==date($month))
							$date = date('Y-m-d', $time);
							$checkday1= date('D', $time);
							$day = date('D', $time);
							$checkday= date('l', $time);
							
							//$checkday = '0';
						//$checkStaffRosterID = mysql_query("Select id  from admin_roster where  date ='" . $date ."' AND admin_id = {$admin_id}"); 

/*						$status = 0;
						if($rosterdata[$checkday]['start_time_au'] != 0) {
						$status = 1;
						}*/
						
			    	$status = $rosterdata[$checkday]['start_time_au'];
				
				      $sql = mysql_query("INSERT INTO `admin_roster`  (`admin_id`, `date`, `status` , `start_time_au`, `end_time_au`, `lunch_time_au`, `lunch_end_time_au`, `createdOn`)  VALUES   (".$admin_id.",  '".$date."',".$status." , ".$rosterdata[$checkday]['start_time_au'].", ".$rosterdata[$checkday]['end_time_au'].", ".$rosterdata[$checkday]['lunch_time_au'].", ".$rosterdata[$checkday]['lunch_end_time_au'].",'".$createdOn."')"); 
					  
						/* $staffRoster = mysql_query("INSERT INTO `admin_roster` (`admin_id`, `date`, `status`) VALUES ('".$admin_id."', '".$date."','".$checkday."')"); */
				
					}
					
			}else{
				
			
				$getdate = array();
				
								
				if( count( $getdateInarray ) > 0 ) {
					
					foreach($getdateInarray as $value) {
					  $getdate[] =  substr($value,0,3);
					}  	
					
					$numberday=cal_days_in_month(CAL_GREGORIAN,date($month),date($year));
					
					
					for($d=1; $d<=$numberday; $d++)
					{
						
						$statuscheck = 0;
						
							$time=mktime(12, 0, 0, date($month), $d, date($year));
							if (date($month, $time)==date($month))
							$date = date('Y-m-d', $time);
							$checkday1= date('D', $time);
							$day = date('D', $time);
							$checkday= date('l', $time);
							//$checkday = '0';
						/*	$status = 0;
							if($rosterdata[$checkday]['start_time_au'] != 0) {
							   $status = 1;
							}	*/
						$status = $rosterdata[$checkday]['start_time_au'];			
	                      $checkStaffRosterID = mysql_query("UPDATE `admin_roster` SET `start_time_au` = '".$rosterdata[$checkday]['start_time_au']."' , `status`=".$status." , `end_time_au` = '".$rosterdata[$checkday]['end_time_au']."' , `lunch_time_au` = '".$rosterdata[$checkday]['end_time_au']."' , `lunch_end_time_au` = '".$rosterdata[$checkday]['lunch_time_au']."'  WHERE `date` = '".$date."' AND admin_id = {$admin_id}"); 
					 
					  /*echo mysql_num_rows($checkStaffRosterID); 
     					        if(mysql_num_rows($checkStaffRosterID) == 0){
						
	                                   echo  $sql = ("UPDATE `admin_roster` SET `start_time_au` = '".$rosterdata[$checkday]['start_time_au']."' , `status`=".$status." , `end_time_au` = '".$rosterdata[$checkday]['end_time_au']."' , `lunch_time_au` = '".$rosterdata[$checkday]['end_time_au']."' , `lunch_end_time_au` = '".$rosterdata[$checkday]['lunch_time_au']."'  WHERE `date` = '".$date."' AND admin_id = {$admin_id}");
						
                                }*/
						
					}
					
				}
				
			} 
    }
	
	

?>

