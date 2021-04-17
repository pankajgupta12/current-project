
<?php

	if($_REQUEST['task']=="sms") {
?>
 <iframe  src="<?php printf( '%s' , $site_name ); ?>/chat_bk/index.php?task=admin" width="100%" height="87%" name="iframe_a" ></iframe>
<?php } else if($_REQUEST['task']=="newsms") { ?> 
	<iframe  src="<?php printf( '%s' , $site_name ); ?>/newsms/index.php?task=admin" width="100%" height="87%" name="iframe_a" ></iframe>
<?php  } else if ($_REQUEST['task']=="hr_sms") { ?>
	<iframe  src="<?php printf( '%s' , $site_name ); ?>/hr_sms/index.php?task=admin" width="100%" height="87%" name="iframe_a" ></iframe>
<?php  } else if ($_REQUEST['task']=="mysmsnew") {
   //echo 'hehehe'; die;
?>
	<iframe  src="<?php printf( '%s' , $site_name ); ?>/mysmsnew/index.php?task=admin" width="100%" height="87%" name="iframe_a" ></iframe>
<?php  } ?>	