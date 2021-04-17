<?php 

	function add_email_notes($email_id,$email_msg_no,$mail_type,$heading,$comment){
	
		$customDate = date("Y-m-d H:i:s");
		//$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
		$staff_name = 'Email';
		
		$ins_arg="insert into email_notes set email_id=".$email_id.",";
		$ins_arg.=" date='".$customDate."',";
		$ins_arg.=" email_msg_no='".$email_msg_no."',";
		$ins_arg.=" mail_type='".$mail_type."',";
		$ins_arg.=" heading='".mysql_real_escape_string($heading)."',";
		$ins_arg.=" comment='".mysql_real_escape_string($comment)."',";
		$ins_arg.=" login_id='".$_SESSION['admin']."',";
		$ins_arg.=" staff_name='".$staff_name."'";
		//echo $ins_arg.'<br/>';  
		$ins = mysql_query($ins_arg);
	
    }


  function add_email_activity($email_id, $activitytext, $comment , $closetime =null , $p_id = 0){
	
		$time = date("Y-m-d H:i:s");
		
		if($closetime != '') {
		    
		     $closetime = $closetime;
		     
		}else{
		    $closetime = date('0000-00-00 00:00:00');;
		}
		
		
		$staff_id = $_SESSION['admin'];
		$staff_name = get_rs_value("admin","name",$staff_id);
		
		$ins_arg="insert into email_activity set email_id=".$email_id.",";
		$ins_arg.=" date_time='".$time."',";
// 		$ins_arg.=" email_type='".$email_type."',";
// 		$ins_arg.=" email_folder='".$email_folder."',";
		$ins_arg.=" open_time='".$time."',";
		$ins_arg.=" closed_time='".$closetime."',";
		$ins_arg.=" activity='".$activitytext."',";
		$ins_arg.=" p_id='".$p_id."',";
		$ins_arg.=" comment='".mysql_real_escape_string($comment)."',";
		$ins_arg.=" staff_id='".$staff_id."',";
		$ins_arg.=" staff_name='".$staff_name."'";
		//echo $ins_arg.'<br/>';  
		$ins = mysql_query($ins_arg);
	
    }

	function add_bcic_quote_emails($quoteid,$heading,$comment,$email,$email_id,$mailtype){
		
			 /*  var_dump($quoteid,$heading,$comment,$email,$email_id,$mailtype);
			  echo "<br/>"; */
		
		//$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
		$staff_name = 'Email';
		
		$ins_arg="insert into quote_emails set quote_id=".$quoteid.",";
		$ins_arg.=" quote_email='".mysql_real_escape_string($email)."',";
		$ins_arg.=" heading='".mysql_real_escape_string($heading)."',";
		$ins_arg.=" comment='".mysql_real_escape_string($comment)."',";
		$ins_arg.=" createdOn='".date("Y-m-d h:i:s")."',";
		$ins_arg.=" bcic_email_id='".$email_id."',";
		$ins_arg.=" mail_type='".$mailtype."',";
		$ins_arg.=" check_from='1',";
		$ins_arg.=" login_id='".$_SESSION['admin']."',";
		$ins_arg.=" staff_name='".$staff_name."'";
		/* echo $ins_arg;
		echo "<br />"; */
		$ins = mysql_query($ins_arg); 
		
	}

	function add_bcic_job_emails($job_id,$heading,$comment,$email,$email_id,$mailtype){

	 /*  var_dump($job_id,$heading,$comment,$email,$email_id,$mailtype);
	  echo "<br/>"; */
	
		 $customDate = date("Y-m-d H:i:s");
		//$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
		$staff_name = 'Email';
		
		$ins_arg="insert into job_emails set job_id=".$job_id.",";
		$ins_arg.=" date='".$customDate."',";
		$ins_arg.=" email='".mysql_real_escape_string($email)."',";
		$ins_arg.=" heading='".mysql_real_escape_string($heading)."',";
		$ins_arg.=" comment='".mysql_real_escape_string($comment)."',";
		$ins_arg.=" login_id='".$_SESSION['admin']."',";
		$ins_arg.=" check_from='1',";
		$ins_arg.=" bcic_email_id='".$email_id."',";
		$ins_arg.=" mail_type='".$mailtype."',";
		$ins_arg.=" staff_name='".$staff_name."'";
		//echo $ins_arg.'<br/>';
		$ins = mysql_query($ins_arg); 
		
	}
	
	function getEmailFolderName(){
		$arg = mysql_query("SELECT folder_name,icon, id FROM `email_folder` WHERE status = 1");
		$counter = mysql_num_rows($arg);
		if($counter >  0 ) {
			
			    while($getData = mysql_fetch_assoc($arg)) {
				    $getEmailFolder[$getData['icon']] = $getData['folder_name'];  
				    //$getEmailFolder['icon'] = $getData['icon'];  
			    }
		  return $getEmailFolder;		
		}else {
			return 0;
		}
	}			
	function totalEmailCount($cond) {	
           	$sql  =  "SELECT * FROM `bcic_email` where 1 = 1";			
			if($cond != '' ) {	
    			$sql .=  $cond;  	
			}		
			$sql; 	
			$arg = mysql_query($sql);		
			$totalCount = mysql_num_rows($arg);		
			return  $totalCount;	
	}	
	
	
	function checkblok_emails($emailid){
      
         $sql = mysql_query("SELECT id FROM `block_emails` WHERE email = '".$emailid."'");  
         $countblockemails = mysql_num_rows($sql); 
         return $countblockemails;
	    
	}
	
	
	
	function getTotalRecordofEmail($arg){
		
			$arg = mysql_query($arg);		
			$totalCount = mysql_num_rows($arg);		
			return  $totalCount;
	}
	
	function getJobIDByEmail($email_id){
		
		
		  $arg = mysql_query("SELECT job_id,email_status, quote_id , priority ,email_assign , admin_id ,move_to ,  email_category  FROM `bcic_email` WHERE `id` IN (".$email_id.")");
		  $totalCount = mysql_num_rows($arg);
		  while($getjobID = mysql_fetch_assoc($arg)) {
			  if($getjobID['job_id'] != 0) {
				  $jobid = $getjobID['job_id'];
			  }else {
				 $jobid = 0; 
			  }
			  
			  if($getjobID['quote_id'] != 0) {
				  $quote_id = $getjobID['quote_id'];
			  }else {
				 $quote_id = 0; 
			  }
			  
			  if($getjobID['priority'] != 0) {
				  $priority = $getjobID['priority'];
			  }else {
				 $priority = 0; 
			  }
			  
			  if($getjobID['email_assign'] != 0) {
				  $email_assign = $getjobID['email_assign'];
			  }else {
				 $email_assign = 0; 
			  }
			  
			  if($getjobID['admin_id'] != 0) {
				  $admin_id = $getjobID['admin_id'];
			  }else {
				 $admin_id = 0; 
			  }
			  
			  if($getjobID['email_category'] != 0) {
				  $email_category = $getjobID['email_category'];
			  }else {
				 $email_category = 0; 
			  }
			  
			   if($getjobID['email_status'] != 0) {
				  $email_status = $getjobID['email_status'];
			  }else {
				 $email_status = 0; 
			  }
			  
			   if($getjobID['move_to'] != 0) {
				  $move_to = $getjobID['move_to'];
			  }else {
				 $move_to = 0; 
			  }
		  }		  
		  return array('totalReco'=>$totalCount,'jobid'=>$jobid ,'quote_id'=>$quote_id, 'priority'=>$priority,'email_assign'=>$email_assign,'admin_id'=>$admin_id,'email_category'=>$email_category , 'move_to'=>$move_to, 'email_status'=>$email_status);
		
	}
	
	function checkLastActivity($email_id){
		$sql =   mysql_query("SELECT last_activity ,   last_activity_date  FROM `bcic_email` WHERE `id` IN ( ".$email_id." )  ORDER by last_activity_date desc LIMIT 0 , 1");
		
		// 1 = >reply , 2= >Forward
		$totalCount = mysql_num_rows($sql);
			if($totalCount > 0) {
				$getDetails = mysql_fetch_assoc($sql);
				$lastActivity =  $getDetails['last_activity'];
				      if($lastActivity == 1) {
						  $lastmailtype = '<i class="fa fa-reply"></i>';
						  $mailtype = "Reply";
						}else if($lastActivity == 2){
							 $lastmailtype = '<i class="fa fa-arrow-right"></i>';
							  $mailtype = "Forward";
						}elseif($lastActivity == 0) {
							 $lastmailtype = '';
							 $mailtype = "";
						}
				return array('lastmailtype'=>$lastmailtype, 'mailtype'=>$mailtype);		
				
			}else {
				return array('lastmailtype'=>'','mailtype'=>'');
			}
	}
	
	
	 function getactiveEmailid($email_type){
		 $arg  = mysql_query("SELECT user_email FROM `email_config` WHERE email_type ='".$email_type."'");
		 $getdata = mysql_fetch_array($arg);
		 return $getdata;
	 }
	 
	 
	 function getactiveEmailiddata($email_type){
		 $arg  = mysql_query("SELECT user_email , email_type FROM `email_config`");
		 while($getdata = mysql_fetch_array($arg)){
		     
		     $data[$getdata['email_type']] = $getdata['user_email'];
		 }
		  return $data;
	 }
	 
	 function getEmailIDbyemailtype($email_type){
		 //echo  "SELECT id FROM `email_config` WHERE email_type ='".$email_type."'" ; 
		 $arg  = mysql_query("SELECT id FROM `email_config` WHERE email_type ='".$email_type."'");		 
		 $getValue =  mysql_fetch_assoc($arg);
		 return $getValue['id'];
	 }
	 
	 
	 function getEmailIDbyemailtype111($email_type){
		 echo  "SELECT id FROM `email_config` WHERE email_type ='".$email_type."'" ; 
		/*  $arg  = mysql_query("SELECT id FROM `email_config` WHERE email_type ='".$email_type."'");		 
		 $getValue =  mysql_fetch_assoc($arg);
		 return $getValue['id']; */
	 }
	 
	    function getTotamailIds ($email_type = null , $getAlldata = null) {
				
                    $arg['id'] = getEmailIDbyemailtype($email_type);
					
					
				    $allidsSql = ("SELECT   GROUP_CONCAT(id) as totalid  FROM `bcic_email` WHERE ((email_from = '".$getAlldata['email_from']."' AND email_subject_reference = '".$getAlldata['email_subject_reference']."') OR email_reply_to = '".$getType	['user_email']."' AND email_subject_reference = '".$getAlldata['email_subject_reference']."' ) AND ( mail_type = '".$getAlldata['mail_type']."'");

				if($arg['id'] != '') {
				   $allidsSql .= "   OR move_to = ".$arg['id']."";
				}

				  $allidsSql .= " ) Order By email_date desc";

				    $getidSql  =mysql_query($allidsSql);
                    $value =  mysql_fetch_assoc($getidSql);
                return $value['totalid'];
		}	 
	
	 
	 function removeStripslashes($text){
		$text =   stripslashes($text);
		//$text = preg_replace("/<style\\b[^>]*>(.*?)<\\/style>/s", "", $text);
		//$remove_character = array("\n", "\r\n", "\r" , "rn");
		return   str_replace($remove_character , '' , $text);
	 }
	
	
    function getEmailConfig(){	
     	$sql = mysql_query( "SELECT * FROM `email_config` " );		
		$data = array();	   
		while($getData = mysql_fetch_assoc($sql)) {			
			$id = $getData['id'];		
			$name = $getData['name'];		
			$email_type = $getData['email_type'];		
			$result[] = array('id' => $id,'name' => $name,'email_type' => $email_type);		
		
		}		    
		return $result;			 
	}
	
	function setEmailTabbing(){	
     	$sql = mysql_query( "SELECT * FROM `system_dd` WHERE type = 50 AND id != 12 " );		
		$data = array();	   
		while($getData = mysql_fetch_assoc($sql)) {			
			$id = $getData['id'];		
			$name = $getData['name'];		
			$email_type = $getData['email_type'];		
			$result[] = array('id' => $id,'name' => $name,'email_type' => $email_type);		
		
		}		    
		return $result;			
	}
	
	function CheckJobANDQuoteID($field ,$value , $email_id ){
		
		// For Quote ID check 
		if($field == 'quote_id') {
			
		    $sqlargq = mysql_query("SELECT * FROM `quote_new` WHERE id = ".$value." AND deleted = 0");
			if(mysql_num_rows($sqlargq) >  0) {				
			
				$bcicSql =  mysql_query("SELECT id, mail_type , email_subject, email_body, email_from  FROM `bcic_email` WHERE `id` in( ".$email_id." ) ");				
				if(mysql_num_rows($bcicSql) > 0) {
				    while($getemailsdetails = mysql_fetch_assoc($bcicSql)) {
						
				      add_bcic_quote_emails($value,$getemailsdetails['email_subject'],removeStripslashes($getemailsdetails['email_body']),$getemailsdetails['email_from'],$getemailsdetails['id'],$getemailsdetails['mail_type']);
				    }
				}
			}	
	    }	
			// For job ID check 
		if($field == 'job_id'){
			
			$sqlargj = mysql_query("SELECT * FROM `jobs` WHERE id = ".$value."");
				if(mysql_num_rows($sqlargj) >  0) {
					
					
					$bcicSql1 =  mysql_query("SELECT id, mail_type , email_subject, email_body, email_from  FROM `bcic_email` WHERE `id` in( ".$email_id." ) ");
					if(mysql_num_rows($bcicSql1) > 0) {
						while($getemailsdetails = mysql_fetch_assoc($bcicSql1)) {
						  add_bcic_job_emails($value,$getemailsdetails['email_subject'],removeStripslashes($getemailsdetails['email_body']),$getemailsdetails['email_from'],$getemailsdetails['id'], $getemailsdetails['mail_type']);
					  }
					}
				}
		} 
	}
	
	function RemoveQuoteAndJobEmails($fields , $ids){
		
		if($fields == 'quote_id') {
			if($ids != '') {
				//echo  "delete from quote_emails where bcic_email_id in (".$ids.")";
			  $bool =  mysql_query("delete from quote_emails where bcic_email_id in (".$ids.")");
			}
		}
		
		if($fields == 'job_id') {
			if($ids != '') {
			    $bool =  mysql_query("delete from job_emails where bcic_email_id in (".$ids.")");
			}
		}		
	}	
	
	
	function format_size($size) {
			  $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
			  if ($size == 0) { return('n/a'); } else {
			  return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]); }
        }
        
    function getnext_privids($mail_details_id){
		
		
			 $getemail_details = mysql_fetch_assoc(mysql_query("SELECT email_from , mail_type,email_subject_reference  , folder_type FROM `bcic_email` WHERE `id` = ".$mail_details_id.""));
		
		$getType1 = getactiveEmailid($getemail_details['mail_type']);
							
							$getidSql = mysql_query("
								SELECT 
									GROUP_CONCAT(id) as totalid  
								FROM 
									`bcic_email` 
								WHERE 
							(
									(email_from = '".$getemail_details['email_from']."' AND email_subject_reference = '".mysql_real_escape_string($getemail_details['email_subject_reference'])."') 
								OR 
									email_reply_to = '".$getType1['user_email']."' AND email_subject_reference = '".mysql_real_escape_string($getemail_details['email_subject_reference'])."') AND mail_type = '".$getemail_details['mail_type']."' AND is_delete = 0 Order By email_date desc"
							);
	
							$getallCOuntid = mysql_fetch_assoc($getidSql);
							
						$next = ($mail_details_id + 1);
						$priv = ($mail_details_id - 1);	
						$totalids =  ($getallCOuntid['totalid']);
						
					$results = array('next'=>$next , 'priv'=>$priv , 'totalids'=>$totalids , 'mail_type'=>$getemail_details['mail_type']);
					return $results;
	}    
?>