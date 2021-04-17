<?php
    
    /*ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);*/  
    
    error_reporting(0);
    ini_set('memory_limit','5120M');      

	$msg = "Reclean mail reading for team@beta.bcic.com.au";

	// use wordwrap() if lines are longer than 70 characters
	$msg = wordwrap($msg,70);
    
    // send email  
//	mail("ashishg.business2sell@gmail.com","Reclean is running for Bcic Email for Team@beta.bcic.com.au, will set it by tomorrow.",$msg);
	
    //***************************************************************
            //INCOMING MAIL READING THROUGH PIPE PROGRAM
    //***************************************************************

    //#### REQUIRED CODE
    include $_SERVER['DOCUMENT_ROOT'] . '/mail/source/functions/functions.php';
    include($_SERVER['DOCUMENT_ROOT'] . "/mail/source/functions/bcic_mail_functions.php");
    include($_SERVER['DOCUMENT_ROOT'].'/mail/classes/mails/EmailReader.php');
    //use \Bcic\Outlook\Email\Sys\EmailReader;
    
    Define ('DB_name',"bciccom_db");
	Define ('DB_user',"bciccom_dbusers");
	Define ('DB_pass',"x#fxCQ0J{7M]");  

	$site_name = "https://www.bcic.com.au";
	$secure_site_name = "https://www.bcic.com.au";
	$email_url = "https://exchange.mail.bcic.com.au";	

	Define ('DB_HOST',"localhost"); 	
	$hostname = "localhost";   

	Define ('DB_prefix',"");
	Define ('C_name',""); 

	Define ('SS_TT_prefix',"betameetme");
	Define ('resultsPerPage',50);
	Define ('dispatchboardPerPage',10); 
	Define ('staffresultsPerPage',20); 

    $link = mysql_connect($hostname,DB_user,DB_pass) or die("Could not connect");
    mysql_select_db(DB_name,$link) or die("Could not select database");

    mysql_query(
        "
            INSERT INTO bcic_sms2 (data) values ('cooling buddyyy')
        "    
    );
    
    //***************************************************************
            //ORIGINAL CODE START
    //***************************************************************
    
    /*$mail_typefolder = 'INBOX.Sent';
	$mailfolderName = 'Sent'; */
    
    
    $mail_type = 'reclean';
    $mail_typefolder = 'INBOX';
	$mailfolderName = 'INBOX'; 
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
    //$getemailData = $emailReader->emailCounter('ALL',$mail_type);
    
    //***************************************************************
            //#### REQUIRED ALL EMAIL THROUGH
    //***************************************************************
    //$getemailData = $emailReader->inbox('ALL',$mail_type);

    //***************************************************************
            //#### REQUIRED UNSEEN EMAILS THROUGH
    //***************************************************************
    //$getemailData = $emailReader->inbox('UNSEEN',$mail_type);
    
    //***************************************************************  
            //#### REQUIRED UNFLAGGED EMAILS THROUGH
    //***************************************************************
    //$getemailData = $emailReader->inbox('UNFLAGGED',$mail_type, 10);
    
    $getemailData = $emailReader->inbox('UNSEEN',$mail_type, 50);
    
    if( count($getemailData) == 0 ) {
        $getemailData = $emailReader->inbox('UNFLAGGED',$mail_type, 50);
    }
    
     
    
    // echo '<pre>';  print_r($getemailData);  die;
    
    
    //***************************************************************  
            //#### REQUIRED HEADER CHECKING
    //***************************************************************
    if( !empty($getemailData[0]['header']) )
    {
        $mailBoolean = true;
    }
    
    //*****************************
     
    //***************************************************************
        //#### REQUIRED HEADER IS AVAILABLE THAN START EXECUTE BELOW CODE
    //*************************************************************** 
     if($mailBoolean == true)
     {
    	 
        $i = 0;
        $sum = 0; 
        
        //***************************************************************
                //#### REQUIRED OBJECT TRAVERSING TO KNOW ABOUT THE OTHER FACTS
        //*************************************************************** 
        foreach($getemailData as $value)
    	{
            
    		//***************************************************************
                    //#### REQUIRED HEADER ARRAY || STAD CLASS OBJECT
            //*************************************************************** 
    		$headervalue = $value['header'];
    		
    		//***************************************************************
                    //#### REQUIRED OPTION CHECK FOR DELETED
            //*************************************************************** 
    		if($headervalue->Deleted != 'D') {
    		    
    		    $total = $sum + $i;
    			$frommailBox = $headervalue->from[0]->mailbox;
    			$fromhost = $headervalue->from[0]->host;
    			$fromMsg =  $frommailBox.'@'.$fromhost;
    			
    			 $checkblockemails = checkblok_emails($fromMsg);
    			 if($checkblockemails == 0) {	
    			     
    			     
    			           if($headervalue->subject == '') {
    			               $headervalue->subject = 'no subject';
    			           }else{
    			               $headervalue->subject = $headervalue->subject;
    			           }
    			
                			//***************************************************************
                                //#### REQUIRED CHECK EMAIL ONCE IN OUR SYSTEM IF SEEN OR UNSEEN
                            //*************************************************************** 
                			//$emailDbCountOnce = checkEmailInDb($mail_type, $headervalue->Msgno,$mailfolderName);
                			$emailDbCountOnce = checkEmailInDb($mail_type, $headervalue->Msgno,$mailfolderName,$headervalue->subject);
                			//print_r($emailDbCountOnce);
                			
                			//If found the record, it will go for update the message body
                			//***************************************************************
                                //#### REQUIRED IF FOUND THE RECORD IN DB BUT AS UNSEEN COMING
                                //#### IT WILL GO FOR UPDATE THE MESSAGE BODY
                            //***************************************************************
                			if( $emailDbCountOnce['id'] > 0 )
                			{
                				//echo $emailDbCountOnce['id']. "test";
                				setEmailMsgBodyUpdate($mail_type , $value, $emailDbCountOnce['id']);
                			}  
                			
                			//***************************************************************
                                //#### REQUIRED IF NOTHING , THEN GO FOR VERY FIRST INSERTION AS FRESH @EMAIL
                            //***************************************************************          
            			if( empty($emailDbCountOnce))
            			{  
            			    
            			    if( $headervalue->message_id !== "" || !empty($headervalue->message_id) ) 
            			    {
                			    //functions file
                				//$insertID = $emailReader->setEmailMsgForNewInsertion($mail_type , $value, $mailfolderName);
                				
                				//EmailReader Class
                				$insertID = $emailReader->setEmailMsgForNewInsertionByReader($mail_type , $value, $mailfolderName);
                				$iin = $value['index'];
                			
                			    //***************************************************************
                                    //#### REQUIRED UPDATE SEEN STATUS TO AFTER READING UNSEEN
                                //***************************************************************
                			    if( $insertID > 0 ){
                			        $emailReader->setSeenEmail($value['index']);
        							
        							//***************************************************************
        								//#### JUMP INTO INBOX ---- .... ---- SOMETHING NEW
        								//#### WILL UPDATE THE COMMENT SOON
        							//***************************************************************
        							if($mailfolderName == 'INBOX') {
        								CheckQuoteEmail($fromMsg , $mail_type, str_replace(' ','', $headervalue->Msgno), $mailfolderName , $insertID);
        							}
                        		}
                			  
                			    //***************************************************************
                                    //#### REQUIRED IF FILE ATTACMENTS ARE COMING INSIDE EMAIL, THE EXECUTE THE CODE
                                    //#### TO STORE IN INSIDE THE LOCATION
                                //***************************************************************
                				if(!empty($value['file_attach'])) {
                					setFileAttachmentInsertion($insertID,$mail_type , $value, $mailfolderName);
                				}
                				
            			    }
            			    
            			}	
    			 }else{
                	     $emailReader->setSeenEmail($value['index']);
                }
    			
    			
    		$i++;
    		}
        }
        
        //close the imap connection
        //imap_expunge($emailReader);
        $emailReader->close();
        
       mysql_query("UPDATE `email_config` SET $filedname = ".$total." WHERE  `id` = ".$getMaildata['id'].""); 
        
       // echo $total .'=====' .  $counter;
        
       // die;
        
        
       // echo  $total;
         
        $newCount = $total - $counter;
       
     }
    
    
    mysql_query(
        "
            INSERT INTO bcic_sms2 (data) values ('cooling buddyxx')
        "    
    );
    
    //***************************************************************
            //AFTER READING AND SEND THE CONFIRMATION TO TARGET
    //***************************************************************
    
    $msg = "READING EMAILS DONE FOR TEAM.BETA";

	// use wordwrap() if lines are longer than 70 characters
	$msg = wordwrap($msg,70);

    // send email
//	mail("ashishg.business2sell@gmail.com","COMPLETE READING FOR TEAM.BETA@BCIC.COM.AU",$msg);

?>