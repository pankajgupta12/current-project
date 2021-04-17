<?php

Define ('DB_name',"bciccom_dbtest");
Define ('DB_user',"bciccom_dbusers");
Define ('DB_pass',"x#fxCQ0J{7M]");


$hostname = "localhost";
Define ('DB_host',$hostname);
Define ('DB_prefix',"");
Define ('C_name',"");


$site_name = "https://beta.bcic.com.au";
$secure_site_name = "https://beta.bcic.com.au";


//$site_name = "http://localhost/bcic/";
//$secure_site_name = "http://localhost/bcic/";
	
$link = mysql_connect($hostname,DB_user,DB_pass) or die("Could not connect");
mysql_select_db(DB_name,$link) or die("Could not select database");

$arg = "select * from siteprefs where id=1";
//$site = mysql_fetch_array(mysql( 'DB_name', $arg ));
$site = mysql_fetch_array(mysql_query($arg));

$data = mysql_query($arg);

Define ('Site_name',"$site[site_name]");
Define ('Site_url',"$site[site_url]");
Define ('Site_email',"$site[site_contact_email]");
Define ('Site_domain',"$site[site_domain]");
Define ('Site_phone',"$site[site_contact_phone]");
Define ('Site_fax',"$site[site_contact_fax]");
Define ('Site_owner',"$site[site_owner]");
Define ('DB_dir',"$site[db_dir]");
Define ('logo',"$site[logo]");

$myipaddress = "110.142.231.92";
Define ('myipaddress ',"110.142.231.92");

Define ('DB_COMPARE',"/dbcompare");

$_SESSION['session_sid'] = session_id();

$b_time = (time());
$mysql_tdate =  date("Y-m-d",$b_time);
?>
