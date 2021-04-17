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
		}else{
			$changeStatus = 0;
		}
		
		
		$Update = mysql_query("UPDATE `staff_roster` SET `status` = '".$changeStatus."' WHERE `staff_id` = '".$staff_id."' and date='".$date."'");

			$staff_name = get_rs_value('admin',"name",$_SESSION['admin']);  
			$staffRoster = mysql_query("INSERT INTO `staff_roster_activity` (`staff_id`, `date`, `status`, `admin_id` ,`admin_name`, `type`) VALUES ('".$staff_id."', '".$date."','".$changeStatus."' ,'".$_SESSION['admin']."' ,'".$staff_name."' , 'Marked by admin')");
			
			$staffRoster1 = mysql_query("INSERT INTO `roster_activity` (`staff_id`, `ro_date`, `status`, `staff_type` ,`createdOn`, `admin_id`) VALUES ('".$staff_id."', '".$date."','".$changeStatus."' ,'2' ,'".$updatedOn."' , '".$_SESSION['admin']."')");
		
		if($Update){
		
		}else{
			//echo 0;
		} 
	}
	
?>