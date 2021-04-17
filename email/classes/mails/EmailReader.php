<?php
//***************************************************************
    //#### REQUIRED NAMESPACE INITIALIZATION
//***************************************************************
//namespace Bcic\Outlook\Email\Sys;

//***************************************************************
    //#### REQUIRED CLASS INITIALIZATION
//***************************************************************
class EmailReader
{
    
	//***************************************************************
        //#### REQUIRED IMAP SERVER CONNECTION
    //***************************************************************
	public $conn;
	public static $_conn;

	//***************************************************************
        //#### REQUIRED INBOX STORAGE AND INBOX MESSAGE COUNT
    //***************************************************************
	private $inbox;
	private $msg_cnt;

	//***************************************************************
        //#### REQUIRED EMAIL LOGIN CREDENTIALS
    //***************************************************************
	private $mailBoxes = [];
	private $server = '';
	private $user   = '';
	private $pass   = '';
	
	//***************************************************************
        //#### REQUIRED MAIL SERVER PORT
    //***************************************************************
	private $port   = 143; // adjust according to server settings
	
	//***************************************************************
        //#### REQUIRED INITIALIZE WHEN USES AS PER SCENARIO
    //***************************************************************
	private $mailType = '';

	//***************************************************************
        //#### REQUIRED CONNECT TO THE SERVER AND EGET THE INBOX EMAILS
    //***************************************************************
	function __construct( $server_host , $user_host , $pass_host , $port_host , $mailType )
	{	
		$this->defaultParams( $server_host , $user_host , $pass_host , $port_host , $mailType );		
	}

	/*	
		@params : server , user , pass and port	
		return : [
			success : only connection resource,
			error : error
		] 
		
	*/
	private function defaultParams( $server_host , $user_host , $pass_host , $port_host , $mailType )
	{
		$this->server 		= $server_host;  
		$this->user 		= $user_host;
		$this->pass 		= $pass_host;
		$this->port 		= $port_host;
		$this->mailType 	= $mailType;
		
		$this->connect();		
	}
	 
	//***************************************************************
        //#### REQUIRED CLOSE THE SERVER CONNECTION
    //***************************************************************
	function close() {
		$this->inbox = array();
		$this->msg_cnt = 0;
        
        //confirm 
        imap_expunge($this->conn);
		imap_close($this->conn);
	}

	//***************************************************************
        //#### REQUIRED OPEN THE SERVER CONNECTION
        //#### REQUIRED THE IMAP_OPEN FUNCTION PARAMETERS WILL NEED
        //#### TO BE CHNAGED FOR THE PARTICULAR SREVER
    //***************************************************************
	function connect() {
		
		
		$this->conn = imap_open(
			'{'.$this->server.'/notls}'.$this->mailType, 
			$this->user, 
			$this->pass
		);		
	}

	//***************************************************************
        //#### REQUIRED MOVE THE MESSAGE TO A ANEW FOLDER
    //***************************************************************
	function move($msg_index, $folder='INBOX.Processed') {
		// move on server
		imap_mail_move($this->conn, $msg_index, $folder);
		imap_expunge($this->conn);

		// re-read the inbox
		$this->inbox();
	}

	//***************************************************************
        //#### REQUIRED GET A SPECIFIC MESSAGE
        //#### (1 = FIRST EMAIL)
        //#### (2 = SECONDFIRST EMAIL)
        //#### (ETC = FIRST EMAIL)
    //***************************************************************
	function get($msg_index=NULL) {
		if (count($this->inbox) <= 0) {
			return array();
		}
		elseif ( ! is_null($msg_index) && isset($this->inbox[$msg_index])) {
			return $this->inbox[$msg_index];
		}

		return $this->inbox[0];
	}


    //***************************************************************
        //#### REQUIRED READ THE INBOX
        //#### COUNT INBOX THROUGH SEEN || UNSEEN , OTHERS
    //***************************************************************
    public function emailCounter()
    {
        echo $this->msg_cnt = count(imap_search($this->conn,$mailType)); exit;
    }

