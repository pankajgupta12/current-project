<?php 

include($_SERVER['DOCUMENT_ROOT'].'/admin/class/SysImap.php');
include($_SERVER['DOCUMENT_ROOT'].'/admin/class/MailAccount.php');


//get Domains
$_SESSION['MAIL_SERVER']['MAIL_DOMAIN'] = MailAccount::getDomains( 'MAIL_DOMAIN' );
$_SESSION['SERVER']['HOST']['KEYS'] = MailAccount::getMailServerByName( 'B2s' );
$_SESSION['_access_server'] = 'b2s';

echo "<pre>";

print_r($_SESSION['MAIL_SERVER']['MAIL_DOMAIN']);

print_r($_SESSION['SERVER']['HOST']['KEYS']);

print_r(array_keys( $_SESSION['SERVER']['HOST']['KEYS']['B2S_ACCESS'] ));

//exit;
//check IMAP to retreive mails
//$sysImapObj = new SysImap();
//$sysImapObj->getUnreadEmail( "INBOX" , $_SESSION['MAIL_SERVER']['MAIL_DOMAIN']['B2S'] );

?>