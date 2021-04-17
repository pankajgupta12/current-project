<?php  
 include("../source/functions/functions.php");
include("../source/functions/config.php");
 print_r($_POST);
  if($_POST['id'] && $_POST['month'] && $_POST['year'] != '') {
	  
		$staff_id = mysql_real_escape_string($_POST['id']);
		$month = mysql_real_escape_string($_POST['month']);
		$year = mysql_real_escape_string($_POST['year']);
		
		 
		 
		$sql  = mysql_query("SELECT * FROM staff_roster   WHERE MONTH(date) = '".$month."' AND YEAR(date) = '".$year."' AND staff_id = ".$staff_id);
		$numCount = mysql_num_rows($sql);
		 
		
		if(mysql_num_rows($sql) == 0) 
			{
				//SELECT * FROM `staff` where id = 75
		       $avaibilityQuery = 	mysql_query("SELECT avaibility FROM `staff` where id = ".$staff_id);	
			   $getdata = mysql_fetch_array($avaibilityQuery);
			    //$avaibility = get_sql("staff","avaibility","where id ='".$staff_id);
				//echo $getdata['avaibility']; die;
				$getdateInarray = explode(',' , ($getdata['avaibility']));
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
							//$checkday = '0';
						if(in_array($checkday1 , $getdate)) { $checkday =  "1"; }else {$checkday = '0';}	
				
						$staffRoster = mysql_query("INSERT INTO `staff_roster` (`staff_id`, `date`, `status`) VALUES ('".$staff_id."', '".$date."','".$checkday."')");
				
					}
					
			}else{
				
				$avaibilityQuery = 	mysql_query("SELECT avaibility FROM `staff` where id = ".$staff_id);	
			    $getdata = mysql_fetch_array($avaibilityQuery);
				//$avaibility = get_sql("staff","avaibility","where id ='".$staff_id);
				//echo $getdata['avaibility']; die;
				$getdateInarray = explode(',' , ($getdata['avaibility']));
				$getdate = array();
								
				if( count( $getdateInarray ) > 0 ) :
					
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
							//$checkday = '0';
						    if(in_array($checkday1 , $getdate)) { $checkday =  "1"; }else {$checkday = '0';}	
								
	                       $getsql  = mysql_query("SELECT * FROM staff_roster   WHERE date = '".$date."' AND staff_id = '".$staff_id."' And status = '1'");
					
     					if(mysql_num_rows($getsql) == 0){
						
	                                       $staffRoster = mysql_query("update `staff_roster` SET status ='0'  WHERE date = '".$date."' AND staff_id = ".$staff_id);
						
                                 }
						
					}
					
				endif;
				
			} 
    }
	
	

?>