	//***************************************************************
        //#### REQUIRED READ THE INBOX
        //#### READ INBOX THROUGH SEEN || UNSEEN , OTHERS
    //***************************************************************
	public function inbox( $mailType = null, $mail_category = null, $loopCount = 50 )
	{
	    
	    //$this->msg_cnt = imap_num_msg($this->conn);
		
		//$this->msg_cnt = count(imap_search($this->conn,'UNSEEN'));
		
		$this->msg_cnt = count(imap_search($this->conn,$mailType));
		
		//***************************************************************
            //#### PROBLEM FOUND UNDER THIS CODE 
            //#### WHEN SINGLE EMAIL IS REST THAN NO ABILITY TO DOWNLOAD
            //#### NOW RESOLVED IT
        //***************************************************************
		$emails = imap_search($this->conn,$mailType);
		
		//echo $this->msg_cnt .' -- ' . $mailType;
		
		$in = array();
		if( $this->msg_cnt > 0 )
		{
			if( $mailType == 'UNSEEN' )
			{
			    
				$in = $this->getUnSeenEmails( $mailType , $this->msg_cnt ,  $mail_category , $emails );
			
                //***************************************************************
                    //#### REQUIRED UNSEEN EMAILS
                //***************************************************************
				$this->inbox = $in;
			}
		    
			if( $mailType == 'ALL' )
			{
				$in = $this->getAllEmails( $mailType , $this->msg_cnt , $mail_category , $emails, $loopCount );
				
				//***************************************************************
                    //#### REQUIRED ALL EMAILS
                //***************************************************************
				$this->inbox = $in;
			}
			
			if( $mailType == 'UNFLAGGED' )
			{
			    
				$in = $this->getAllEmails( $mailType , 10 , $mail_category , $emails, $loopCount );
				
				//***************************************************************
                    //#### REQUIRED ALL EMAILS
                //***************************************************************
				$this->inbox = $in;
			}
		}
		else
		{
			//***************************************************************
                //#### REQUIRED NOTHING FOUND
            //***************************************************************   
			$this->inbox = array();
		}
		
	
        
      //echo '<pre>';  print_r( $this->inbox); die;
        
	    return $this->inbox;	
	}
	
	public function setSeenEmail($value = null){
	    // Setting flag from un-seen email to seen on emails ID.
        imap_setflag_full($this->conn, $value, "\\Seen \\Flagged"); //IMPORTANT
        imap_expunge($this->conn);
	}
	
	public function setUnSeenEmail($value = null){
	    // Setting flag from un-seen email to seen on emails ID.
        imap_clearflag_full($this->conn, $value, '\\Seen \\Flagged');
        imap_expunge($this->conn);
	}
	
	public function setSeen($getemailData) {
	    
	    //**************** check 
         
        $ids = array();
        foreach($getemailData as $key => $mail) {
            
            
            $ids [] = $mail;
            
            // Setting flag from un-seen email to seen on emails ID.
            //$status = imap_setflag_full($this->conn , $mail['index'], "\\Seen \\Flagged"); 
            
            //imap_clearflag_full($this->conn, $mail['index'], '\\Seen \\Flagged');
        }
        
        // Setting flag from un-seen email to seen on emails ID.
        //$status = imap_setflag_full($this->conn , 3, "\\Seen \\Flagged"); 
        
        //IMPORTANT
        // colse the connection
        imap_expunge($this->conn);
          
        //echo "<pre>";
        //print_r($getemailData);
        //exit;
        
	    
	}
	
	public function getUnSeenEmails( $mailType = null , $msg_cnt = null , $mail_category = null , $mailread = null)
	{
	    
		for($i = 0; $i < $msg_cnt; $i++)
		{			
		    
			//***************************************************************
                //#### REQUIRED CHECK HEADER
            //***************************************************************
			$headers = EmailReader::chkHeaders( $mailread[$i] );
			
			//***************************************************************
                //#### REQUIRED CHECK UNSEEN
            //***************************************************************
			if( $mailType === "UNSEEN" )
			{
				if( $this->checkUnSeen($headers->Unseen) == 1 )
				{
					$in[] = $this->getEmailArray( $mailread[$i] , $mail_category);	
				}
			}
			else
			{
				//***************************************************************
                    //#### REQUIRED SEENS
                //***************************************************************
				//$in[] = $this->getEmailArray( $i , $mail_category );	
				
				$in[] = $this->getEmailArray( $mailread[$i] , $mail_category );	
			}
		}
		
	return $in;	
	}
	
