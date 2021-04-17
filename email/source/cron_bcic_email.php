<?php 
include 'functions/functions.php';
include($_SERVER['DOCUMENT_ROOT'].'/mail/classes/mails/EmailReader.php');

//use \Bcic\Outlook\Email\Sys;

//print_r($_GET); die;

if( isset($_GET['mail_type']) && $_GET['mail_type'] == 'test_1' )
$mail_type = 'test_1';

if( isset($_GET['mail_type']) && $_GET['mail_type'] == 'test_2' )
$mail_type = 'test_2';

if( isset($_GET['mail_type']) && $_GET['mail_type'] == 'test_4' )
$mail_type = 'test_4';

if( isset($_GET['mail_type']) && $_GET['mail_type'] == 'bookings' )
$mail_type = 'bookings';


/* $mail_typefolder = 'INBOX.Sent';
$mailfolderName = 'Sent'; */

if( isset($_GET['mail_folder']) && $_GET['mail_folder'] == 'INBOX' )
{	
	$mail_typefolder = 'INBOX';
	$mailfolderName = 'INBOX'; 
	$getMaildata = mysql_fetch_assoc(mysql_query("SELECT * FROM `email_config`WHERE email_type = '".$mail_type."'"));
}
else
{
	
	$mail_typefolder = 'INBOX.Sent';
	$mailfolderName = 'Sent'; 
	$getMaildata = mysql_fetch_assoc(mysql_query("SELECT * FROM `email_config`WHERE email_type = '".$mail_type."'"));
}

//$emailReader = new \Bcic\Outlook\Email\Sys\EmailReader(
$emailReader = new EmailReader(
	$getMaildata['server_name'],
	$getMaildata['user_email'],
	$getMaildata['user_password'],
	$getMaildata['server_port'],
	$mail_typefolder
);  

//to identify which email is going right now

//get inbox emails
//$getemailData = $emailReader->inbox('ALL',$mail_type);
//$getemailData = $emailReader->getMailBoxes('ALL');

 //echo "<pre>"; print_r($getemailData); die;

 // $fromEmail = $getemailData->['header']->fromaddress;
    
//Unseen 
$getemailData = $emailReader->inbox('UNSEEN');
echo "hello"; exit;

echo "<pre>";
print_r($getemailData);
exit;

    foreach($getemailData as $key=>$value)
	{
  		
  		//print_r($value['file_attach']);
  		
		//header array | std class object
		$headervalue = $value['header'];
		
		if($headervalue->Deleted != 'D') {
		//print_r($headervalue);
			$frommailBox = $headervalue->from[0]->mailbox;
			$fromhost = $headervalue->from[0]->host;
			$fromMsg =  $frommailBox.'@'.$fromhost;
			
			//echo  $mailfolderName.'<br/>';
			
			
			//check email once in our system if SEEN or UNSEEN
			$emailDbCountOnce = checkEmailInDb($mail_type, $headervalue->Msgno,$mailfolderName);
			//print_r($emailDbCountOnce);
			
			//If found the record, it will go for update the message body
			if( $emailDbCountOnce['id'] > 0 )
			{
				//echo $emailDbCountOnce['id']. "test";
				setEmailMsgBodyUpdate($mail_type , $value, $emailDbCountOnce['id']);
			}  
			
			//If nothing, then go for insertion as fresh email
			if( empty($emailDbCountOnce))
			{
				$insertID = setEmailMsgForNewInsertion($mail_type , $value, $mailfolderName);
			  
				//***************************************************************
					//#### REQUIRED UPDATE SEEN STATUS TO AFTER READING UNSEEN
				//***************************************************************
				if( $insertID > 0 ){
					$emailReader->setSeenEmail($value['index']);
				}
				
				if(!empty($value['file_attach'])) {
					setFileAttachmentInsertion($insertID,$mail_type , $value, $mailfolderName);
				}
			}		
			
			if($mailfolderName == 'INBOX') {
				CheckQuoteEmail($fromMsg , $mail_type, str_replace(' ','', $headervalue->Msgno), $mailfolderName);
			}
		}
    }
	
	$emailReader->close();

?>