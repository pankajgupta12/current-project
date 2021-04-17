<?php  

session_start();
include("../source/functions/functions.php");
include("../source/functions/config.php");

    $fromdate = $_POST['from_date'];
    $to_data = $_POST['to_data'];

	$_SESSION['dashboard_data']['from_date'] = $fromdate; 
	$_SESSION['dashboard_data']['to_date'] = $to_data; 
	
	include('view_dashboard_page.php');
	//echo 'fgfg';

?>