	//***************************************************************
        //#### REQUIRED UNSEEN
    //***************************************************************
	public function getAllEmails( $mailType = null , $msg_cnt = null ,$mail_category , $emails = null, $loopCount = null )
	{
	    unset($in);
	    $in = '';
	    
	    $in = array(); 
	    
		//for($i = 0; $i < $msg_cnt; $i++)
		
		for($i = 0; $i < $loopCount; $i++)
		{			
			//check headers
			$headers = EmailReader::chkHeaders( $emails[$i] );
			
			//check Unseen
			if( $mailType === "UNFLAGGED" )
			{
				
				if( isset($headers) && !empty($headers) )
				{
				    
				    //UNFLAGGED
				    $in[] = $this->getEmailArray( $emails[$i] , $mail_category );
				    
				}
                
			}
			
			/*//check ALL
			if( $mailType === "ALL" )
			{
			    
			    if( isset($headers) && !empty($headers) )
			    {
				    //Seen ALL
				    $in[] = $this->getEmailArray( $emails[$i] , $mail_category );	
			    }
			}*/
		}
		
	return $in;	
	}
	
	//get mail box
	public function getMailBoxes()
	{
		$list = imap_list($this->conn, "{".$this->server."}", "*");
		if (is_array($list)) {
			foreach ($list as $val) {
				$this->mailBoxes[] = imap_utf7_decode($val);				
			}
		} else {
			$this->mailBoxes[0] = "imap_list failed: " . imap_last_error() . "n";
		}
	return $this->mailBoxes;
	}
	
	//***************************************************************
        //#### REQUIRED GET EMAIL THROUGH THESE FLAGS
    //***************************************************************
	
    #ALL - return all messages matching the rest of the criteria
    #ANSWERED - match messages with the \\ANSWERED flag set
    #BCC "string" - match messages with "string" in the Bcc: field
    #BEFORE "date" - match messages with Date: before "date"
    #BODY "string" - match messages with "string" in the body of the message
    #CC "string" - match messages with "string" in the Cc: field
    #DELETED - match deleted messages
    #FLAGGED - match messages with the \\FLAGGED (sometimes referred to as Important or Urgent) flag set
    #FROM "string" - match messages with "string" in the From: field
    #KEYWORD "string" - match messages with "string" as a keyword
    #NEW - match new messages
    #OLD - match old messages
    #ON "date" - match messages with Date: matching "date"
    #RECENT - match messages with the \\RECENT flag set
    #SEEN - match messages that have been read (the \\SEEN flag is set)
    #SINCE "date" - match messages with Date: after "date"
    #SUBJECT "string" - match messages with "string" in the Subject:
    #TEXT "string" - match messages with text "string"
    #TO "string" - match messages with "string" in the To:
    #UNANSWERED - match messages that have not been answered
    #UNDELETED - match messages that are not deleted
    #UNFLAGGED - match messages that are not flagged
    #UNKEYWORD "string" - match messages that do not have the keyword "string"
    #UNSEEN - match messages which have not been read yet
	
	/*
		@params : null
		return true / false on UNEEEN flag	
	*/
	public function getUnSeen()
	{		
		$count = imap_num_msg($this->conn);
		for($msgno = 1; $msgno <= $count; $msgno++)
		{
			$headers = imap_headerinfo($this->conn, $msgno);
			if($headers->Unseen == 'U') {
			   
			}	   
		}		
	}	
	
	/*
	
		@params null
		return UNSEEN INT
	
	*/
	public function getCountUnseen()
	{
		$unread_emails = count(imap_search($this->conn,'UNSEEN'));				
	   return $unread_emails;	
	}
	
	/*	
		@params null
		return SEEN INT	
	*/
	public function getCountSeen()
	{
		$unread_emails = count(imap_search($this->conn,'UNSEEN'));		
		$emails = count(imap_search($this->conn,'ALL', SE_UID)) - $unread_emails;
	   return $emails;	
	}
	
	/*
		@params : Unseen parameters
		return boolean
		
	*/ 
	public function checkUnSeen( $unseenType = null )
	{
		if( $unseenType == 'U' )
		{
			return 1;
		}
		else
		{
			return 0;	
		}
	}
	
