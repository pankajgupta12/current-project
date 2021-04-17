<?php  
    include("../source/functions/functions.php");
    include("../source/functions/config.php");
	
    if($_POST['id'] != '') {
	     
      	$ins_arg = "update  admin_roster set ";
		$ins_arg .= " start_time_au='" . mysql_real_escape_string($_POST['start_time_au']) . "',";
		$ins_arg .= " end_time_au='" . mysql_real_escape_string($_POST['end_time_au']) . "',";
		$ins_arg .= " lunch_time_au='" . mysql_real_escape_string($_POST['lunch_time_au']) . "',";
		$ins_arg .= " lunch_end_time_au='" . mysql_real_escape_string($_POST['lunch_end_time_au']) ."',";
		$ins_arg .= " leave_type='" . mysql_real_escape_string($_POST['leave_type']) ."',";
		$ins_arg .= " roster_type='" . mysql_real_escape_string($_POST['updateroster']) ."'";
		$ins_arg .= " where id ='" . mysql_real_escape_string($_POST['id']) . "' ";  
		
	//	echo $ins_arg; 
		
		$bool = mysql_query($ins_arg);
		
		if($bool) {
			echo 1;
		}else{
			echo 0;
		}
		
    } 
	
?>
                                