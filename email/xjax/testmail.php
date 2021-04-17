<?php


if (!class_exists('PHPMailer')) {
    require_once($_SERVER["DOCUMENT_ROOT"].'/mail/phpmail/class.phpmailer.php');
  }

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(); // telling the class to use SMTP

//echo $serverName .'=='.$user_email.'=='.$serverName .'=='.$user_password .'=='.$to.'=='.$cc .'=='.$bcc.'=='.$subject .'=='.$msgbody  die;

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
		
		

		$mail->SetFrom($user_email, 'BCIC MAIL');
		$mail->Subject = $subject;
		$mail->MsgHTML($msgbody);
		// $mail->AddAttachment('images/phpmailer.gif');      // attachment
		//$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
		//print_r($mail->Send());
		//$mail->Send();
		
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
?>