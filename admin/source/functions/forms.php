<?php

function check_form($fields_name,$fields_validation,$fields_heading){
	$x=0;
$formreq="";
$_SESSION['query[error]'] = 0;
$_SESSION['query[txt]'] = "";
//$no_rec = count($fields_name);

	foreach ($fields_name as $valuex) {
			if ($fields_validation[$x]==1){
			$formdata[$valuex] = mysql_real_escape_string(trim($_POST[$valuex]));
			//echome(" $x : $valuex >> $formdata[$valuex]<br>");
		
					if ($formreq==""){
						$formreq .=$valuex."|".$fields_heading[$x]."|";
					}else{
						$formreq .=$valuex."|".$fields_heading[$x]."|";
					}
			}
			$x++;			
}
	

$formreq = substr($formreq, 0, -1);
//echo $formreq."<br>";

	If(validateform($formdata,$formreq) != 1){
		//$query[error] = 1;
		//$query[txt] = validateform($formdata,$formreq);
			$_SESSION['query[error]'] = 1;
			$_SESSION['query[txt]'] = validateform($formdata,$formreq);
			$step=1;
	}else{
		$step=2;
	}

return $step;
}

function validateform($formdata,$formfields) {
	$arg = "";
	$r = 0;
	$continue=0;
	$formfields = explode("|",$formfields);
	While($r < count($formfields)){
		$checkfield = $formfields[$r];
		If($formdata[$checkfield] == "" || $formdata[$checkfield] == "Select"){
			$continue = "-1";
			$arg .= "&nbsp;&nbsp;- Please Fill out ".$formfields[$r+1].".<BR>";
		}
		
		if($formfields[$r]=="email" && $formdata[$checkfield] != ""){
			/*$check_email=validateemail($formdata[$checkfield]);
			echo "validateemail($formdata[$checkfield])";
			echo $check_email;
			if($check_email!=""){
				$continue = "-1";
				$arg .= "&nbsp;&nbsp;- Invalid Email Address ".$formfields[$r+1].".<BR>";
			}*/ 
			$email_address=$formdata[$checkfield];
			$pos = strpos($email_address,".ru ");
			//echo "we are in".$pos;
			if($pos>0){ 
				$continue = "-1";
				$arg .= "Invalid email address used!";
			}else{
			
				if((preg_match('/(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/', $formdata[$checkfield])) || (preg_match('/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/',$formdata[$checkfield]))){ 
				  $host = explode('@', $formdata[$checkfield]); 
				  if(checkdnsrr($host[1], 'MX')){
					//$continue=0;
				  }Else if( checkdnsrr($host[1], 'A')){
					//$continue=0;
				  }Else if( checkdnsrr($host[1], 'CNAME')){
					//$continue=0;
				  }Else{
					$continue = "-1";
					$arg .= "Server could not be found for specified E-Mail Address!";
				  }			
				}Else{
					$continue = "-1";
					$arg .= "Invalid email address used!";
				  }
			}


		}
	  
		$r=$r+2;
	}

	If($continue == "-1"){
		$arg = "The form was not filled out properly!<br>$arg\n";
	}Else{
		$arg = 1;
	}
	
	return $arg;
}
  
  
  
  
 function modify_form($fields_name,$fields_add,$fields_dtype,$table,$id,$f_filed_desc = null){	
	
	$d=0;	
	
	 $arg="update $table set ";
	$outerFlag = false;
	
	//print_r($_POST); die;
	
	//update table set field=value,field=value where id=$id
	foreach ($fields_name as $key => $value) {
	    
	    //echo $fields_dtype[$d];
	    
		if ($fields_add[$d]){
			 $arg.=" `".$value."`=";
				if ($fields_dtype[$d]==1){
					
					if($f_filed_desc[$key] == '[]')
					{
						//echo 	$fieldname =  $value.$f_filed_desc[$key]."<br>";
						$arg.= "'".implode(',' , ($_POST[$value]))."',";
						
						//to check for avaibility of days arra. Make it into string after implode
						if( (isset( $_POST['avil'] ) && $_POST['avil'] == 'checkavil') && ( $outerFlag  == false ) )
						{
							//print_r($_POST);
							
							$weekDay = implode(',' , ($_POST['avaibility']));
							
							//echo $weekDay; die;
							if($table == 'staff' && $_POST['task'] == 4) {
							    MakeRosterForm($weekDay,$id);
							}
							/* else if($table == 'admin' && $_POST['task'] == 21) {
								MakeadminRosterForm($weekDay,$id);
							} */
							$outerFlag = true;
						}
						
						
						
						if( !empty( $_POST['amt_share_type'])) 
							{
								$a1 = $_POST['shear_value_per'];
								$a2 = $_POST['shear_value_fixed'];
								//$a3 = $_POST['check_value'];
								
								foreach($a1 as $key=>$value) {
										if($value != '') {
										// 1 used For % sing	
										 $aga1[$key] = '1_'.$value;
										}else {
											// 2 used For Fixed
										 $aga1[$key] = '2_'.$a2[$key];
										}
								}
								MakeStaffshareamount($aga1,$id);
					    	} 
					
					}else if($f_filed_desc[$key] == ''){
					    
    					     if( $value == 'mobile' )
    			    {
    			        $_POST[$value] = str_replace(' ','',$_POST[$value]); 
    			    }
					    
						$arg.="'".mysql_real_escape_string($_POST[$value])."',";
						
					}else{
						$arg.=mysql_real_escape_string($_POST[$value]).",";
					}
				}
		}
		$d++;
	}
	
	
	 
	
		//die;
		$arg = substr($arg, 0, -1);
		
		if($table == 'staff' && $_POST['task'] == 4) {
			
			$srge =  $arg .', `admin_id` = '.$_SESSION['admin'].''; 
			
			//echo $srge; die;
			
		  $query_value = str_replace('update staff set ','insert into   staff_activity set ',$srge);
		  Staffactivity($query_value , $_POST);
	    }
		
		 // echo $arg; die;
		
		$arg=$arg." where id=$id";
		//echo ($arg); die;
		//echo "e <a href=\"javascript:show_div('".time()."')\">.</a><div id=\"".time()."\" style=\"display:none;\">".$arg."</div>";
		$insert = mysql_query($arg);
		   if($table == 'site_time_slot'){
				call_schedule_report_schedule_time($id);
			}
			if($table == 'staff' && $_POST['task'] == 4) {
			   AddstaFixedRates($id);
		    }
			
			if($table == 'admin') {
			   getUniqueAPIKey($id);
		    }
    }

	/*
	
		$cond['currentCalender'] = 'getDate' //for Next
	
	*/
	
	function Staffactivity($query , $postData){  
	    
	     $postData['admin_id'] = $_SESSION['admin'];
	     $postData['updatedDate'] = date('Y-m-d H:i:s');
	     
	     $alldata = serialize($postData);
	     
	     $query = "INSERT INTO `staff_activity_latest` (`staff_id`, `admin_id`, `udatedOn`, `all_data`) VALUES ('".$postData['id']."', '".$postData['admin_id']."', '".$postData['updatedDate']."', '".$alldata."')";
	     //echo '<pre>';  print_r($postData); die;
	      //echo $query;
		 mysql_query($query);
	}
	
	function MakeadminRosterForm($alldata = null , $id= null , $cond = null){
		
		 //echo ($alldata);
		$getdateInarray = explode(',' , ($alldata));
		$getdate = array();
	 
	    foreach($getdateInarray as $value) {
	      $getdate[] =  substr($value,0,3);
	    } 
		
		//print_r($getdate);
		
		$numberday=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
		
		$monthRequest = $_REQUEST['month'];
		
		
		for($d=1; $d<=$numberday; $d++)
		{
				$time=mktime(12, 0, 0, date('m'), $d, date('Y'));
				if (date('m', $time)==date('m'))
				$date = date('Y-m-d', $time);
				$checkday1= date('D', $time);
				$day = date('D', $time);
				//echo $date; die;
			if(in_array($checkday1 , $getdate)) { $checkday =  "1"; }else {$checkday = '0';}
			
			
			 $checkStaffRosterID = mysql_query("Select count(id) as Staff_date from admin_roster where  date ='" . $date ."' AND admin_id = {$id}"); 
			
			$countRecord = 	mysql_fetch_object($checkStaffRosterID);
			//echo $countRecord;
			
			if($countRecord->Staff_date > 0)
			{
				$staffRoster = ("UPDATE `admin_roster` SET `status` = '".$checkday."' WHERE `date` = '".$date."' AND admin_id = {$id}");
			}
			else
			{					
			
				$staffRoster = ("INSERT INTO `admin_roster` (`admin_id`, `date`, `status`) VALUES ('".$id."', '".$date."','".$checkday."')");
			}
              mysql_query($staffRoster);			
			  
	    } 
		
	}
	
    function MakeRosterForm($alldata = null , $id= null , $cond = null)
	{
		
		//echo ($alldata);
		$getdateInarray = explode(',' , ($alldata));
		$getdate = array();
	 
	    foreach($getdateInarray as $value) {
	      $getdate[] =  substr($value,0,3);
	    } 
		
		//print_r($getdate);
		
		$numberday=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
		
		$monthRequest = $_REQUEST['month'];
		
		/*$str .= "SELECT ";
		$str .= " * ";
		$str .= " FROM ";
		$str .= " staff_roster ";		
		$str .= " WHERE 1 = 1 ";
		$str .= " AND ";
		$str .= " MONTH( DATE_FORMAT(date,'Y-m-d') ) = 04 AND ";
		$str .= " YEAR( DATE_FORMAT(date,'Y-m-d') ) = 2017 AND ";
		$str .= " staff_id = {$id} ";
		
		echo $str;
		exit;*/
		
		for($d=1; $d<=$numberday; $d++)
		{
				$time=mktime(12, 0, 0, date('m'), $d, date('Y'));
				if (date('m', $time)==date('m'))
				$date = date('Y-m-d', $time);
				$checkday1= date('D', $time);
				$day = date('D', $time);
				//echo $date; die;
			if(in_array($checkday1 , $getdate)) { $checkday =  "1"; }else {$checkday = '0';}
			
			
			 $checkStaffRosterID = mysql_query("Select count(id) as Staff_date from staff_roster where  date ='" . $date ."' AND staff_id = {$id}"); 
			
			$countRecord = 	mysql_fetch_object($checkStaffRosterID);
			//echo $countRecord;
			
			if($countRecord->Staff_date > 0)
			{
				$staffRoster = ("UPDATE `staff_roster` SET `status` = '".$checkday."' WHERE `date` = '".$date."' AND staff_id = {$id}");
			}
			else
			{					
			
				$staffRoster = ("INSERT INTO `staff_roster` (`staff_id`, `date`, `status`) VALUES ('".$id."', '".$date."','".$checkday."')");
			}
              mysql_query($staffRoster);			
			  
			  
            $staff_name = get_rs_value('admin',"name",$_SESSION['admin']);  
			$staffRoster = mysql_query("INSERT INTO `staff_roster_activity` (`staff_id`, `date`, `status`, `admin_id` ,`admin_name`, `type`) VALUES ('".$id."', '".$date."','".$checkday."' ,'".$_SESSION['admin']."' ,'".$staff_name."' , 'admin')");
	    } 
	}
 
    /* function MakeRosterForm($alldata = null,$id= null){
	     // echo ($alldata); die;
	     $getdateInarray = explode(',' , ($alldata));
		
		 $getdate = array();
	 
	    foreach($getdateInarray as $value) {
	      $getdate[] =  substr($value,0,3);
	    } 
		
		$makeWeekDayStr = implode(',',$getdate);
		
		 $numberday=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
		for($d=1; $d<=$numberday; $d++)
		{
				$time=mktime(12, 0, 0, date('m'), $d, date('Y'));
				if (date('m', $time)==date('m'))
				$date[] = date('m-d-Y', $time);
				$checkday1= date('D', $time);
				$day[] = date('D', $time);
			if(in_array($checkday1 , $getdate)) { $checkday[] =  "1"; }else {$checkday[] = '0';}
			
			//echo implode(',')
		}
		  $date1 = implode(',',$date);
		  $dayName = implode(',',$day);
		  $checkday11 = implode(',',$checkday);
		
		$checkStaffRosterID = mysql_query("Select * from staff_roster where staff_id=".$id); 
		// $countRecord = mysql_num_rows($checkStaffRosterID); die;
		if(mysql_num_rows($checkStaffRosterID)>0){
			
		  	 $delete  = mysql_query("delete from staff_roster where staff_id=".$id);
			$staffRoster = mysql_query("INSERT INTO `staff_roster` (`staff_id`, `date`, `day_name`, `status`,`staff_selected`) VALUES ('".$id."', '".$date1."','".$dayName."', '".$checkday11."','".$makeWeekDayStr."')");
			
		}else {
			 $staffRoster = mysql_query("INSERT INTO `staff_roster` (`staff_id`, `date`, `day_name`, `status`,`staff_selected`) VALUES ('".$id."', '".$date1."','".$dayName."', '".$checkday11."','".$makeWeekDayStr."')");
		}
		return $staffRoster; 
		
    }  */
 