	/*
		@params : increament vars		
		return @mail[header] data
	*/
	private function chkHeaders( $inc = null )
	{
		$headers = imap_headerinfo($this->conn, $inc);
	    return $headers;	
	}
	
	/* 
     Get AttachMent Emails File
	*/
	
	public function getattachMent($k , $header , $structure , $body, $mail_category)
	{
		
		//getUdate
		$emailUdate = $header->udate;
		
		//set msg_id		
		$msgId = str_replace('>' ,'' , str_replace('<' ,'' ,$header->message_id)) . '_' . $mail_category;
		$mesgNo = str_replace(' ' ,'' , $header->Msgno);
		
		//$folder = $this->mailType;
		
		//attachment location name
		$attachmentLocationName = $msgId;
		
		//set structure
		$structure = $structure;
		
		
	 
		
		if(isset($structure->parts) && count($structure->parts) > 0) 
		{
			for($i = 0; $i < count($structure->parts); $i++) 
			{
				$attachments[$i] = array(
					'is_attachment' => false,
					'filename' => '',
					'name' => '',
					'attachment' => ''
				);

				if($structure->parts[$i]->ifdparameters) 
				{
					foreach($structure->parts[$i]->dparameters as $object) 
					{
						/* echo  $object->value;
						echo "<br/>"; */
						
						if(strtolower($object->attribute) == 'filename') 
						{
							$attachments[$i]['is_attachment'] = true;
							$attachments[$i]['name'] = $object->value;
						}
					}
				}
				
				if($structure->parts[$i]->ifparameters) 
				{
					foreach($structure->parts[$i]->parameters as $object) 
					{
						if(strtolower($object->attribute) == 'name') 
						{
							$attachments[$i]['is_attachment'] = true;
							$attachments[$i]['name'] = $object->value;
						}
					}
				}
				
				

           // echo '<pre>'; print_r($attachments); 
  

				if($attachments[$i]['is_attachment']) 
				{
					$attachments[$i]['attachment'] = imap_fetchbody($this->conn, $k, $i+1);

					
					if($structure->parts[$i]->encoding == 3) 
					{ 
						$attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
					}
					
					elseif($structure->parts[$i]->encoding == 4) 
					{ 
						$attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
						
					}
					elseif($structure->parts[$i]->parts[$i]->encoding == 3) 
					{ 
						$attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
					}
				}
			}
		
		   
		 
	
		
			for($k = 0; $k < count($structure->parts[$k]); $k++) 
			{
				$attachments[$k] = array(
					'is_attachment' => false,
					'filename' => '',
					'name' => '',
					'attachment' => ''
				);

              	// echo '<pre>';  print_r($structure->parts[$k]);
                if($structure->parts[$k]->parts[$k])  
                {
        				if($structure->parts[$k]->parts[$k]->parameters) 
        				{
        				
            				if($structure->parts[$k]->parts[$k]->parameters) 
            				{
            					foreach($structure->parts[$k]->parts[$k]->parameters as $object) 
            					{
            						if(strtolower($object->attribute) == 'name') 
            						{
            							$attachments[$k]['is_attachment'] = true;
            							$attachments[$k]['name'] = str_replace(' ', '' , str_replace('#' , '' ,$object->value));
            						}
            					}
            				}
        				}
                }
			}
		
		
	       	$getName = array();
		    
		    if( $mail_category == 'missing' ) {
		        foreach($attachments as $attachment)
			{
				if($attachment['is_attachment'] == 1)
				{
				    $uk = uniqid() . '_'; 
					$file_name = $uk . $attachment['name'];
					$getName['fileattach'][] = $file_name;
					$getName['attachment'] = $attachment['attachment'];
					//$getName['attachmentLocationName'] = $attachmentLocationName;
					$getName['attachmentLocationName'] = $mail_category.'/'.$mesgNo;
					$extension= end(explode(".", $file_name));
					
					$categoryfolder = $_SERVER['DOCUMENT_ROOT'].'/mail/mail_attachments/'.$mail_category;
						if(!is_dir($categoryfolder))
						{
							mkdir($categoryfolder);
						}
					
					
					$folder = $_SERVER['DOCUMENT_ROOT'].'/mail/mail_attachments/'.$mail_category.'/'.$mesgNo;
						if(!is_dir($folder))
						{
							mkdir($folder);
						}
					
					$fp = fopen($folder ."/". $file_name, "w+");
					
					fwrite($fp, $attachment['attachment']);
					fclose($fp);
					
					//echo $folder ."/". $file_name;
					//echo "<br />";
					
					
				}
			}
		    } else {
		        foreach($attachments as $attachment)
			{
				if($attachment['is_attachment'] == 1)
				{
				    $uk = uniqid() . '_';
					$file_name = $uk . $attachment['name'];
					$getName['fileattach'][] = $file_name;
					$getName['attachment'] = $attachment['attachment'];
					//$getName['attachmentLocationName'] = $attachmentLocationName;
					$getName['attachmentLocationName'] = $mail_category.'/'.$mesgNo;
					
					
					  $exp = explode(".", $file_name);
                            $extension = end($exp);
					
				//	$extension= end(explode(".", $file_name));
					//$extension= end(explode(".", $file_name));
					
					$categoryfolder = $_SERVER['DOCUMENT_ROOT'].'/mail/mail_attachments/'.$mail_category;
						if(!is_dir($categoryfolder))
						{
							mkdir($categoryfolder);
						}
					
					
					$folder = $_SERVER['DOCUMENT_ROOT'].'/mail/mail_attachments/'.$mail_category.'/'.$mesgNo;
						if(!is_dir($folder))
						{
							mkdir($folder);
						}
					
					$fp = fopen($folder ."/". $file_name, "w+");
					
					fwrite($fp, $attachment['attachment']);
					fclose($fp);
					
				//	echo $folder ."/". $file_name;
					//echo "<br />";
					
					
				
					
				}
			}
		    }
					
		}
	
	 
    // print_r($getName);	
		
	  return $getName; 	
	}
	
	
	
	
	/*  
	
		@params, INC
		return Email Array	
	
	*/
	public function getEmailArray( $i = null , $mail_category )
	{		
	
		//get header
		
		$allcon  =$this->conn;
		//print_r($this->mailType); die;
		
		$header = imap_headerinfo($this->conn, $i);
		
		//check attachment header
		$structure = imap_fetchstructure($this->conn, $i);  
		//echo "<pre>";
		//print_r($structure);
		
		//imap_uid 
		//get body
		//$body = imap_body($this->conn, $i);
		//$body = imap_fetchbody($this->conn,$i,2);
		
		$body = $this->getBody($i, $this->conn);
		
		// Setting flag from un-seen email to seen on emails ID.
        //imap_setflag_full($emailReader, '16', '\\Seen');
        
        //echo "<pre>";
		//print_r($structure); die;
		
		
		
		//check if sub [Parts]->[Parts] does exists then will trigger to download.
		if( isset($structure->parts) )
		{
    		if( is_array( $structure->parts ) && count( $structure->parts ) > 1 )
    		{	
    			if( isset( $structure->parts[0]->parts ) )
    			{
    				//invoke attachment func
    				$getAttach =  $this->getattachMent ($i , $header , $structure , $body , $mail_category );
    			} else {
    			    //invoke attachment func
    				$getAttach =  $this->getattachMent ($i , $header , $structure , $body , $mail_category );
    			}			
    		} else {
    		    $getAttach =  $this->getattachMent ($i , $header , $structure , $body , $mail_category );
    		}
		}
		
		if( !empty($getAttach) )
		{
			return array(
				'index'     => $i,
				'header'    => $header,
				'body'      => $body,
				'structure' => $structure,
				'file_attach' => $getAttach
			);	
		}
		else{
			return array(
				'index'     => $i,
				'header'    => $header,
				'body'      => $body,
				'structure' => $structure				
			);	
		}		 
	}
	
	
	function getBody($uid, $imap)
	{
		
		//echo "text"; die;
		$body = $this->get_part($imap, $uid, "TEXT/HTML");
		
		// if HTML body is empty, try getting text body
		if ($body == "") {
			$body = $this->get_part($imap, $uid, "TEXT/PLAIN");
		}
		
	return $body;
	}

