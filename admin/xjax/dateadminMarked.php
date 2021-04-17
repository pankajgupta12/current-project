<?php  
include("../source/functions/functions.php");
include("../source/functions/config.php");

    if($_GET['id'] && $_GET['id'] != '') 
	{
        $staff_id = mysql_real_escape_string($_GET['id']);
		$date = $_GET['date'];
		$status = $_GET['status'];
		$updatedOn = date('Y-m-d H:m:s');
		
		
		if($status == 0) {
			$changeStatus = 1;
			$start_time_au = '2';
			$end_time_au = '2';
			$lunch_time_au = '2';
			$lunch_end_time_au = '2';

		}else{
			$changeStatus = 0;
			$start_time_au = '0';
			$end_time_au = '0';
			$lunch_time_au = '0';
			$lunch_end_time_au = '0';
		}
		
		$Updatesql = ("UPDATE `admin_roster` SET `status` = '".$changeStatus."' , `start_time_au`= ".$start_time_au.",`end_time_au`= ".$end_time_au.",`lunch_time_au`= ".$lunch_time_au.",`lunch_end_time_au`= ".$lunch_end_time_au." WHERE `admin_id` = '".$staff_id."' and date='".$date."'");
		//echo  $Updatesql;
		
	    $bool = mysql_query($Updatesql);
		if($Update){
		
		}else{
			//echo 0;
		} 
	}
	
?>