function insert_form($fields_name,$fields_dtype,$table,$fields_add,$f_filed_desc = null){
    
   //echo "<pre>"; print_r($_POST); die;
	$d=0;	
	$staff_rates_falg = 0;
	$arg="INSERT INTO $table (";
	$arg_val="values (";
	
	//echo '<pre>'; print_r($fields_name); die;

	foreach ($fields_name as $key => $value) {
	    
		if ($fields_add[$d]==1){
			$arg.="`".$value."`,";
			
			/* echo $_POST[$value].''. $f_filed_desc[$key];
			echo '<br>';  */
			
			if($f_filed_desc[$key] == '[]')
			{
				
				 $arg_val.= "'".implode(',' , ($_POST[$value]))."',";
				
				//to check for avaibility of days arra. Make it into string after implode
				if( (isset( $_POST['avil'] ) && $_POST['avil'] == 'checkavil') && ( $outerFlag  == false ) )
				{
					//$weekDay = implode(',' , ($_POST[$value]));
                    $weekDay = implode(',' , ($_POST['avaibility']));					
					$outerFlag = true;
				}
				
				if( !empty( $_POST['amt_share_type'])) 
				{	
					
					$a1 = $_POST['shear_value_per'];
					$a2 = $_POST['shear_value_fixed'];
					//$a3 = $_POST['check_value'];
					
					foreach($a1 as $key=>$value) {
						
						
							if($value != '') {
							// 1 used For % sing	
							 $aga1[$key] = '1_'.$value;
							}else {
								// 2 used For Fixed
							 $aga1[$key] = '2_'.$a2[$key];
							}
					}
				} 
				
				/* if( !empty( $_POST['permission'])) 
				{
					 $permission = "'".implode(',' , ($_POST['permission']))."'";
				} */
				
			}else if($f_filed_desc[$key] == ''){
			    
			    if( $value == 'mobile' )
			    {
			        $_POST[$value] = str_replace(' ','',$_POST[$value]); 
			    }
				$arg_val.="'".mysql_real_escape_string($_POST[$value])."',";
			}else{
			    
				$arg_val.=mysql_real_escape_string($_POST[$value]).",";
			}
			$d++;
		}else{
			$d++;
		}
	}
	
	//echo $arg; die;
	
	$arg = substr($arg, 0, -1);
	$arg .=") ";
	$arg_val = substr($arg_val, 0, -1);
	$arg_val .=")";
	
	$arg=$arg.$arg_val;
	 
	//echo "e <a href=\"javascript:show_div('".time()."')\">.</a><div id=\"".time()."\" style=\"display:none;\">".$arg."</div>";
	//die();
	$insert = mysql_query($arg);
	$insertId =  mysql_insert_id();
	
	if( $insertId > 0 )
	{
	     if($table == 'staff') {
	      	MakeRosterForm( $weekDay , $insertId );	
	      	MakeStaffshareamount($aga1,$insertId);
	     }
		 
		 /* if($table == 'admin') {
	      	MakeadminRosterForm( $weekDay , $insertId );	
	     }
		 */
		 
		if($table == 'site_time_slot'){
			call_schedule_report_schedule_time($insertId);
		}
		
		if($table == 're_company' || $table  == 're_company_agents') {
		   getUpdateTImeAdmin($insertId , $table);
		}
		
		//getStaffDetails($insertId,$table);
		/* echo $staff_rates_falg .'== 1 && '.$table.' == staff';
		
		die; */
		//echo $table .'== staff'; die;
		if($table == 'staff') {
			AddstaFixedRates($insertId);
		}
		if($table == 'admin') {
			getUniqueAPIKey($insertId);
		}
	}
	
	return $insert;
}

    function getUpdateTImeAdmin($id , $table){
        if($id > 0) {
          mysql_query("UPDATE $table SET `admin_id` = '".$_SESSION['admin']."' , createdOn = '".date('Y-m-d H:i:s')."' WHERE id = ".$id."");
		}
    }

    function getUniqueAPIKey($id){
		$apikey =  get_rs_value("admin","apikey",$id);
		
	    if($apikey == '') {	
          $key = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));
	       mysql_query("UPDATE `admin` SET `apikey` = '".$key."' , created_date = '".date('Y-m-d H:i:s')."' WHERE id = ".$id."");
	    }
    }

    function call_schedule_report_schedule_time($insertId){
		
		 $sql = mysql_query("SELECT * FROM `site_time_slot` WHERE id = ".$insertId."");
			if(mysql_num_rows($sql) > 0) {
			   $getdata = mysql_fetch_array($sql);
				
				$schedule_time = $getdata['slot_from'].'-'.$getdata['slot_to'];
				$mysqlUpdate = mysql_query("update site_time_slot set schedule_time = '".($schedule_time)."'  where id=".$insertId);
			}
	}
	
	
	function AddstaFixedRates($id){
		
		//echo 'sdsd';
		$site_id1 =  get_rs_value("staff","site_id",$id);
		if($site_id1 == 6) { $site_id = 6; }else{ $site_id = 0; }
		$sqlrates = mysql_query("SELECT * FROM `staff_fixed_rates` where status = 1 AND site_id = ".$site_id."");
				if(mysql_num_rows($sqlrates) > 0) {
					
					$arraydata = array();
					mysql_query("delete from  `staff_rates`  where staff_id = '".$id ."'");
				  $arg = "INSERT INTO `staff_rates` (`id` , `bed`, `bath`, `living`, `study`, `amount`,  `full_amount` , `staff_id`, `site_id` , `createdOn`) VALUES ";	
				  
					while($getrates = mysql_fetch_assoc($sqlrates)) {	
					
					  $arg.= "   (Null ,'".$getrates['bed']."', '".$getrates['bath']."', '".$getrates['living']."', '".$getrates['study']."','".$getrates['amount']."', '".$getrates['full_amount']."' , '".$id."',  '".$site_id1."' , '".date('Y-m-d H:i:s')."'),";
					  
					  $arraydata[] = array(
					         'id' => $getrates['id'],
					         'bed' => $getrates['bed'],
					         'bath' => $getrates['bath'],
					         'living' => $getrates['living'],
					         'study' => $getrates['study'],
					         'full_amount' => $getrates['full_amount'],
					         'amount' => $getrates['amount'],
							 'site_id' => $site_id1
					         );
					}
					
						$arg = rtrim($arg,",");	
						
						//echo $arg;
						mysql_query($arg);
						mysql_query(str_replace('staff_rates' , 'staff_rates_activity' ,$arg));
					
					
					//echo json_encode($arraydata);
					
					$mysqlUpdate = mysql_query("update staff set staff_fixed_rates = '".json_encode($arraydata)."'  where id=".$id); 
				}
	}

