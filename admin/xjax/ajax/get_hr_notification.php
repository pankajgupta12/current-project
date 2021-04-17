<?php 

//print_r($_POST);
session_start();
include("../../source/functions/functions.php");
include("../../source/functions/config.php");
       if($_POST['q_id'] != '') {
        $var  = $_POST['q_id'];
		$exclude_ntfn = $var;
		include $_SERVER['DOCUMENT_ROOT']. '/hr_sms/vpb_incoming_messages.php';
	   }
?>