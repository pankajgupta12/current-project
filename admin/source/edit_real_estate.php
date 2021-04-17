<?php
	
	$t="23";
	$a="modify";	
	$argx = "select * from admin_module_details where module_id=".$t;
	//echo $argx; echo $a;	
	$datax = mysql_query($argx);
	//echo "rows".mysql_num_rows($datax);
	if (mysql_num_rows($datax)>0){ 
		include("source/general_auto.php");
	}else{
		echo "Cant Find this Task";	
	}


?>