function MakeStaffshareamount($aga1,$insertId) {
		
		//print_r($aga1); die;
		  $value11 = array_keys($aga1);
		   //$getjobid = get_rs_value("staff","amt_share_type",$insertId);
		   
		   foreach($value11 as $value){
			   $getkeyvalue[] = $value;
		   }
		   
		   $keyvalue = implode(',',$getkeyvalue);
		   //echo $keyvalue; die;
		   $date = date('Y-m-d h:i:s');
		  // echo $getjobid; die;
		  $getJobType = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(name) as jobname FROM `job_type` where id in (".$keyvalue.")"));
		  
		  
		 // print_r($getJobType); die;
		  
		  
		  $mysqlUpdate = mysql_query("update staff set job_types = '".($getJobType['jobname'])."'  where id=".$insertId);
		  
		  $getstaffshareid = mysql_query("Select count(id) as staffshareid from staff_share_amount where  staff_id ='" . $insertId ."'"); 
		    $countRecord = 	mysql_fetch_object($getstaffshareid);
			$adminID = $_SESSION['admin'];
			if($countRecord->staffshareid > 0) {
				mysql_query("delete from  `staff_share_amount`  where staff_id = '".$insertId ."'");
				
				 // echo "affected";
				foreach($aga1 as $key=>$value) {
						$arrayvalue = explode('_',$value);
						
						if($arrayvalue[1] == '') {
							$amt_share_type =  get_rs_value("job_type","amt_share_type",$key);
							$sharevalue =  get_rs_value("job_type","value",$key);
						}else {
							$amt_share_type = $arrayvalue[0]; // share Type
							$sharevalue = $arrayvalue[1]; // value
						}
						
					 mysql_query("INSERT INTO `staff_share_amount` (`staff_id`, `job_type_id`, `amount_share_type`, `value`, `admin_id`, `createdOn`) VALUES ('".$insertId."', '".$key."', '".$amt_share_type."', '".$sharevalue."', '".$adminID."', '".$date."')");
					 
					 mysql_query("INSERT INTO `staff_share_amount_activity` (`staff_id`, `job_type_id`, `amount_share_type`,  `value`,`admin_id`,  `createdOn`) VALUES ('".$insertId."', '".$key."', '".$amt_share_type."', '".$sharevalue."',  '".$adminID."', '".$date."')");
				}   
				
			}else{
				foreach($aga1 as $key=>$value) {
					$arrayvalue = explode('_',$value);
					
			            if($arrayvalue[1] == '') {
							$amt_share_type =  get_rs_value("job_type","amt_share_type",$key);
							$sharevalue =  get_rs_value("job_type","value",$key);
						}else {
							$amt_share_type = $arrayvalue[0]; // share Type
							$sharevalue = $arrayvalue[1]; // value
						}
				 mysql_query("INSERT INTO `staff_share_amount` (`staff_id`, `job_type_id`, `amount_share_type`, `value`, `admin_id`, `createdOn`) VALUES ('".$insertId."', '".$key."', '".$amt_share_type."', '".$sharevalue."', '".$adminID."', '".$date."')");
				 
				 mysql_query("INSERT INTO `staff_share_amount_activity` (`staff_id`, `job_type_id`, `amount_share_type`,  `value`, `admin_id`, `createdOn`) VALUES ('".$insertId."', '".$key."', '".$amt_share_type."', '".$sharevalue."', '".$adminID."', '".$date."')");
				}  
			}
	}


function getStaffDetails($staffid,$table){
	if($table == 'staff') {
	  $staff_mobile = str_replace(' ','',(get_rs_value($table,"mobile",$staffid)));  
	  $mysqlUpdate = mysql_query("update $table set mobile2 = '".trim($staff_mobile)."'  where id=".$staffid);
	}
}

function error($error_msg) {
	$message = "
	<center>
	<p><font face=Verdana Color=#FF6633 Size=2><B> $error_msg </B></font></p>
	</center>
	";

	return $message;
}
   // Check CheckBox
	function checkedCheckBox($arrayData,$value){
		// print$arrayData.$value;
		if (in_array($arrayData, $value)) { $checked =  "checked";}else { $checked = "";}
		return $checked;
	}  

// Display Notification
function notify($notify_msg) {
	$message = "
	<center>
	<p><font face=Verdana Color=#3366CC Size=2><B> $notify_msg </B></font></p>
	</center>
	";

	return $message;
}
?>