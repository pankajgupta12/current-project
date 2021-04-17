<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/admin/fix_mysql.inc.php");

	 /* error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);   */

    
    /* if($_SERVER['REMOTE_ADDR'] == '122.160.94.6') {
     // beta
		Define ('DB_name',"bciccom_beta_test");        
		Define ('DB_user',"bciccom_beta");
		Define ('DB_pass',"%nWseip_12mE"); 
    }else{
       // Live
         Define ('DB_name',"bciccom_db");
         Define ('DB_user',"bciccom_dbusers");
         Define ('DB_pass',"x#fxCQ0J{7M]");
    }  */
  
        Define ('DB_name',"bciccom_db");
        Define ('DB_user',"bciccom_dbusers");
        Define ('DB_pass',"x#fxCQ0J{7M]");

	   /* Define ('DB_name',"bciccom_db");
		Define ('DB_user',"bciccom_dbusers");
		Define ('DB_pass',"x#fxCQ0J{7M]");  */
		 
		 
// 		Define ('DB_name',"bciccom_beta_test");        
// 		Define ('DB_user',"bciccom_beta");
// 		Define ('DB_pass',"%nWseip_12mE"); 

		
//echo $_SESSION['admin']; 
//die;
  /*  if($_SESSION['admin'] == 55) {
     
      	    Define ('DB_name',"bciccom_beta_test");    
			Define ('DB_user',"bciccom_beta");
			Define ('DB_pass',"%nWseip_12mE");  
      
	
		
  }else 
    {
		Define ('DB_name',"bciccom_db");
		Define ('DB_user',"bciccom_dbusers");
		Define ('DB_pass',"x#fxCQ0J{7M]");     
    }   
	*/
 
    $site_name = "https://www.beta.bcic.com.au";
    $secure_site_name = "https://www.beta.bcic.com.au"; 
    $email_url = "https://exchange.mail.bcic.com.au";	
    
    
    Define ('DB_HOST',"localhost"); 	
    $hostname = "localhost";   

	Define ('DB_prefix',"");
	Define ('C_name',""); 

	Define ('SS_TT_prefix',"betameetme");
	Define ('resultsPerPage',50);
	Define ('dispatchboardPerPage',10); 
	Define ('staffresultsPerPage',20); 

if (ini_get('date.timezone') == '') {
    date_default_timezone_set('Australia/Melbourne');
}
	

$link = mysql_connect($hostname,DB_user,DB_pass) or die("Could not connect");

//print_r($link); die;

//echo  $link; die;

mysql_select_db(DB_name,$link) or die("Could not select database");


//date_default_timezone_set('Australia/Melbourne');
//ini_set('suhosin.get.max_value_length',5000);

$arg = "select * from siteprefs where id=1";
//$site = mysql_fetch_array(mysql( 'DB_name', $arg ));
$site = mysql_fetch_array(mysql_query($arg));
//echo "<pre>"; print_r($site); die;

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
Define ('PRE_SITE_NAME',$site_name);
Define ('Site_Term_Condition',"$site[term_condition]");
Define ('Site_Defaut_Text',"$site[default_text]");
Define ('exchang_email',$email_url);

define('ROOT_ADMIN',$_SERVER["DOCUMENT_ROOT"].'/admin/');
define('SITE_CLASS',ROOT_ADMIN.'class/');
define('STAFF_IMG',$_SERVER["DOCUMENT_ROOT"].'/staff/workimages/');


// Send Notification SMS API
define('app_id','532d6358-9b51-47a7-8f4f-5cde35631303');
define('app_url','https://onesignal.com/api/v1/notifications');
define('authorization_api_key','Mjk5ZjJiYjItNWVjZi00Nzk3LWEwNjQtZDJmZjM2MmJkNWIy');

//week days
const WEEK_DAYS_ARRAY = array('Monday','Tuesday', 'Wednesday','Thursday','Friday','Saturday','Sunday');
 const DOCUMENT_CHECK = array('Police Check', 'Insurance', 'license', 'Pest License'); 
//week days
//const JOB_TYPES_ARRAY = array("Cleaning","Carpet","Uphostry","Upholstry","Pest","Gardening","Oven");

$myipaddress = "110.142.231.92"; 
Define ('myipaddress ',"110.142.231.92");

$_SESSION['session_sid'] = session_id();

$b_time = (time());
$mysql_tdate =  date("Y-m-d",$b_time);


if(!isset($_SESSION['device'])){
	$_SESSION['device'] = get_device();	
}



?>

