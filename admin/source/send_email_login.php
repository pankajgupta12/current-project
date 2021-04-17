<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><? echo Site_name?></title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
</head>
<style type="text/css">
	.container { position:relative;}
	.login_main { margin: 0;
	width:100%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, 50%);}

.right-panel-tittle {
    font-size: 20px;
    padding: 10px 0px;
}
.logo {
    padding-top: 30px;
}
.m-login__form-action button {
    background-color: #0093dd;
    color: #fff;
    width: 100%;
    padding: 10px 0px;
    font-size: 20px;
    font-weight: 600;
}
.m-login__form-action button:hover { background-color:#333;}
</style>

<body>

<?php 
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */
  
  
    if(isset($_POST['submit'])) {
	        //print_r($_POST); die;  
			
	        $email = mysql_real_escape_string($_POST['emails_id']);
			if (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
			{ 
		        /*  echo  "SELECT * FROM `admin` WHERE email = '".$email."' AND status = 1";
		     die; */
		           $query =    mysql_query("SELECT * FROM `admin` WHERE email = '".$email."' AND status = 1");	
				    $countre = mysql_num_rows($query);				
		                if($countre > 0) {
						      $admin = mysql_fetch_array($query);
							   $name = $admin['name'];
							   $email = $admin['email'];
							   $subject = 'Login form '.$name.' On'. date('dS M Y h:i:s A');;
							   //sendmailbcic($name,$email,$subject,$str,"reclean@bcic.com.au","0");
								$siteUrl = get_rs_value_data("siteprefs","site_url",1);		
								$id = base64_encode(base64_encode($admin['id']));
								$getsec =  getName(10); 
								$shorturl = $siteUrl.'/admin/index.php?__SK__='.$getsec;
								//echo "UPDATE `admin` SET `secret_key` = '".$getsec."' WHERE id  = ".$admin['id'].""; die;
							   mysql_query("UPDATE `admin` SET `secret_key` = '".$getsec."', email_send_date = '".date('Y-m-d H:i:s')."' WHERE id  = ".$admin['id']."");
							   
							   $eol = '<br/>';
							   //$shorturl = 
							   $s_url = createbitLink_1($shorturl,'business2sell','R_3e3af56c36834837ba96e7fab0f4361a','json');
							   $str = 'Hello ' .$name.$eol ;
							   $link = '<a href='.$s_url.'>'.$s_url.'</a>';
							   $str .= 'Please Click Link  '. $link;
							   
							    $sendto_message = $str;   //admin@bcic.com.au
							  // echo  $sendto_message; die;
							    //sendmailbcic($name,$email,$subject,$sendto_message,$replyto,$type, $footerStatus =null)
								//echo  $sendto_message;  die;
							   	//sendmailbcic_1("Admin Logged",'pankaj.business2sell@gmail.com',$subject,$sendto_message,'admin@bcic.com.au'); 
							   	sendmailbcic_1("Admin Logged",$email,$subject,$sendto_message,'administrator@bcic.com.au'); 
							   //	sendmailbcic_1("Admin Logged",'pankaj.business2sell@gmail.com',$subject,$sendto_message,'administrator@bcic.com.au'); 
						  
								header('Location:index.php?task=send_email_login&action=success');
								die();	
					    }else {
							header('Location:index.php?task=send_email_login&action=eerror');
						    die();	
						}
                   //SELECT id, name , email  FROM `admin` WHERE status = 1
			     //echo "<center>Invalid email</center>";
				  //die;
                 // sendmailbcic($sendto_name,$sendto_email,$sendto_subject,$sendto_message,$replyto,$type, $footerStatus =null)
				 // sendmailbcic($jobDetails['agent_name'],$to,$subject,$str,"reclean@bcic.com.au","0");
			}else
			{

			   //echo "<center>Valid Email</center>";
			   header('Location:index.php?task=send_email_login&action=eerror');
			   //die;

			}
	  
    }
	
		//$n=10; 
		function getName($n) { 
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
			$randomString = ''; 

			for ($i = 0; $i < $n; $i++) { 
			$index = rand(0, strlen($characters) - 1); 
			$randomString .= $characters[$index]; 
			} 

			return $randomString; 
		} 

		//echo getName($n); 
	
	 function createbitLink_1($url, $login, $appkey, $format='json', $history=1, $version='2.0.1')
		{
			//create the URL
			$bitly = 'http://api.bit.ly/shorten';
			$param = 'version='.$version.'&longUrl='.urlencode($url).'&login='
				.$login.'&apiKey='.$appkey.'&format='.$format.'&history='.$history;
				
			

			//get the url
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $bitly . "?" . $param);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($ch);
			curl_close($ch);

			//parse depending on desired format
			if(strtolower($format) == 'json') {
				$json = @json_decode($response,true);
				//print_r($json); die;
				return $json['results'][$url]['shortUrl'];
			} else {
				$xml = simplexml_load_string($response);
				return 'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
			}
		}
	
	function get_rs_value_data($table,$field,$wherecond){
	
		$tr_desc_sql = "SELECT $field FROM $table where id=".mysql_real_escape_string($wherecond);
		//echome($tr_desc_sql);
		$tr_data = mysql_query($tr_desc_sql);
		if (mysql_num_rows($tr_data)>0){
			$cat_name = mysql_result($tr_data, 0, $field);
		}else{
			$cat_name ="";
		}
		return $cat_name;
    } 
	
	function sendmailbcic_1($sendto_name,$sendto_email,$sendto_subject,$sendto_message,$replyto) {
	//global $siteinfo;
  //	echo "Ok"; die;
		//$sql_email = "SELECT * FROM country_settings where id=".$_SESSION['cid'];
		
		$sql_email = "SELECT * FROM siteprefs where id=1";		
		$site = mysql_fetch_array(mysql_query($sql_email));
		//echo "$site[siteurl]";	
		
        if($footerStatus == 1) {
			$footertext = "Should you have any further enquiries, please do not hesitate to email us at ".$replyto." and one of our team members will be in contact with you as soon as possible."; 
			
		}else{
			$footertext = "Should you have any enquiries in relation to this matter please do not hesitate to email us at ".$site['site_contact_email'].""; 
		} 
		
		$sendto = $sendto_name."<".$sendto_email.">";
		
		//$sendto = "BCIC Application<hr@bcic.com.au>";
		
	//	echo $sendto; die;
		$email_message="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
<HTML><HEAD><TITLE>".$site['site_domain']."</TITLE>
<META content=\"text/html; charset=windows-1252\" http-equiv=Content-Type>
</HEAD>
<link rel=\"stylesheet\" href=\"http://www.bcic.com.au/admin/css/style.css\" type=\"text/css\">
<link href=\"http://www.bcic.com.au/admin/css/general.css\" rel=\"stylesheet\" type=\"text/css\">
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr><td class=\"text12\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><p>".$sendto_message."</p></font>
  <p>
<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">".$footertext."<br><br>
Kind Regards</font>
</p>
  <P><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">
  BCIC Team</P>
  
  <P><a href=\"".$site['site_domain']."\"><img src=\"".$site['site_url'].'/'.$site['bcic_new_logo']."\" /></a><br>
	p: ".$site['site_contact_phone']."<br>
	e: ".$site['site_contact_email']."<br>
  w: ".$site['site_domain']."</font></P>
";

$email_message.="<P><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><strong>CAUTION</strong>: 
This email and any attachments may contain information that is confidential and subject to legal privilege. 
If you are not the intended recipient, you must not read, use, disseminate, distribute or copy this email or any attachments. 
If you have received this email in error, please notify us immediately and erase this email and any attachments. Thank you. <br>
<strong>DISCLAIMER</strong>: To the maximum extent permitted by law, BCIC is not liable (including in respect of negligence) for viruses or other defects or 
for changes made to this email or to any attachments. Before opening or using attachments, check them for viruses and other defects. 
The information contained in this document is confidential to the addressee and is not the view nor the official policy of BCIC unless otherwise stated.
  </font> </P>
  </td>
  </tr>
  </table>
</BODY></HTML>
";
		
	
				/* $headers .= "Reply-To: The Sender <sender@sender.com>\r\n";
				$headers .= "Return-Path: The Sender <sender@sender.com>\r\n";
				$headers .= "From: The Sender <senter@sender.com>\r\n"; */
		
			/* $headers='From: '.$replyto.' \r\n';
			$headers.='Reply-To: '.$replyto.'\r\n';
			$headers.='X-Mailer: PHP/' . phpversion().'\r\n';
			$headers.= 'MIME-Version: 1.0' . "\r\n";
			$headers.= 'Content-type: text/html; charset=iso-8859-1 \r\n'; */
			/* $headers.= "BCC: $emailList";
			$headers.= "CC: $emailList"; */
		
		
	     $headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:'.$replyto."\r\n";
		$headers .= 'Reply-To:'.$replyto. "\r\n"; 
		
		ini_set('sendmail_from', $replyto);
	
	 // echo $site['site_url'].$site['logo']; die;
	
		mail($sendto_email,$sendto_subject,$email_message,$headers);	
		//mail("manish@bcic.com.au","CC:".$sendto_subject,$email_message,$headers);		
}

 ?>

<div class="container">
	<div class="login_main">
	<div class="row">
    
    	<div class=" col-7 col-md-7">
        	<div class="left-img"><img src="../img/left-img.jpg" alt="img"/></div>
        </div>
        
        <div class=" col-5 col-md-5">
        	<div class="logo"> <img src="../img/Logo-1.png" alt="logo"/></div>
        	<h2 class="right-panel-tittle">You are not authorized to login into <? echo  Site_name;?> Administration Zone. Please enter your email below.</h2>
						
			<?php if(isset($_GET['action']) && $_GET['action'] == 'eerror') { ?>
			   <p style="font-size: 13px; margin: 3px; color: red; font-weight: 600; padding-top: -4px;">Please enter your <? echo  Site_name;?> email id.</p>
			<?php  } else if(isset($_GET['action']) && $_GET['action'] == 'success') { ?>
			   <p style="font-size: 13px; margin: 3px; color: #117511; font-weight: 600; padding-top: -4px;">Email has sent on your email successfully.</p>
			<?php  } ?>
			
            <form class="m-login__form m-form" method="post" action="<? //echo  $_SERVER['SCRIPT_NAME'];?>">
              <div class="form-group m-form__group">
                <input class="form-control m-input" type="email" placeholder="Email" name="emails_id"  >
              </div>
             
             
                <div class="m-login__form-action">
			       
                    <button id="m_login_signin_submit" name="submit"  class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">Send Email</button>
					
					<!--<input  id="m_login_signin_submit" name="Submit" type="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air" value="Log In">-->
               </div>
            </form>
        </div>
     </div>   
	</div>
</div>

</body>
</html>