	function get_part($imap, $uid, $mimetype, $structure = false, $partNumber = false)
	{
	    
		if (!$structure) {
			$structure = imap_fetchstructure($imap, $uid);
		}
		
		if ($structure) { 
			
			//echo $this->get_mime_type($structure).'===='.$mimetype; die;
			
			//echo $mimetype .'=='. $this->get_mime_type($structure);
			//echo "<br />";
			
			if ($mimetype == $this->get_mime_type($structure)) {
				if (!$partNumber) {
					$partNumber = 1;
				}
				$text = imap_fetchbody($imap, $uid, $partNumber);
				switch ($structure->encoding) {
					case 3:
						return imap_base64($text);
					case 4:
						return imap_qprint($text);
					default:
						return $text;
				}
			}

			// multipart
			if ($structure->type == 1) {
			    
			    
				foreach ($structure->parts as $index => $subStruct) {
					$prefix = "";
					if ($partNumber) {
						$prefix = $partNumber . ".";
					}
					
					$data = $this->get_part($imap, $uid, $mimetype, $subStruct, $prefix . ($index + 1));
					
					if ($data) {
						return $data;
					}
				}
			}
		}
		return false;
	}

	function get_mime_type($structure)
	{
		$primaryMimetype = ["TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER"];

		if ($structure->subtype) {
			return $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
		}
		return "TEXT/PLAIN";
	}
	
	
	function email_get_rs_value($table,$field,$wherecond){
	
    	$tr_desc_sql = "SELECT $field FROM $table where id=".mysql_real_escape_string($wherecond);
    	//echome($tr_desc_sql);
    	$tr_data = mysql_query($tr_desc_sql);
    	if (mysql_num_rows($tr_data)>0){
    		$cat_name = mysql_result($tr_data, 0, $field);
    	}else{
    		$cat_name ="";
    	}
    	return $cat_name;
     } 
	
