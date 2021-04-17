<?php 
//error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/admin/class/MailAccount.php');
include($_SERVER['DOCUMENT_ROOT'].'/admin/class/SysImap.php');

//get Domains
$_SESSION['MAIL_SERVER']['MAIL_DOMAIN'] = MailAccount::getDomains( 'MAIL_DOMAIN' );
$_SESSION['SERVER']['HOST']['KEYS'] = MailAccount::getMailServerByName( 'Bcic' );
$_SESSION['_access_server'] = 'Bcic';

/* echo "<pre>";

print_r($_SESSION['MAIL_SERVER']['MAIL_DOMAIN']);

print_r($_SESSION['SERVER']['HOST']['KEYS']);

print_r(array_keys( $_SESSION['SERVER']['HOST']['KEYS']['B2S_ACCESS'] )); exit; */

//echo "dfdfdf";  die;

//check IMAP to retreive mails
$sysImapObj = new SysImap();
//print_r($sysImapObj); 
$sysImapObj->getUnreadEmail( "INBOX" , $_SESSION['MAIL_SERVER']['MAIL_DOMAIN']['Bcic'] );


?>