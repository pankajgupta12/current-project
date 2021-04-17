<?php  
session_start(); 
//include('googleShortUrl.php');
include("../../admin/source/functions/functions.php");
include("../../admin/source/functions/config.php");
include("../../mail/source/functions/bcic_mail_functions.php");

 	
    if(isset($_FILES)) {
		
		$file_count = count($_FILES['file']['name']);
		//echo $file_count; die;
		$allimg = array();
          for($i = 0; $i< $file_count; $i++) {
							
				$filename = $_FILES['file']['name'][$i];
				
				$extension= end(explode(".", $filename));
				$min_rand=rand(0,1000);
				$max_rand=rand(10000000,1000000000000);		
                $name_file=rand($min_rand,$max_rand);//this part is for creating random name for image		
                $last_filename = $name_file.time().'.'.$extension;				
							
				
				//echo $filename; 
			    $path = '../sent_attachment/'.$last_filename;
				
				if($_FILES['file']['name'][$i] != '' ) {
				  $allimg[] = $last_filename;
				}
				
				move_uploaded_file($_FILES["file"]["tmp_name"][$i], $path); 
							
		}  
	}
	
    if(isset($_POST)){
		
		//print_r($_POST); die;
		
		// $_SESSION['sent_new_msg_type'] = '';
		 $_SESSION['email_folder']  =  'Sent';
		 
		 $totype = $_POST['sent_new_msg_type'];
		 $msgNo =  $varx[1];
		
		 $getEmailHost  = mysql_fetch_assoc(mysql_query("SELECT *  FROM `email_config` WHERE `email_type` = '".$totype."'"));
		 //print_r($getEmailHost);  die;
		 $to = ($_POST['to_email']);
		 $bcc = mysql_real_escape_string($_POST['bcc_email']);
		 $cc = ($_POST['cc_email']);
		 $subject = mysql_real_escape_string($_POST['bcic_subject']);
		 $msgbody = $_POST['all_message_body'];		 
		 $mailFolder = $varx[7];
		 $serverName = trim($getEmailHost['server_name']);
		 $user_password = trim($getEmailHost['user_password']);
		 $user_email = trim($getEmailHost['user_email']);
		 $date = date('Y-m-d H:i:s');
		 
	    $is_attch = ($_POST['is_attch']);
		$email_folder = ($_POST['email_folder']);
		  
		  
		 // print_r($email_folder); die;
		  
		$mail_typefolder = 'INBOX.Sent';
		$mailfolderName = 'Sent';

		$rootMailBox = "{bcic.com.au/notls}";
		$draftsMailBox = $rootMailBox . $mail_typefolder;
  
     	
		
		$stream = imap_open ($rootMailBox, $user_email, $user_password) or die("can't connect: " . imap_last_error());
		$check = imap_check($stream);
		
		
		
			$dmy=date("d-M-Y H:i:s"); 
			$dmy.= " +0100"; // Had to do this bit manually as server and me are in different timezones 
		 	$stream = imap_open ($rootMailBox, $user_email, $user_password) or die("can't connect: " . imap_last_error());
			$boundary = "------=".md5(uniqid(rand())); 
			$boundary2 = "###".md5(microtime().rand(99,999))."###"; 
			
			$header = "MIME-Version: 1.0\r\n"; 
			$header .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n"; 
			$header .= "\r\n"; 

		    if(!empty($allimg)) {
				foreach($allimg as $key=>$imgfile) {
							
						$file = $_SERVER['DOCUMENT_ROOT'].'/mail/sent_attachment/'.$imgfile; 
						$filename= $imgfile; 
						$ouv=fopen ("$file", "rb");
						$lir=fread ($ouv, filesize ("$file"));fclose 
						($ouv); 
						
						 
						
						
						$attachment = chunk_split(base64_encode($lir)); 
						$msg2 .= "--$boundary\r\n"; 
						$msg2 .= "Content-Transfer-Encoding: base64\r\n"; 
						$msg2 .= "Content-Disposition: attachment; filename=\"$filename\"\r\n"; 
						$msg2 .= "\r\n"; 
						$msg2 .= $attachment . "\r\n"; 
						$msg2 .= "\r\n\r\n"; 
						$msg2 .="--$boundary\r\n";
				}
		    }
			
			
			if(!empty($is_attch)) {
				foreach($is_attch as $key2=>$attchfile) {
											
							
						$is_file = $_SERVER['DOCUMENT_ROOT'].'/mail/mail_attachments/'.$email_folder[$key2].'/'.$attchfile; 
						$isfilename= $attchfile; 
						$ouv1=fopen ("$is_file", "rb");
						$lir1=fread ($ouv1, filesize ("$is_file"));fclose 
						($ouv1); 
						
						$is_attachment = chunk_split(base64_encode($lir1)); 
						$msg2 .= "--$boundary\r\n"; 
						$msg2 .= "Content-Transfer-Encoding: base64\r\n"; 
						$msg2 .= "Content-Disposition: attachment; filename=\"$isfilename\"\r\n"; 
						$msg2 .= "\r\n"; 
						$msg2 .= $is_attachment . "\r\n"; 
						$msg2 .= "\r\n\r\n"; 
						$msg2 .="--$boundary\r\n";
				}
		    }
			 
			 
			
			if($msgbody != '') {			
				$msg = '';
				$msg .= "--$boundary\r\n";
				$msg .= "\r\n\r\n"; 
				$msg .= html_entity_decode(removeStripslashes($msgbody))."\r\n";
				$msg .= "\r\n\r\n";
			}else {
			  $msg = "";	
			} 
			
	
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
					
					
					$mail->AddReplyTo($user_email, 'BCIC');
					
					
					$emailto = $to;
					
					foreach($emailto as $valueto) {
					  $mail->AddAddress($valueto);
					}
					
					
				if($cc != '') {
				    $ccdetails = explode(',' , $cc);
						if(!empty($ccdetails)) {
							foreach($ccdetails as $key=>$cc1) {
							  $mail->AddCC($cc1);  
							}
						}
						
				}
				
					if($bcc != '') {
					  $mail->AddBCC($bcc);
					}
					
					$mail->SetFrom($user_email, 'Bcic Bond Cleaning');
					$mail->Subject = $subject;
					$mail->MsgHTML(removeStripslashes($msgbody));
					
					
				if(!empty($allimg)) {
					foreach($allimg as $key=>$imgvalue) {	
						$mail->AddAttachment($_SERVER['DOCUMENT_ROOT'].'/mail/sent_attachment/'.$imgvalue); 
					}  
				}
				
				   if(!empty($is_attch)) {
						foreach($is_attch as $key1=>$attchfile) {
							$mail->AddAttachment($_SERVER['DOCUMENT_ROOT'].'/mail/mail_attachments/'.$email_folder[$key1].'/'.$attchfile); 		
						}
				    }	
					
					if(!$mail->Send())
					{
						/* echo "Message could not be sent.";
						echo "Mailer Error: " . $mail->ErrorInfo;
						exit; */
						
						echo json_encode(array('status' => '0', 'message' => $mail->ErrorInfo));
							exit;
					}else{
						
						foreach($emailto as $valueto1) {
							imap_append($stream,$draftsMailBox
							, "From: ".$user_email."\r\n"
							. "To: ".$valueto1."\r\n"
							."Date: ".$dmy."\r\n"
							. "Subject: ".$subject."\r\n"
							."$header\r\n"
							."$msg\r\n"
							."$msg2\r\n"
							."$msg3\r\n"); 
							//echo "Message has been sent";
						}	
						
							imap_close ($stream); 	
							
							
							$emailConcat = $getEmailHost['email_type'];
							
							echo json_encode(array('status' => '1', 'message' => 'Mail has been sent' , 'type' => $emailConcat));
					}
				
			} catch (phpmailerException $e) {
				echo json_encode(array('status' => '0', 'message' => $e->errorMessage()));
			  //echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
				echo json_encode(array('status' => '0', 'message' => $e->errorMessage()));
			  //echo $e->getMessage(); //Boring error messages from anything else!
			}
		
	}


?>