	public function setEmailMsgForNewInsertionByReader($mail_type, $value, $mailfolderName ,$jobid= null ,$textdata = null )
	{
	    
		$arg = '';
		$headervalue = $value['header'];
		if($mailfolderName == 'INBOX') {
			$maildata = $headervalue->date;
			$email_assign = 1;
		}else if($mailfolderName == 'Sent'){
			$maildata = $headervalue->MailDate;
			$email_assign = 3;
		}

        $bccaddress = $headervalue->bccaddress;
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
		
		$emailCat = 0;
		$mailflagdata = 'INBOX';
		
		if($_SESSION['admin'] != '') {
		 
		    $email_send_admin_id = $_SESSION['admin'];
		   $staff_name = $this->email_get_rs_value("admin","name",$_SESSION['admin']);
		   
		    if($textdata != '') {
		   
		        $heading = " Send ".$textdata." By ".$staff_name;
		        $mailflagdata = $textdata;
		    }else {
		        $heading = " Send Email By ".$staff_name;
		    }
		}else {
		    $email_send_admin_id = 0;
		    $heading = 'Get Email from server';
		}
		
		
		
		if( strtolower($mail_type) == 'reviews' ) {
			$emailCat = 11;
		}
		
		if( strtolower($mail_type) == 'team' ) {
			$emailCat = 10;
		}
		
		if( strtolower($mail_type) == 'support' ) {
			$emailCat = 3;
		}
		
		if( strtolower($mail_type) == 'hr' ) {
			$emailCat = 5;
		}
		
		if( strtolower($mail_type) == 'voicemsg' ) {
			$emailCat = 9;
		}
		
		if( strtolower($mail_type) == 'reclean' ) {
			$emailCat = 4;
		}
		
		if( strtolower($mail_type) == 'quote' ) {
			$emailCat = 1;
		}
		
		$arg .= "INSERT INTO `bcic_email`
				(
				 `mail_type`,`email_date`, `email_assign`,
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
				 `email_udate`, `email_body`,`mail_flag`,
				 `quote_id`, `job_id`,`bccaddress` ,`email_send_admin_id`,
				 `staff_id`, `createdOn`, `email_category`
				) 
				VALUES ";  
				
			$arg .= " (
				'".$mail_type."','".$maildata."', '".$email_assign."',
				'".$mailfolderName."', '".addslashes($headervalue->subject)."', '".addslashes(str_replace('Re: ','', $headervalue->subject))."', 
				'".$headervalue->message_id."', '".addslashes($headervalue->references)."',
				'".addslashes($headervalue->toaddress)."', 'fdfdf',
				'".addslashes($headervalue->fromaddress)."','".addslashes($fromMsg)."', 
				'".addslashes($headervalue->reply_toaddress)."', '".addslashes($replyMsg)."',
				'dfdf', '".addslashes($headervalue->senderaddress)."', 
				'".$senderMsg."', '".$headervalue->Recent."',
				'".$headervalue->Unseen."','".$headervalue->Flagged."', 
				'".$headervalue->Answered."','".$headervalue->Deleted."',
				'".$headervalue->Draft."','".trim($headervalue->Msgno)."',
				'".$headervalue->MailDate."', '".$headervalue->Size."', 
				'".$headervalue->udate."','".addslashes($mailBody)."', '".$mailflagdata."',
				'0','".$jobid."','".$bccaddress."','".$email_send_admin_id."' ,
				'0','".date('Y-m-d H:i:s', strtotime($maildata))."',
				'".$emailCat."'
			)";	
		
