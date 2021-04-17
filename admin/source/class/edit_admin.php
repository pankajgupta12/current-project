<?php
	// ?task=4&action=modify&id=62
	// echo "This is edit staff";
	$t="21";
	$a="modify";	
	//if($_REQUEST['step']=="1"){ echo "form is submited"; }
	
	$argx = "select * from admin_module_details where module_id=".$t;
	//echo $argx; echo $a;	
	$datax = mysql_query($argx);
	//echo "rows".mysql_num_rows($datax);
	if (mysql_num_rows($datax)>0){ 
		include("source/general_auto.php");
	}else{
		echo "Cant Find this Task";	
	}

	// print_r($_REQUEST)
	
$staffid = $_REQUEST['id'];
$site_id = get_rs_value("staff","site_id",$staffid);		
?>
<script>
$(document).ready(function(){
    get_staff_fixed_rates('<?php echo $site_id; ?>');
})
</script>