<? 
session_start(); 
//include('googleShortUrl.php');
include("../../admin/source/functions/functions.php");
include("../../admin/source/functions/config.php");
include("../../mail/source/functions/bcic_mail_functions.php");
//print_r($googer);

if($_SESSION['admin'] != '') {
        if ($_GET['xt']!=""){
        	
        	if ($_GET['sid']!=""){
        		if (session_id()==$_GET['sid']){
        			switch ($_GET['xt'])
        			{
        			// userd in try folder 
        			case "1": get_mail_type_data($_GET['var']);  break;
        			case "2": check_dropdown_field($_GET['var']);  break;
        			case "3": search_bcic_emails($_GET['var']);  break;
        			case "4": email_fillter_rest($_GET['var']);  break;
        			case "5": get_emails_details($_GET['var']);  break;
        			case "6": back_email_page($_GET['var']);  break;
        			case "7": forward_email($_GET['var']);  break;
        			case "8": show_email_details($_GET['var']);  break;
        			case "9": get_emails_notes_side($_GET['var']);  break;
        			case "10": email_edit_field($_GET['var']);  break;
        			case "11": add_emails_notes($_GET['var']);  break;
        			case "12": remove_email($_GET['var']);  break;
        			case "13": send_email($_GET['var']);  break;
        			case "14": get_email_folder($_GET['var']);  break;
        			case "15": sent_new_message($_GET['var']);  break;
        			case "16": is_checkattachment($_GET['var']);  break;
        			case "17": reply_email($_GET['var']);  break;
        			case "18": check_reclen($_GET['var']);  break;
        			case "19": email_pageination($_GET['var']);  break;
        			case "20": search_by_text($_GET['var']);  break;
        			case "21": text_edit_fields($_GET['var']);  break;
        			case "22": check_fields_dropdown($_GET['var']);  break;
        			case "23": remove_quote_job_ids($_GET['var']);  break;
        			case "24": compose_new_msg($_GET['var']);  break;
        			case "25": recheck_emails($_GET['var']);  break;
        			case "50": searchstaffemail($_GET['var']);  break;
        			case "51": reclean_send_new_email($_GET['var']);  break;
        			case "52": block_emails($_GET['var']);  break;
        			case "53": complaint_email_reply($_GET['var']);  break;
        			case "54": reclean_email_reply($_GET['var']);  break;
        			case "55": get_templatemessage($_GET['var']);  break;
        			
        			// Header Notification
        			case "71": notification_data($_GET['var']); break;
        			case "74": refress_notification($_GET['var']); break;
        			case "215": urgent_notification_data($_GET['var']); break;
        			case "216": refress_urgent_notification($_GET['var']); break;
        			case "216": refreshNotificationAfterDeleteMarked($_GET['var']); break;
        			case "233": message_borad($_GET['var']); break;
        			case "248": search_all_details($_GET['var']); break;	
        			case "247": universal_search_page($_GET['var']); break;
        			case "570": getpersnal_noti($_GET['var']); break;
        			
        			case "240": update_message_status($_GET['var']); return false;
        			
        			case "295": scrollAndAddEmails($_GET['var']); break;
        			
        			
        			default : 
        				echo "xt not in list: ".$_GET['xt'];
        			}
        		}else{
        			echo "session id ".session_id(). " != ".$_GET['sid']."<br>";
        		}
        	}else{
        		echo "sid is nothing ";
        	}
        
        	}else{
        	echo "xt not found ";
        } 
}else {
     	echo "Your session has been expired. Please login again ";
}

    function block_emails($str){
		
	   $strvalue = explode('|', $str);
	   $em_ids = $strvalue[0];
	   $emailid = $strvalue[1];
	   
	    $checkemails =  mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(id) as ids FROM `bcic_email` WHERE email_from = '".$emailid."'"));
		 
		// echo mysql_num_rows($checkemails); die;
		 
		if(!empty($checkemails)) {
			 
			mysql_query("UPDATE bcic_email SET is_delete = '1'  WHERE email_from = '".$emailid."'");
			$bool =  mysql_query("UPDATE bcic_email SET is_delete = '1'  where id in (".$em_ids.")");
				
			$getattchment =  mysql_query("SELECT id FROM `bcic_email_attach` WHERE email_id in (".$em_ids.")");
				
			if(mysql_num_rows($getattchment) > 0) {
				  //mysql_query("DELETE FROM `bcic_email_attach` WHERE `email_id` IN (".$em_ids.")");
				  $bool =  mysql_query("UPDATE bcic_email_attach SET is_delete = '1'  where email_id in (".$em_ids.")");
				  $bool =  mysql_query("UPDATE bcic_email_attach SET is_delete = '1'  where email_id in (".$checkemails['ids'].")");
			}	
			mysql_query("INSERT INTO `block_emails` (`email`,`createOn`) VALUES ('".$emailid."', '".date('Y-m-d H:i:s')."')"); 
			
		}
		 
		$_SESSION['mail_details'] = '';
		$_SESSION['forward_email'] = '';
		unset($_SESSION['mail_details']);
		unset($_SESSION['forward_email']);
		
		include('bcic_email.php');
    }


    function update_message_status($str){

                $vars =  explode('|' ,$str); 
                
                // print_r($vars);
                
                $value = $vars[0];
                $id = $vars[1];
                
                $getsales_follow = mysql_fetch_assoc(mysql_query("Select id ,quote_id , fallow_date ,fallow_time, task_manager_id from sales_task_track where notification_id=".$id.""));
                
                //print_r($getsales_follow); die;
                
                if(!empty($getsales_follow)) {	
                
                    $salesid = $getsales_follow['id'];
                    $task_manager_id = $getsales_follow['task_manager_id'];
                
                    $flag = 1;
                    if($value == 1) {
                       $responcetype = 28;
                    }elseif($value == 2) {
                      $responcetype = 29;
                    }elseif($value == 3) {
                       $responcetype = 30;
                       $flag = 2;
                       
                    }
                
                    add_task_manager($salesid, 0, 4, 0, 0, $responcetype, $task_manager_id, 0, 0);		
                }
		 
            $staff_id = get_rs_value("site_notifications","staff_id",$id);
            
            if($flag == 1 || $value != 3) {  
            
            $qryBool = mysql_query( "UPDATE site_notifications SET message_status = '".$value."'  WHERE id = ".$id."" );
            // echo 'ook';
            
            }else{
            
            $qryBool = mysql_query( "UPDATE site_notifications SET message_status = '".$value."' , notifications_status = 1 ,  task_complete_date = '".date('Y-m-d H:i:s')."'  WHERE id = ".$id."" );
            // echo 'mmmmmmmmmmm';
            
            }
    }
 


   function refreshNotificationAfterDeleteMarked($str)
{
			
	$getnotidata = mysql_fetch_array(mysql_query( "select * from site_notifications WHERE id = {$str}" ));	
	
	$notification_read_user = $getnotidata['notification_read_user'];
	$job_id = $getnotidata['job_id'];
	$comment = $getnotidata['heading'];
	
	$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
	$r_msg = '';
	
	$currentDate = date('Y-m-d H:i:s');
	
	if($notification_read_user != '') { $r_msg = $notification_read_user.','; }
    $messageRead = $r_msg.$staff_name.'_('.$currentDate.')';
    
    $qryBool = mysql_query( "UPDATE site_notifications SET 
	notifications_status = 1,notification_read_user = '".$messageRead."' , task_complete_date = '".$currentDate."' WHERE id = {$str}" );
	
	if($job_id != 0) {
		$heading_data = 'Read notification by '.$staff_name;
	    add_job_notes($job_id,$heading_data,$comment);
	}	
	
	$getdatainf=  GetAlownotification_11();

    $str1 = '5,6 ';
	if(in_array($_SESSION['admin'] , $getdatainf)) {
     $str1 = '5,6,7 ,8';
    }
	$staff_notification= "select id from site_notifications where notifications_status = '0'  AND notifications_type IN (".$str1.") ORDER BY id desc "; 
	

	$staff_notificationText = mysql_query($staff_notification);

	$staffcountnotef = mysql_num_rows($staff_notificationText);
	
	echo $staffcountnotef;
    //include('urgent_staff_notification.php');
} 

 	function GetAlownotification_11(){
		
		$sql = mysql_query("SELECT id  FROM `admin` WHERE status = 1  and allow_urgent_noti = 1 ");
		
		$cunt = mysql_num_rows($sql);
		
				if($cunt > 0) {
				    while($getinfdata = mysql_fetch_assoc($sql)) {
						
						$getdata[] = $getinfdata['id'];
					}
		        }
		return $getdata;
	}

    function searchstaffemail($var){
		
		  $vars = explode('|',$var);
		  $val = $vars[0];
		  $functionname = $vars[1];
		
			$str= '';
			$str.= "select * from staff where status=1";
			$str.= " AND  (name like '%".mysql_real_escape_string($val)."%' OR  email like '%".mysql_real_escape_string($val)."%')";
	
		//echo $str; die;
		$data = mysql_query($str);
		
		$countResult = mysql_num_rows($data);
		
		if($countResult > 1) {
			$class = 'staff_email';
		}else{
			$class = 'staff_email_single';
		}
		
		if($countResult >  0) {
			$strx = "<ul class=\"post_list $class\">";
				while($r=mysql_fetch_assoc($data)){
					
					//print_r($r); 
					$strx.="<li onclick=\"javascript:$functionname('".$r['id']."','".$r['email']."')\"><a href=\"javascript:void(0);\">".$r['name']."<br/>".$r['email']."</a></li>";
				}	
		  $strx.="</ul>";	
		}else {
          $strx.="";
		}
		
		echo $strx;
    }

function recheck_emails($str){
    
    
    $vars = explode('|',$str);
	$id = $vars[0];
	$type = $vars[1];
	
    $getreplyEmaildetails = mysql_fetch_assoc(mysql_query("SELECT id, email_msgno , folder_type FROM `bcic_email` WHERE `id` = ".$id));
    //print_r($getreplyEmaildetails); exit;
    
    //#### INCLUD EMAIL READER FILE
    include($_SERVER['DOCUMENT_ROOT'].'/mail/classes/mails/EmailReader.php');
    
    //***************************************************************
            //ORIGINAL CODE START
    //***************************************************************
    
    $mail_type = strtolower($type);
    
    if( $getreplyEmaildetails['folder_type'] == "Sent" ) {  //INBOX.Sent
        $mail_typefolder = "INBOX.Sent";
	    $mailfolderName = 'INBOX'; 
    } else {
        $mail_typefolder = "INBOX";
	    $mailfolderName = 'INBOX'; 
    }
	$getMaildata = mysql_fetch_assoc(mysql_query("SELECT * FROM `email_config`WHERE email_type = '".$mail_type."'"));
	$counter = $getMaildata['counter_inbox'];	
	$filedname = 'counter_inbox';
	$mailIds = [];
	
	//***************************************************************
            //#### REQUIRED EAMILREADER CONSTRUCTOR
    //***************************************************************  
    $emailReader = new EmailReader(
    	trim($getMaildata['server_name']),
    	trim($getMaildata['user_email']),
    	trim($getMaildata['user_password']),
    	trim($getMaildata['server_port']),
    	$mail_typefolder
    );
    
    //***************************************************************
            //#### REQUIRED UNFLAGGED EMAILS THROUGH
    //***************************************************************
    $getemailData = $emailReader->retrieve_message( $getreplyEmaildetails['email_msgno']  , $mail_type);
    
     //echo '<pre/>'; print_r($getreplyEmaildetails); die;
    
       $value = $getemailData;
       
        $headervalue = $value['header'];
		if($mailfolderName == 'INBOX') {
		$maildata = $headervalue->date;
		}else if($mailfolderName == 'Sent'){
		$maildata = $headervalue->MailDate;
		}

		$frommailBox = $headervalue->from[0]->mailbox;
		$fromhost = $headervalue->from[0]->host;
		$fromMsg =  $frommailBox.'@'.$fromhost;


		$replymailBox = $headervalue->reply_to[0]->mailbox;
		$replyhost = $headervalue->reply_to[0]->host;
		$replyMsg =  $replymailBox.'@'.$replyhost;


		$sendermailBox = $headervalue->sender[0]->mailbox;
		$senderhost = $headervalue->sender[0]->host;
		$senderMsg =  $sendermailBox.'@'.$senderhost;

		//$value['body'] = preg_replace("/<style\\b[^>]*>(.*?)<\\/style>/s", "", $value['body']);
        $mailBody = $value['body'];
//email_from
    if($getreplyEmaildetails['id'] != '') {
         mysql_query("Update bcic_email set `email_subject` = '".addslashes($headervalue->subject)."', `email_subject_reference` = '".addslashes(str_replace('Re: ','', $headervalue->subject))."' , 
				 `email_message_id` = '".$headervalue->message_id."' , `email_fromaddress` = '".addslashes($headervalue->fromaddress)."',  `email_from` = '".addslashes($fromMsg)."', 
				 `email_toaddress` = '".addslashes($headervalue->toaddress)."' , `email_body` = '".addslashes($mailBody)."' where  id =".$getreplyEmaildetails['id']); 
				 
				 $updateemail = $getreplyEmaildetails['id'];
    }
				 
		
		//***************************************************************
            //#### REQUIRED IF FILE ATTACMENTS ARE COMING INSIDE EMAIL, THE EXECUTE THE CODE
            //#### TO STORE IN INSIDE THE LOCATION
        //***************************************************************
    	if(!empty($value['file_attach'])) {
    	    
    	    
    	    $getattchment = mysql_query("SELECT * FROM `bcic_email_attach`WHERE email_id = '".$getreplyEmaildetails['id']."'");
    	    if(mysql_num_rows($getattchment) > 0) {
    	        mysql_query("DELETE from bcic_email_attach where email_id = ".$getreplyEmaildetails['id']."");
    	    }
    		setupdate_FileAttachmentInsertion($getreplyEmaildetails['id'],$mail_type , $value, $mailfolderName);
    	}
    
      // echo '<span style="color:red;font-weight:600;">Re-Checked</span>';
    	include('bcic_email.php');
}



function setupdate_FileAttachmentInsertion($id,$mail_type , $value , $mailfolderName)
	{
		 $headervalue = $value['header'];
		
		
		$attchMent_arg = '';
		$attchMent_arg .= "INSERT INTO `bcic_email_attach`
				(
				 `email_id`, `folder_type` ,`email_message_id`, `email_attach`, 
				 `email_folder`, `email_msgno`, `mail_type`, `createdOn`
				) 
				VALUES ";
				
		foreach($value['file_attach']['fileattach'] as $attchValue) {
		$attchMent_arg .= " (
					'".$id."', '".$mailfolderName."','".$headervalue->message_id."', 
					'".$attchValue."','".$value['file_attach']['attachmentLocationName']."', 
					'".trim($headervalue->Msgno)."','".$mail_type."', 
					'".date('Y-m-d H:i:s')."'
				),";	
		}

		
        return mysql_query(rtrim($attchMent_arg,','));		
	}

function compose_new_msg($str){
     
        $_SESSION['lastemailis'] = '';
		$activitytext = 'Open Email';
		$staffRoster = mysql_query("INSERT INTO `temp_email_activity` (`start_time`, `activity`, `staff_id`) VALUES ('".date('Y-m-d H:i:s')."', '".$activitytext."','".$_SESSION['admin']."')");
		$insertId =  mysql_insert_id();
		$_SESSION['lastemailis'] = $insertId;
    
	 ResetSession();
	 
	$_SESSION['new_message'] = 'new_message';
	include('bcic_email.php');
}

function remove_quote_job_ids($str){
	
	$vars = explode('|',$str);
	$ids = $vars[0];
	$fields = $vars[1];
	RemoveQuoteAndJobEmails($fields , $ids);
	$bool =  mysql_query("UPDATE bcic_email SET $fields = '0'  where id in (".$ids.")");
	include('bcic_email.php');
}


 function text_edit_fields($str){
	//echo $str;
	$vars = explode('|',$str);
	$value = $vars[0];
	$tablefields = explode('.',$vars[1]);
	$table = $tablefields[0];
	$fields = $tablefields[1];
	$ids = $vars[2];
	
	CheckJobANDQuoteID($fields ,$value , $ids);	
	
	$bool =  mysql_query("UPDATE $table SET $fields = '".$value."'  where id in (".$ids.")");
	echo  trim($value);  
 }

function check_fields_dropdown($str){
	
	$vars = explode('|',$str);
    $value = $vars[0];
    $id = $vars[1];
    $fields = $vars[2];
	
	
	if($fields == 'email_assign') {
        	$ids = explode(',',$id);
        	
        	
        	$i = 0;
        	
        	foreach($ids as $key=>$idsvalue) {
        	    
        	    $job_id = get_rs_value("bcic_email","job_id",$idsvalue);	
        	     if($job_id > 0  && $i == 0) {
        	         $job_id = $job_id;
        	         $i = 1;
        	     }
        	    
        	    $wehere = '';
        	    
        		if($idsvalue != ''){
        		     
        		     if($value == 3) {
        		         $wehere = ', closed_admin_id = '.$_SESSION['admin'].'';
        		     }
        		      
        	        mysql_query("UPDATE bcic_email SET $fields = '".$value."' $wehere  where id = ".$idsvalue."");
        		}
        	}
        	
        	     
        	     if($job_id > 0) {
                     mysql_query("UPDATE bcic_email SET email_assign = '".$value."'  where job_id = ".$job_id."");	
        	     }
        	
	}
	 else
	{
    
            
            $query_bcic_email = mysql_query("SELECT email_from, email_subject_reference, mail_type FROM bcic_email WHERE id='".$id."'");
        	
        	if(mysql_num_rows($query_bcic_email) > 0){
        		
        		while($getAllData = mysql_fetch_assoc($query_bcic_email)){
        			$email_from = $getAllData['email_from'];
        			$email_subject_reference = $getAllData['email_subject_reference'];
        			$mail_type = $getAllData['mail_type'];
        		}
        		
        		$getType = getactiveEmailid($mail_type);
        		
        		$update_bcic_email = "UPDATE 
        		`bcic_email` SET $fields = '".$value."' WHERE 
        		(
        			(email_from = '".$email_from."' AND email_subject_reference = '".mysql_real_escape_string($email_subject_reference)."') 
        		OR 
        			email_reply_to = '".$getType['user_email']."' AND email_subject_reference = '".mysql_real_escape_string($email_subject_reference)."') AND mail_type = '".$mail_type."' AND is_delete = 0";
        		
        		$rs_bcic_email = mysql_query($update_bcic_email);
        		
        	}
	}
	
	include('bcic_email.php');
    
}

function ResetPagination(){
	
	unset($_SESSION['page_initial']);
	$_SESSION['page_initial'] = '';
	unset($_SESSION['page_limit']);
	$_SESSION['page_limit'] = '';
	
}

function search_by_text($str){
    ResetPagination();
 	$_SESSION['email_search_value'] = $str;
	include('bcic_email.php');
}

function universal_search_page($str){
	//include('universal_search_page.php');
	include($_SERVER['DOCUMENT_ROOT'].'/admin/xjax/universal_search_page.php');
}


function search_all_details($str){
	if($str != '') {
	    $_SESSION['search_popup']['key'] = $str;
	}
	//include('universal_search_page.php');
	include($_SERVER['DOCUMENT_ROOT'].'/admin/xjax/universal_search_page.php');
}

function urgent_notification_data($str)
{  
   // include('../includes/header.php');
    //echo $_SERVER['DOCUMENT_ROOT'].'/admin/xjax/urgent_staff_notification.php'; die;
    include($_SERVER['DOCUMENT_ROOT'].'/admin/xjax/urgent_staff_notification.php');
}

   function getpersnal_noti($var) {
		//include('get_persnal_noti.php');
		 include($_SERVER['DOCUMENT_ROOT'].'/admin/xjax/get_persnal_noti.php');
	}

function refress_urgent_notification($str){
      // include('urgent_staff_notification.php');
       include($_SERVER['DOCUMENT_ROOT'].'/admin/xjax/urgent_staff_notification.php');
} 

function refress_notification($str){
       include($_SERVER['DOCUMENT_ROOT'].'/admin/xjax/notification.php');
} 

function message_borad($str){
	 include($_SERVER['DOCUMENT_ROOT'].'/admin/xjax/message_board.php'); 
}

function notification_data($str)
{  
   // include('../includes/header.php');
    include($_SERVER['DOCUMENT_ROOT'].'/admin/xjax/notification.php');
}

function email_pageination($str){
	if($str == 'next_page'){
		$_SESSION['page_initial'] = $_SESSION['page_limit'];
		$_SESSION['page_limit'] = $_SESSION['page_limit'] + 10;
		
	}else if($str == 'prev_page'){
		
		$_SESSION['page_initial'] = $_SESSION['page_initial'] - 10;
		$_SESSION['page_limit'] = $_SESSION['page_limit'] - 10;
		
	}
	include('bcic_email.php');
	//echo $str; die;
}

function check_reclen($str){
	//echo $str; die;
	//39|test_2|1
	$vars = explode('|',$str);
	if($vars[2] == 1){
		$job_id = $vars[3];
	}else{
		$job_id = 0;
	}
     $bool =  mysql_query("UPDATE `bcic_email` SET `reclean_id` = '".$job_id."' WHERE id= ".$vars[0]." AND mail_type = '".$vars[1]."'");
   
}

function ResetSession(){
	$_SESSION['mail_details'] = '';
	$_SESSION['forward_email'] = '';
	$_SESSION['reply_email'] = '';
	$_SESSION['get_mail_type'] = '';
	$_SESSION['new_message'] = '';
	$_SESSION['mail_details_id'] = '';
	
	unset($_SESSION['mail_details']);
	unset($_SESSION['forward_email']);
	unset($_SESSION['reply_email']);
	unset($_SESSION['get_mail_type']);	
	unset($_SESSION['new_message']);
	unset($_SESSION['mail_details_id']);
}


function get_mail_type_data($var){
	ResetPagination();
 	//$_SESSION['bcic_email']['mail_type'] = $var; 
	
 	$_SESSION['bcic_email']['email_category'] = $var;  
	include('bcic_email.php'); 
}

function check_dropdown_field($str){
 
    $vars = explode('|',$str);
    $value = $vars[0];
    $id = $vars[1];
    $fields = $vars[2];
    $bool =  mysql_query("UPDATE bcic_email SET $fields = '".$value."'  where id = $id");
    include('bcic_email.php');  
}


function email_fillter_rest($var){
  //echo $var; die;
    ResetPagination();
	$_SESSION['bcic_email'] = ''; 
	unset($_SESSION['bcic_email']); 
	$_SESSION['email_search_value'] = ''; 
	unset($_SESSION['email_search_value']); 
	
	include('bcic_email.php');
}

function search_bcic_emails($str){

   $vars = explode('|',$str);
   $value = $vars[0];
   $fields = $vars[1];
    if($value == 0) {
     unset($_SESSION['bcic_email'][$fields]);
    }else{
        $_SESSION['bcic_email'][$fields] = $value;
    }
    include('bcic_email.php');     
}

function show_email_details($str){
	 ResetSession();
	include('bcic_email.php'); 
}



    function get_emails_details($str)
	{
		unset($_SESSION['open_email']);
		  
		ResetSession();
		$vars = explode('|',$str);

		$id = $vars[0]; 
		$mails = explode('/' , $vars[1]); 
		
		//print_r($mails);
		
		$mail_type = $mails[0];
		$mail_id = $mails[1];
		$str = $vars[2]; 
	   
	  // echo $id; die;
	    if($id != '') {
			
		   $emailIDs = explode(',', $id);
		   
		   $_SESSION['mail_details'] = $id;
		   $_SESSION['mail_details_id'] = $mail_id;
		   
		     $admin_name = get_rs_value("admin","name",$_SESSION['admin']);
		     $heading = 'Email read by '.$admin_name;
			 
			 	$activitytext = 'Open Email';
				$comment = 'Open Email';
				
				add_email_activity($emailIDs[0],$activitytext,$comment,'',0); 
				
				$_SESSION['open_email'] = $emailIDs[0];
		   
		    foreach($emailIDs as $email_id) {
				
				$getreplyEmaildetails = mysql_fetch_assoc(mysql_query("SELECT id,  admin_id ,  email_msgno , email_assign  FROM `bcic_email` WHERE `id` = ".$id." and mail_type = '".$mail_type."'"));
				 /*$admin_id = get_rs_value("bcic_email","admin_id",$email_id);
				  $email_msg_no = get_rs_value("bcic_email","email_msgno",$email_id);*/
				  
				    $admin_id = $getreplyEmaildetails['admin_id'];
				    $email_msg_no = $getreplyEmaildetails['email_msgno'];
				    $email_assign = $getreplyEmaildetails['email_assign'];
				    
                        add_email_notes($email_id,$email_msg_no,$mail_type,$heading,$heading);
                        
				if($emailIDs[0] != $email_id)	{	
				
				     mysql_query("UPDATE `bcic_email` SET  p_id = ".$emailIDs[0]."   WHERE `id`  = ".$email_id."");		
				}
				 
				  
        				if($admin_id == 0 && $email_assign == 1) {
        					 mysql_query("UPDATE `bcic_email` SET `admin_id` = '".$_SESSION['admin']."' , email_assign = '2'   WHERE `id`  = ".$email_id."  and mail_type = '".$mail_type."'");
        				}  
				 
		    }
	    }
	  
	   include('bcic_email.php'); 
	}

function back_email_page(){
     
      $getemailids =  explode(',' , $_SESSION['mail_details']);
	 
	     if(!empty($getemailids)) {
			//foreach($getemailids as $key=>$emailids) {
				$pid = $_SESSION['open_email'];
				unset($_SESSION['open_email']);
				$activitytext = 'Closed Email';
				$comment = 'Closed Email';
				add_email_activity($getemailids[0],$activitytext,$comment,date("Y-m-d H:i:s") , $pid);
			//}	 
	    } 
    
 $_SESSION['mail_details'] = '';
 $_SESSION['forward_email'] = '';
 unset($_SESSION['mail_details']);
 unset($_SESSION['forward_email']);
 include('bcic_email.php'); 
}

	

function reply_email($str){
	
		$_SESSION['forward_email'] = '';
		$_SESSION['get_mail_type'] = '';
		unset($_SESSION['forward_email']);
		unset($_SESSION['get_mail_type']);
	
		$vars = explode('|',$str);

		$id = $vars[0]; 
		$mail_type = $vars[1]; 
		//$str = $vars[2]; 
	    if($id != 0 && $id != '') {
	        
	         $activitytext = 'Open reply Email';
			$comment = 'Click reply Email and Open screen to reply';
			$pid = $_SESSION['open_email'];
			add_email_activity($id,$activitytext,$comment,'', $pid);
	        
           $getreplyEmaildetails = mysql_fetch_assoc(mysql_query("SELECT *  FROM `bcic_email` WHERE `id` = ".$id." and mail_type = '".$mail_type."'"));
           $_SESSION['reply_email']  =  $getreplyEmaildetails;
		   $_SESSION['get_mail_type'] =  'reply_mail'; 
        } 
      include('bcic_email.php'); 
	
}


function reclean_send_new_email($str){
	
		$_SESSION['forward_email'] = '';
		$_SESSION['get_mail_type'] = '';
		unset($_SESSION['forward_email']);
		unset($_SESSION['get_mail_type']);
	
		$vars = explode('|',$str);

		$id = $vars[0]; 
		$job_id = $vars[1]; 
		$mail_type = $vars[2]; 
		//$str = $vars[2]; 
	    if($id != 0 && $id != '') {
	        
	       $activitytext = 'Open Re-Clean Create';
		   $comment = 'Open Re-Clean Create';
		   $pid = $_SESSION['open_email'];
		   add_email_activity($id,$activitytext,$comment ,'',$pid);
	        
           $getreplyEmaildetails = mysql_fetch_assoc(mysql_query("SELECT *  FROM `bcic_email` WHERE `id` = ".$id." and mail_type = '".$mail_type."'"));
           $_SESSION['reclean_email']  =  $getreplyEmaildetails;
		   $_SESSION['get_mail_type'] =  'reclean_email'; 
        } 
      include('bcic_email.php'); 
	
}

function complaint_email_reply($str){
	
		$_SESSION['forward_email'] = '';
		$_SESSION['get_mail_type'] = '';
		unset($_SESSION['forward_email']);
		unset($_SESSION['get_mail_type']);
	
		$vars = explode('|',$str);

		$id = $vars[0]; 
		$job_id = $vars[1]; 
		$mail_type = $vars[2]; 
		//$str = $vars[2]; 
	    if($id != 0 && $id != '') {
	        
	        $activitytext = 'Open complaint reply';
		    $comment = 'Open complaint reply';
		    $pid = $_SESSION['open_email'];
		   add_email_activity($id,$activitytext,$comment , '' ,$pid);
	        
           $getreplyEmaildetails = mysql_fetch_assoc(mysql_query("SELECT *  FROM `bcic_email` WHERE `id` = ".$id." and mail_type = '".$mail_type."'"));
           $_SESSION['complaint_email_reply']  =  $getreplyEmaildetails;
		   $_SESSION['get_mail_type'] =  'complaint_email_reply'; 
        } 
      include('bcic_email.php'); 
	
}

function reclean_email_reply($str){
	
		$_SESSION['forward_email'] = '';
		$_SESSION['get_mail_type'] = '';
		unset($_SESSION['forward_email']);
		unset($_SESSION['get_mail_type']);
	
		$vars = explode('|',$str);

		$id = $vars[0]; 
		$job_id = $vars[1]; 
		$mail_type = $vars[2]; 
		//$str = $vars[2]; 
	    if($id != 0 && $id != '') {
	        
	        
	         $activitytext = 'Open Re-Clean reply';
		    $comment = 'Open Re-Clean Reply';
		   $pid = $_SESSION['open_email'];
		   add_email_activity($id,$activitytext,$comment , '' ,$pid);
	        
           $getreplyEmaildetails = mysql_fetch_assoc(mysql_query("SELECT *  FROM `bcic_email` WHERE `id` = ".$id." and mail_type = '".$mail_type."'"));
           $_SESSION['reclean_email_reply']  =  $getreplyEmaildetails;
		   $_SESSION['get_mail_type'] =  'reclean_email_reply'; 
        } 
      include('bcic_email.php'); 
	
}



function forward_email($str){
	$_SESSION['reply_email'] = '';
	$_SESSION['get_mail_type'] = '';
	unset($_SESSION['reply_email']);
	unset($_SESSION['get_mail_type']);
	 $vars = explode('|',$str);
//echo
		$id = $vars[0]; 
		$mail_type = $vars[1]; 
		//$str = $vars[2]; 
	    if($id != 0 && $id != '') {
	        
	         
	        
           $getDetails = mysql_fetch_assoc(mysql_query("SELECT *  FROM `bcic_email` WHERE `id` = ".$id." and mail_type = '".$mail_type."'"));
           $_SESSION['forward_email']  =  $getDetails;
		   $_SESSION['get_mail_type'] =  'forward_email'; 
		   
		    $activitytext = 'Forward Email Open';
		    $comment = 'Click forward email and open';
		   $pid = $_SESSION['open_email'];
		   add_email_activity($id,$activitytext,$comment , '' , $pid);
		   
        }
      include('bcic_email.php'); 
}



function get_emails_notes_side($str){
      $vars = explode('|',$str);
      
	    //echo  $_SESSION['open_email']; die;
	  
	   $pid = $_SESSION['open_email'];
       $activitytext = 'Open Notes';
	   $comment = 'Open Notes';
	 
	  add_email_activity($vars[0],$activitytext,$comment, '' , $pid);
      
	  unset($_SESSION['note_email_id'],$_SESSION['note_email_type']);
	  $_SESSION['note_email_id'] = $vars[0];
	  $_SESSION['note_email_type'] = $vars[1];
	include 'bcic_emails_notes.php';
}

function email_edit_field($var){
	
	//echo $var; 
	$varx = explode("|",$var);
	
	$value = $varx[0];
	$fieldx= explode(".",$varx[1]);
	$table = $fieldx[0];
	$field = $fieldx[1];
	$id=$varx[2];
	$maitype=$varx[3]; 
	
	
	 // CheckJobANDQuoteID($field ,$value , $email_id , $maitype );
	
	$getemailsdetails =  mysql_fetch_assoc(mysql_query("SELECT id, mail_type , email_subject, email_body, email_from  FROM `bcic_email` WHERE `id` = ".$id." AND `mail_type` = '".$maitype."'"));
	
	
	 if($field == 'quote_id') {
		$sqlargq = mysql_query("SELECT * FROM `quote_new` WHERE id = ".$value." AND deleted = 0");
		
			if(mysql_num_rows($sqlargq) >  0) {
				add_bcic_quote_emails($value,$getemailsdetails['email_subject'],removeStripslashes($getemailsdetails['email_body']),$getemailsdetails['email_from'],$getemailsdetails['id'],$getemailsdetails['mail_type']);
			}	
	}
	
	if($field == 'job_id'){
		$sqlargj = mysql_query("SELECT * FROM `jobs` WHERE id = ".$value."");
			if(mysql_num_rows($sqlargj) >  0) {
				add_bcic_job_emails($value,$getemailsdetails['email_subject'],removeStripslashes($getemailsdetails['email_body']),$getemailsdetails['email_from'],$getemailsdetails['id'], $getemailsdetails['mail_type']);
			}
			
	}elseif($field == 'staff_id'){
		
	}elseif($field == 'reclean_id'){
		
	} 
	
	 if($id != '' ) {
		 
	    $bool = mysql_query("update ".$table." set ".$field."='".trim($value)."' where id=".$id." AND mail_type = '".$maitype."'");
	 }
	//echo trim($value); 
	include 'bcic_emails_notes.php';
}

function remove_email($str){
	
	//Array ( [0] => 0 [1] => bcic_email.job_id [2] => 22 [3] => test_1 )
	$varx = explode("|",$str);
	//print_r($varx);
	
	$value = $varx[0];
	$fieldx= explode(".",$varx[1]);
	$table = $fieldx[0];
	$field = $fieldx[1];
	$id=$varx[2];
	$maitype=$varx[3];  
	
	if($field == 'quote_id') {
		//SELECT *  FROM `quote_emails` WHERE `quote_id` = 7811 AND  bcic_email_id = '12'
		$sqlargq = mysql_query("SELECT * FROM `quote_emails` WHERE quote_id = ".$value." AND bcic_email_id = ".$id."");
			if(mysql_num_rows($sqlargq) >  0) {
				mysql_query("DELETE FROM `quote_emails` WHERE quote_id = ".$value." AND  bcic_email_id = ".$id."");
			}
	}
	
	if($field == 'job_id'){
		//SELECT *  FROM `quote_emails` WHERE `quote_id` = 7811 AND  bcic_email_id = '12'
	     $sqlargj = mysql_query("SELECT * FROM `job_emails` WHERE job_id = ".$value." AND bcic_email_id = ".$id."");
		if(mysql_num_rows($sqlargj) >  0) {
		  mysql_query("DELETE FROM `job_emails` WHERE job_id = ".$value." AND bcic_email_id = ".$id."");	
		}	 
	}
	
	$bool = mysql_query("update ".$table." set ".$field."='0' where id=".$id." AND mail_type = '".$maitype."'");
	// echo trim($value); 
	include 'bcic_emails_notes.php';
}



function add_emails_notes($var){
	//echo $vars; die;
	$varx = explode("|",$var);
	$value = $varx[0];
	$email_id = $varx[1];
	$mail_type = $varx[2];
	$email_msg_no = $varx[3];
	$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
	$heading = 'Email Note Added By '.$staff_name;
	$comment = $value;
	add_email_notes($email_id,$email_msg_no,$mail_type,$heading,$comment);
	
        $activitytext = 'Note Added';
        $comment = 'Note Added';
        $pid = $_SESSION['open_email'];
        add_email_activity($email_id,$activitytext,$comment ,'',$pid);
	
	include 'bcic_emails_notes.php';
	//echo $email_id; 
}

function send_email($str){
	
	//new instance create of Email class
	
	//echo $str; die;
	$varx = explode("|",$str);
	//print_r($varx); die;

	 $_SESSION['sent_new_msg_type'] = '';
	 $_SESSION['email_folder']  =  'Sent';
	 
     $totype = $varx[0];
     $msgNo =  $varx[1];
	
	 $getEmailHost  = mysql_fetch_assoc(mysql_query("SELECT *  FROM `email_config` WHERE `email_type` = '".$totype."'"));
	 //print_r($getEmailHost);  die;
	 $to = $varx[2];
     $bcc = $varx[3];
     $cc = $varx[4];
     $subject = $varx[5];
     $msgbody = base64_decode($varx[6]);
	 $mailFolder = $varx[7];
	 $serverName = trim($getEmailHost['server_name']);
	 $user_password = trim($getEmailHost['user_password']);
	 $user_email = trim($getEmailHost['user_email']);
	 $date = date('Y-m-d H:i:s');
	 
	$mail_typefolder = 'INBOX.Sent';
	$mailfolderName = 'Sent';

	$rootMailBox = "{bcic.com.au/notls}";
	$draftsMailBox = $rootMailBox . $mail_typefolder;

	$stream = imap_open ($rootMailBox, $user_email, $user_password) or die("can't connect: " . imap_last_error());
	$check = imap_check($stream);
	
	imap_append($stream, $draftsMailBox
	, "From: ".$user_email."\r\n"
	. "To: ".$to."\r\n"
	. "Subject: ".$subject."\r\n"
	. "Cc: ".$cc."\r\n"
	. "Bcc: ".$bcc."\r\n"
	. "\r\n"
	. $msgbody."\r\n"
	);
	imap_close($stream); 

	//include($_SERVER["DOCUMENT_ROOT"].'/mail/xjax/testmail.php'); 
	
	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

	$mail->IsSMTP(); // telling the class to use SMTP

	try {
			$mail->Host       = $serverName; // SMTP server
			$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)  
			$mail->SMTPAuth   = true;                  // enable SMTP authentication

			//$mail->Host       = "mail.yourdomain.com"; // sets the SMTP server

			$mail->Port       = 25;     //465               // set the SMTP port for the GMAIL server
			$mail->Username   = $user_email; // SMTP account username
			$mail->Password   = $user_password;        // SMTP account password
			
			
			$mail->AddReplyTo($to, 'First Reply');
			$mail->AddAddress($to);
			
			
			if($cc != '') {
			  $mail->AddCC($cc);  
			}
			if($bcc != '') {
			  $mail->AddBCC($bcc);
			}
			
			

			$mail->SetFrom($user_email, 'Bcic Bond Cleaning');
			$mail->Subject = $subject;
			$mail->MsgHTML($msgbody);
			// $mail->AddAttachment('images/phpmailer.gif');      // attachment
			//$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
			
			if(!$mail->Send())
			{
				echo "Message could not be sent.";
				echo "Mailer Error: " . $mail->ErrorInfo;
				exit;
			}else{
				echo "Message has been sent";
			}
		
		
			//$messageStatus = 'done';
			//echo "Message Sent OK</p>\n";
	} catch (phpmailerException $e) {
	  echo $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
	  echo $e->getMessage(); //Boring error messages from anything else!
	}
	

}

