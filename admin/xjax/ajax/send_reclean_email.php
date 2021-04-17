<?php 

//print_r($_POST);
session_start();
include("../../source/functions/functions.php");
include("../../source/functions/config.php");

if($_POST['type'] == 'reclen') {
  //$vars = explode('|',$str);
		
		$job_id  = mysql_real_escape_string($_POST['job_id']);
		$toemailid  = mysql_real_escape_string($_POST['agent_email']);
		//$toemailid  = 'pankaj.business2sell@gmail.com';
		$subject  = mysql_real_escape_string($_POST['subject']);
		$message  = str_replace('\n','',trim(mysql_real_escape_string($_POST['message'])));
		//$message  = trim(($vars[3]));
		$type  = mysql_real_escape_string($_POST['type']);
		$email_type  = mysql_real_escape_string($_POST['email_type']);
		
		sendmailbcic('BCIC',$toemailid,$subject,$message,"reclean@bcic.com.au","0");
		
			if($email_type == '1') {
				$emailType = 'Agent';
				//echo '===111==='.$email_type;
				if($type == 'job') {
				     $sql = ("UPDATE `job_details` SET `agent_email_sent_date` = '".date('Y-m-d H:i:s')."' where job_id=".mysql_real_escape_string($job_id)." AND status != 2"); 
				}else {
					 $sql =  ("UPDATE `job_reclean` SET `agent_email_sent_date` = '".date('Y-m-d H:i:s')."' where job_id=".mysql_real_escape_string($job_id)." AND status != 2");
				}
			//echo $sql;	
			     mysql_query($sql);	
				 
			}elseif($email_type == '2'){
				$emailType = 'Client';
				$bool =  mysql_query("UPDATE `quote_new` SET `agent_email_date` = '".date('Y-m-d h:i:s')."' WHERE `booking_id` = ".$job_id."");
			}
		add_job_notes($job_id,"Email ".$emailType." Send on ".$toemailid."",$message);
		echo "<p style='color:green'>Email Send to ".$toemailid.' Successfully </p>';

    }		

?>