	//	echo $arg."<br/><br/>";
		
		$bcicemail = mysql_query($arg);
		
                $email_id =  mysql_insert_id();	
                
                 $this->add_emailnotes($email_id , trim($headervalue->Msgno) ,$mail_type , $heading , $heading );
                 
        if($textdata != '') {
			
			if($_SESSION['lastemailis'] != '') {
				$getdata = mysql_fetch_array(mysql_query("SELECT * FROM `temp_email_activity` WHERE id = ".$_SESSION['lastemailis'].""));
				
				if(!empty($getdata)) {
					
					    $staff_name = $this->email_get_rs_value("admin","name",$_SESSION['admin']);
					
						$ins_arg="insert into  email_activity set email_id=".$email_id.",";
						$ins_arg.=" date_time='".$getdata['start_time']."',";
						$ins_arg.=" open_time='".$getdata['start_time']."',";
						$ins_arg.=" closed_time='".date('0000-00-00 00:00:00')."',";
						$ins_arg.=" activity='".$getdata['activity']."',";
						$ins_arg.=" comment='".$getdata['activity']."',";
						$ins_arg.=" staff_id='".$getdata['staff_id']."',";
						$ins_arg.=" p_id='0',";
						$ins_arg.=" staff_name='".$staff_name."'";
						//echo $ins_arg.'<br/>';  
						$ins = mysql_query($ins_arg);
						unset($_SESSION['lastemailis']);
				}
			}
			
	        $activitytext = "Send ".$textdata." Email";
	        $comment =  "Send ".$textdata." Email";
	        $this->addemailactivity($email_id, $activitytext, $comment , addslashes($headervalue->toaddress) , 1 , $email_id , '');
			
			$activitytext1 = "Closed Email";
	        $comment1 =  "Closed Email";
			
	        $this->addemailactivity($email_id, $activitytext1, $comment1 , '' , 0 ,$email_id , date("Y-m-d H:i:s"));
	    }
                
