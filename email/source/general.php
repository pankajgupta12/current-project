<?php 

if($_REQUEST['task']=="bcic_email"){ include("source/mails.php");
}elseif($_REQUEST['task']=="cron_bcic_email"){ include("source/cron_bcic_email.php");
}else{
	header('Location:../admin/index.php');
}		

?>