function get_email_folder($str){
    
   // echo $_SESSION['mail_details'];
   
   if($_SESSION['mail_details'] != '') {
       
       $getemailids =  explode(',' , $_SESSION['mail_details']);
	 
	    if(!empty($getemailids)) {
			//foreach($getemailids as $key=>$emailids) {
				
				
				$pid = $_SESSION['open_email'];
				unset($_SESSION['open_email']);
				$activitytext = 'Closed Email';
				$comment = 'Closed Email';
				add_email_activity($getemailids[0],$activitytext,$comment,date("Y-m-d H:i:s") , $pid);
				
			//}	 
	    }
    }
	
      	ResetSession();
		/* unset($_SESSION['page_initial']);
		unset($_SESSION['page_limit']);
		unset($_SESSION['sent_new_msg_type']);
		unset($_SESSION['sent_new_msg_type']);
		$_SESSION['new_message'] = '';
		$_SESSION['mail_details'] = '';
		$_SESSION['mail_details'] = '';
		$_SESSION['forward_email'] = '';
		$_SESSION['sent_new_msg_type'] = '';
		unset($_SESSION['mail_details']);
		unset($_SESSION['forward_email']); */
	
	if($_SESSION['email_folder'] != '') {
	   $_SESSION['email_folder']  =  $str;
	}else{
		$_SESSION['email_folder']  =  'INBOX';
	}
      include('bcic_email.php'); 
}



function sent_new_message($str){
	
	$_SESSION['sent_new_msg_type'] =$str;
	include('bcic_email.php'); 
}

function scrollAndAddEmails($emailTrCount) {
	//$_SESSION['exists_tr_lngth'] =$emailTrCount;
	include('email_queue.php'); 
}

function is_checkattachment($str){
	
	
	$vars = explode('|',$str);	
    $bool =  mysql_query("UPDATE `bcic_email_attach` SET `image_status` = '".$vars[3]."' WHERE id= ".$vars[0]." AND email_id = ".$vars[1]." AND mail_type = '".$vars[2]."'");
  
}

function get_templatemessage($id){
    if($id != 0) {
	 $message =  get_rs_value("bcic_template","message",$id);
	 echo  $message;
    }else{
        echo '';
    }
	include('signature.php');
}

?>