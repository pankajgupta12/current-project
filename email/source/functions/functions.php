<?php 

	function checkEmailInDb( $mail_type, $msgNo , $mailfolderName , $subject = null)
	{
		 $Sql = "SELECT email_msgno,id, quote_id, job_id  FROM `bcic_email` WHERE email_msgno = ".$msgNo."  AND mail_type = '".trim($mail_type)."' AND folder_type = '".$mailfolderName."'";
		
		if($subject != '') {
		 $Sql.= "AND email_subject = '".$subject."'";    
		}
		
		$checkExit = mysql_query($Sql);
		//if found then update the message body
		$getdata =  mysql_fetch_assoc($checkExit);
		return $getdata;
	}

	
	

	function setEmailMsgForNewInsertion($mail_type, $value, $mailfolderName)
	{
	    
		$arg = '';
		$headervalue = $value['header'];
		if($mailfolderName == 'INBOX') {
			$maildata = $headervalue->date;
			$email_assign = 1;
			$admin_id = 0;
		}else if($mailfolderName == 'Sent'){
			$maildata = $headervalue->MailDate;
			$email_assign = 3;
			$admin_id = $_SESSION['admin'];
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


		 $mailBody = $value['body'];

				
		
		$arg .= "INSERT INTO `bcic_email`
				(
				 `mail_type`,`email_date`, `email_assign` ,`admin_id`,
				 `folder_type`,`email_subject`, `email_subject_reference` , 
				 `email_message_id`, `email_references`, 
				 `email_toaddress`, `email_to`,
				 `email_fromaddress`, `email_from`,
				 `email_reply_toaddress`,  `email_reply_to`, 
				 `email_mailbox`, `email_senderaddress`,
				 `email_sender`,  `email_recent`,
				 `email_unseen`, `email_flagged`, 
				 `email_answered`,  `email_deleted`,
				 `email_draft`, `email_msgno`, 
				 `email_maildate`, `email_size`, 
				 `email_udate`, `email_body`,
				 `quote_id`, `job_id`,
				 `staff_id`, `createdOn`
				) 
				VALUES "; 
				
			$arg .= " (
				'".$mail_type."','".$maildata."', '".$email_assign."' , '".$admin_id."'
				'".$mailfolderName."',  '".$headervalue->subject."', '".str_replace('Re: ','', $headervalue->subject)."', 
				'".$headervalue->message_id."', '".$headervalue->references."',
				'".$headervalue->toaddress."', 'fdfdf',
				'".$headervalue->fromaddress."','".$fromMsg."', 
				'".$headervalue->reply_toaddress."', '".$replyMsg."',
				'dfdf', '".$headervalue->senderaddress."', 
				'".$senderMsg."', '".$headervalue->Recent."',
				'".$headervalue->Unseen."','".$headervalue->Flagged."', 
				'".$headervalue->Answered."','".$headervalue->Deleted."',
				'".$headervalue->Draft."','".trim($headervalue->Msgno)."',
				'".$headervalue->MailDate."', '".$headervalue->Size."', 
				'".$headervalue->udate."','".$mailBody."',
				'0','0',
				'0','".date('Y-m-d H:i:s')."'
			)";	
		//echo $arg."<br/><br/>";				
		$bcicemail = mysql_query($arg);
		
	return mysql_insert_id();	
	}
	
	function insertToo($iin) {
	    
	    mysql_query(
            "
                INSERT INTO bcic_sms2 (data) values ({$iin})
            "    
        );
	    
	}
	
	function setFileAttachmentInsertion($id,$mail_type , $value , $mailfolderName)
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
	

	 function setEmailMsgBodyUpdate($mail_type , $value, $id, $existMail = null)
	{
  		$arg = '';
		$headervalue = $value['header'];
		if($value['body'] != '') {
		  $mailBody = $value['body'];
		}else{
		  $mailBody = '';	
		}
		
		if( isset($existMail['quote_id']) && $existMail['quote_id'] > 0 ){
			$quote_id = $existMail['quote_id'];
		} else { 
			$quote_id = '';
		}
	   mysql_query("UPDATE `bcic_email` set quote_id = '".$quote_id."' , email_udate = '".$headervalue->udate."' , email_body = '".$mailBody."' where id = '".$id."' AND mail_type = '".$mail_type."'"); 
	} 
	
	
	function CheckQuoteEmail($fromMsg = null,$mail_type = null,$Msgno = null,$mailfolderName = null , $insertID = null )
	{
		
		
       $mysql_query = mysql_query("SELECT  job_id , quote_id  FROM `bcic_email` where id = '".$insertID."'");	
       
        $getMailSql = mysql_query($mysql_query);
        $countEmail = mysql_num_rows($getMailSql);
        $data1  = mysql_fetch_object($getMailSql);
       
       //print_r($data1); die;
       
       if($data1->booking_id > 0) {
           
			$job_id = $data1->booking_id;
			
			$qut_id = $data1->id;
		
       }else {
           
           	$mysql_query  = ("SELECT id , booking_id,  email from quote_new where email = '".$fromMsg."' AND deleted != 1 AND step != 10 AND bbcapp_staff_id = 0 Order by id desc Limit 0, 1");
    
    		$getMailSql = mysql_query($mysql_query);
    		$countEmail = mysql_num_rows($getMailSql);
    		$data1  = mysql_fetch_object($getMailSql);
    		
    		$job_id = $data1->booking_id;
    		$qut_id	 = $data1->id;
    	
    		
       }
       
       	$email_noti_id = 0;
       	
          /*  if($checkJobsid['quote_id'] > 0) {
               
    			$qut_id = $checkJobsid['quote_id'];
    		
           }*/
    		/*$mysql_query  = ("SELECT id , booking_id,  email from quote_new where email = '".$fromMsg."' AND deleted != 1 Order by id desc Limit 0, 1");
    
    		$getMailSql = mysql_query($mysql_query);
    		$countEmail = mysql_num_rows($getMailSql);
    		$data1  = mysql_fetch_object($getMailSql);
    		
    		$job_id = $data1->booking_id;
    		$qut_id	 = $data1->id;
    		$email_noti_id = 0;*/
    		
    					
    			if($countEmail > 0) {	
    			
    			        if($job_id != 0) {
    						
    						$field_name =  'job_id';
    						$value =  $job_id;
    						
    						//$getemailDetails_j =  mysql_fetch_assoc(mysql_query("SELECT email_subject , email_body,email_date FROM `bcic_email`   WHERE `mail_type` = '".$mail_type."' AND `email_msgno` = '".$Msgno."' AND folder_type= '".$mailfolderName."'")); 
    						
    						if( $job_id != 0 ) {
    							mysql_query("UPDATE `bcic_email` SET `client_email_id` = '".$fromMsg."', $field_name = '".$value."' , quote_id = '".$qut_id."'  WHERE `mail_type` = '".$mail_type."' AND `email_msgno` = '".$Msgno."' AND folder_type= '".$mailfolderName."'");
    						} else {
    							
    							
    							
    							mysql_query("UPDATE `bcic_email` SET `client_email_id` = '".$fromMsg."', quote_id = '".$qut_id."'  WHERE `mail_type` = '".$mail_type."' AND `email_msgno` = '".$Msgno."' AND folder_type= '".$mailfolderName."'");
    						}
    						
    						
    					//echo "<pre/>";	print_r($getemailDetails_j);
    						
    					}else {
    						$field_name = 'quote_id';
    						$value = $data1->id;
    						
    						//$getemailDetails_q =  mysql_fetch_assoc(mysql_query("SELECT email_subject , email_body,email_date FROM `bcic_email`   WHERE `mail_type` = '".$mail_type."' AND `email_msgno` = '".$Msgno."' AND folder_type= '".$mailfolderName."'")); 
    						
    						mysql_query("UPDATE `bcic_email` SET `client_email_id` = '".$fromMsg."', $field_name = '".$value."'  WHERE `mail_type` = '".$mail_type."' AND `email_msgno` = '".$Msgno."' AND folder_type= '".$mailfolderName."'");
    						
    					  // echo "<pre/>";	print_r($getemailDetails_q);
    					}
    			   
    				
    				
    				//for quote
    				
    				
    				if( isset($insertID) && $insertID > 0 ) {
    				    
    					//for job and quote automatically
    					CheckJobANDQuoteID($field_name ,$value , $insertID );
    			    	//$email_noti_id = add_emails_notification($qut_id,$job_id,$insertID );
    			    	
    				}
    			
    				
    			} 
    				
    				
    		    $checkagentEmail = mysql_query("SELECT agent_email ,  job_id FROM `job_details` where agent_email = '".$fromMsg."' AND status != 2  GROUP by job_id");
    		    $getAgentDetails = mysql_fetch_assoc($checkagentEmail);
    		
    			if(!empty($getAgentDetails) > 0) {
    				//echo "<pre>";  print_r($getAgentDetails);
    				mysql_query("UPDATE `bcic_email` SET `real_agent_email_id` = '".$fromMsg."', job_id = '".$getAgentDetails['job_id']."' WHERE `mail_type` = '".$mail_type."' AND `email_msgno` = '".$Msgno."' AND folder_type= '".$mailfolderName."'");
    				
    			} 
			
			
	    
	}
	
	function add_emails_notification_old($quote_id,$job_id,$email_id ){
	
	
	     $admin_id =  get_admin_sales_id($quote_id);
	
     
	    $customDate = date("Y-m-d H:i:s");
			
			
			$ins_arg="insert into emails_notification set q_id=".$quote_id.",";
			$ins_arg.=" job_id='".$job_id."',";
			$ins_arg.=" createOn='".$customDate."',";
			$ins_arg.=" admin_id='".$admin_id."',";
			$ins_arg.=" email_id='".$email_id."'";	
			$ins = mysql_query($ins_arg);
		    $email_noti_id =  mysql_insert_id();	
		    
		    if($email_noti_id > 0) {
		        mysql_query("UPDATE `bcic_email` SET `emails_notification_id` = '".$email_noti_id."' where quote_id = ".$quote_id."");
		    }
    }
	
	
	function add_emails_notification($quote_id,$job_id,$email_id ){ 
	    
	
	     $heading = 'Q#'.$quote_id.' You have received an email';
	
	     $admin_id =  get_admin_sales_id($quote_id);
	
     
	      $customDate = date("Y-m-d H:i:s");
			
			
			$ins_arg="insert into site_notifications set quote_id=".$quote_id.",";
			$ins_arg.=" job_id='".$job_id."',";
			$ins_arg.=" date='".$customDate."',";
			$ins_arg.=" notifications_type='8',";
			$ins_arg.=" login_id='".$admin_id."',";
			$ins_arg.=" heading='".$heading."',";
			$ins_arg.=" comment='".$heading."',";
			$ins_arg.=" email_id='".$email_id."'";	
			$ins = mysql_query($ins_arg);
		    $email_noti_id =  mysql_insert_id();	
		    
		    if($email_noti_id > 0) {
		        mysql_query("UPDATE `bcic_email` SET `emails_notification_id` = '".$email_noti_id."' where quote_id = ".$quote_id."");
		    }
    }
    
    function get_admin_sales_id($qid){
 
		 $Sql = "SELECT id , task_manage_id FROM `sales_system` WHERE quote_id = ".$qid.""; 
		 $checkExit = mysql_query($Sql);
		 $getdata =  mysql_fetch_assoc($checkExit);
		 return $getdata['task_manage_id'];
    }	
	
	/* function getBcicEmails($mail_type){
		$arg = "SELECT * FROM `bcic_email` where mail_type = 'test_2'";
	} */
	
	/* function CheckAttachMent($email_id,$mail_type){
		echo  "SELECT count(id) as countRow  FROM `bcic_email_attach` WHERE email_id = ".$email_id." AND mail_type = '".$mail_type."'"
	} */
	
?>