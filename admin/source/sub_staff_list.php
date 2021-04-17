<?php
	// ?task=4&action=modify&id=62
	// echo "This is edit staff";
	$t="16";
	$a="list";	
	//if($_REQUEST['step']=="1"){ echo "form is submited"; }
	
	$argx = "select * from admin_module_details where module_id=".$t;
	//echo $argx; echo $a;	 die;
	$datax = mysql_query($argx);
	//echo "rows".mysql_num_rows($datax);
	if (mysql_num_rows($datax)>0){ 
		include("source/general_auto.php");
	}else{
		echo "Cant Find this Task";	
	}


?>