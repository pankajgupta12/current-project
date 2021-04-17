<?php
require_once('../class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(); // telling the class to use SMTP

try {
  $mail->Host       = "bcic.com.au"; // SMTP server
  $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)  
  $mail->SMTPAuth   = true;                  // enable SMTP authentication
  
  //$mail->Host       = "mail.yourdomain.com"; // sets the SMTP server
  
  $mail->Port       = 25;     //465               // set the SMTP port for the GMAIL server
  $mail->Username   = "test_2@bcic.com.au"; // SMTP account username
  $mail->Password   = "test_2@123$321";        // SMTP account password
  $mail->AddReplyTo('test_2@bcic.com.au', 'First Reply');
  $mail->AddAddress('pankaj.business2sell@gmail.com', 'PANKJA');
  
  $mail->SetFrom('test_2@bcic.com.au', 'BCIC MAIL');
  
  //$mail->AddReplyTo('name@yourdomain.com', 'First Last');
  
  $mail->Subject = 'PHPMailer Test Subject via mail(), advanced By Pankaj Gupta & Ashish Sir';
  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML(file_get_contents('contents.html'));
  $mail->AddAttachment('images/phpmailer.gif');      // attachment
  $mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
  $mail->Send();
  echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}
?>