                return  $email_id;
	}
	
	
	function addemailactivity($email_id, $activitytext, $comment , $toaddress ,$issend , $pid1 = 0 , $closetime = ''){
	
		$time = date("Y-m-d H:i:s");
		
		if($closetime != '') {
		    
		     $closetime = $closetime;
		     
		}else{
		    $closetime = date('0000-00-00 00:00:00');
		}
		
		
		if($pid1 == 0)	 {
			if($_SESSION['open_email'] != '') {
				
				$pid = $_SESSION['open_email'];
			}else{
				$pid = 0;
			}
		}else {
			$pid = $pid1;
		}
		
		 $staff_id = $_SESSION['admin'];
		 $staff_name = $this->email_get_rs_value("admin","name",$_SESSION['admin']);
		
		$ins_arg="insert into email_activity set email_id=".$email_id.",";
		$ins_arg.=" date_time='".$time."',";
		$ins_arg.=" open_time='".$time."',";
		$ins_arg.=" closed_time='".$closetime."',";
		$ins_arg.=" activity='".$activitytext."',";
		$ins_arg.=" comment='".mysql_real_escape_string($comment)."',";
		$ins_arg.=" staff_id='".$staff_id."',";
		$ins_arg.=" emailids='".$toaddress."',";
		$ins_arg.=" is_sent='".$issend."',";
		$ins_arg.=" p_id='".$pid."',";
		$ins_arg.=" staff_name='".$staff_name."'";
		//echo $ins_arg.'<br/>';  
		$ins = mysql_query($ins_arg);
		
	}	
	
	 public function add_emailnotes($email_id , $email_msg_no ,$mail_type , $heading , $comment ){
	    
	    
    	    if($_SESSION['admin'] != '') {
    		 
    		   // $email_send_admin_id = $_SESSION['admin'];
    		   $staff_name = $this->email_get_rs_value("admin","name",$_SESSION['admin']);
    		   $login_id = $_SESSION['admin'];
    		}else {
    		    $login_id = 0;
    		    $staff_name = 'Automated';
    		}
	    
                    $customDate = date("Y-m-d H:i:s");
                    
                    //$staff_name = 'Email';
                    
                    $ins_arg="insert into email_notes set email_id=".$email_id.",";
                    $ins_arg.=" date='".$customDate."',";
                    $ins_arg.=" email_msg_no='".$email_msg_no."',";
                    $ins_arg.=" mail_type='".$mail_type."',";
                    $ins_arg.=" heading='".mysql_real_escape_string($heading)."',";
                    $ins_arg.=" comment='".mysql_real_escape_string($comment)."',";
                    $ins_arg.=" login_id='".$login_id."',";
                    $ins_arg.=" staff_name='".$staff_name."'";
                    //echo $ins_arg.'<br/>';  
                    $ins = mysql_query($ins_arg);
	}
	
	
	//****************************************
	    //#### RETREIVE SPECIFIC EMAIL BY EMAIL | MSGNO
	//****************************************
	function retrieve_message($messageid , $mail_category)
    {
        
       //HOLD CONNECTION WHILE GETTING THE MESSAGE DATA    
       $mbox = $this->conn;    
       $message = array();
        
        /*$MC = imap_check($mbox);
        
        // Fetch an overview for all messages in INBOX
        $result = imap_fetch_overview($mbox,"1:{$MC->Nmsgs}",0);
        foreach ($result as $overview) {
            echo "#{$overview->msgno} ({$overview->date}) - From: {$overview->from}
            {$overview->subject}";
            echo "<br />";
        }
        
        imap_close($mbox);    
        
        exit;*/
       
       $header = imap_header($mbox, $messageid);
       $structure = imap_fetchstructure($mbox, $messageid);
       $body = $this->getBody($messageid, $this->conn);
       
       if( isset($structure->parts) )
		{
    		if( is_array( $structure->parts ) && count( $structure->parts ) > 1 )
    		{	
    			if( isset( $structure->parts[0]->parts ) )
    			{
    				//invoke attachment func
    				$getAttach =  $this->getattachMent ($messageid , $header , $structure , $body , $mail_category );
    			} else {
    			    //invoke attachment func
    				$getAttach =  $this->getattachMent ($messageid , $header , $structure , $body , $mail_category );
    			}			
    		} else {
    		    $getAttach =  $this->getattachMent ($messageid , $header , $structure , $body , $mail_category );
    		}
		}
		
		if( !empty($getAttach) )
		{
			return array(
				'index'     => $messageid,
				'header'    => $header,
				'body'      => $body,
				'structure' => $structure,
				'file_attach' => $getAttach
			);	
		}
		else{
			return array(
				'index'     => $messageid,
				'header'    => $header,
				'body'      => $body,
				'structure' => $structure				
			);	
		}		
       
       
       
       
       	/*return array(
				'index'     => $messageid,
				'header'    => $header,
				'body'      => $body,
				'structure' => $structure				
			);	*/
       
        
     
    }
    
    function check_type($structure) ## CHECK THE TYPE
    {
      if($structure->type == 1) 
        {
         return(true); ## YES THIS IS A MULTI-PART MESSAGE
        }
    else
        {
         return(false); ## NO THIS IS NOT A MULTI-PART MESSAGE
        }
    }
	
}
?>