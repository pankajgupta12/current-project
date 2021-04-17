<?php 
function email_staff_payment($staff_id,$sendmail){
	
	$staff_arg="select * from staff where id=".$staff_id;
	$str = "";
	$staffs = mysql_query($staff_arg);
	$staff_row = mysql_query($staffs);
	
	$sites = mysql_fetch_assoc(mysql_query("select * from sites where id=".$staff_row['site_id']));

	while($r = mysql_fetch_assoc($staffs)){	
	
		
		$str= '<h2>'.$r['name'].' ('.$site_name.')</h2>';
			$job_total = 0; $staff_amount_total = 0; $bcic_amount_total =0; $bcic_rec_total =0; $staff_rec_total=0;
			$balance=0;
			$job_picker_x = "";
			$str.='<table width="100%" border="0" cellpadding="5" cellspacing="5" class="table_bg">';
			$str.='<tr class="table_cells">
				  <td>Job Id</td>
				  <td>Client Name</td>
				  <td>Job Date</td>
				  <td>Type</td>			  
				  <td>Total Amount</td>
				  <td>Staff Amount</td>
				  <td>Staff Paid Date</td>
				</tr>';
			
			$job_details_arg = "select * from job_details where staff_id=".$r['id']." and staff_paid=1 and staff_paid_date='".date("Y-m-d")."' and job_id in(select id from jobs where status=3 and payment_completed=0) and status!=2";
			$job_details_arg.= " and (job_date>='".$_SESSION['tpayment_report']['from_date']."' and job_date<='".$_SESSION['tpayment_report']['to_date']."') ";
			//echo $job_details_arg;
			$job_details = mysql_query($job_details_arg);
			
			while($jdetails = mysql_fetch_assoc($job_details)){ 
				
				$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".$jdetails['job_id']));			
				$quote = mysql_fetch_array(mysql_query("select * from quote_new where id=".$jobs['quote_id']));
				$bcic_rec =mysql_fetch_array(mysql_query("select sum(amount) as amount from job_payments where taken_by='BCIC' and job_id=".$jdetails['job_id'].""));
				$staff_rec =mysql_fetch_array(mysql_query("select sum(amount) as amount from job_payments where taken_by='".$staff_row['name']."' and job_id=".$jdetails['job_id'].""));
				
				$str.='<tr class="table_cells">
				  <td>'.$jdetails['job_id'].'</td>
				  <td>'.$quote['name'].'</td>
				  <td>'.$jdetails['job_date'].'</td>
				  <td>'.$jdetails['job_type'].'</td>
				  <td>'.$jdetails['amount_total'].'</td>
				  <td><strong>'.$jdetails['amount_staff'].'</strong> </td>
				  <td>'.$jdetails['staff_paid_date'].'</td>
				</tr>';
				
				$job_total = ($job_total+$jdetails['amount_total']); 
				$staff_amount_total = ($staff_amount_total+$jdetails['amount_staff']); 
				$bcic_amount_total = ($bcic_amount_total+$jdetails['amount_profit']); 
				$bcic_rec_total = ($bcic_rec_total+$bcic_rec['amount']); 
				$staff_rec_total= ($staff_rec_total+$staff_rec['amount']);
				// <a href="javascript:send_data(\''.$quote['id'].'|'.$jdetails['staff_id'].'|true\',28,\'send_invoice_'.$jdetails['id'].'\');" id="send_invoice_'.$jdetails['id'].'">Send Invoice</a>
			}
			
			$str.='<tr class="table_cells">
				  <td></td>
				  <td></td>
				  <td></td>
				  <td></td>		  
				  <td>'.$job_total.'</td>
				  <td>'.$staff_amount_total.'</td>
				  <td></td>
				</tr>';
			$payment_balance = ($staff_amount_total-$staff_rec_total);
			$str.='<tr class="table_cells">
				  <td colspan="7" align="center"><strong>Staff Payment Made: '.($staff_amount_total-$staff_rec_total).'</strong></td>
				</tr>';
			$str.='</table>';
	}
	
	if($sendemail==true){ 
		sendmail($staff['name'],$staff['email'],"Staff Payment Report ".date("d m Y")." ".$site['domain'],$str,$sites['email'],$details['site_id']);
		//sendmail($details['name'],"crystal@bcic.com","Staff Payment Report ".$sites['domain'],$str,$sites['email'],$details['site_id']);
		
		//sendmail($staff['name'],"manish.khanna1@gmail.com","Staff Payment Report ".date("d m Y")." ".$sites['domain'],$str,$sites['email'],$sites['site_id']);
		return error("Staff Payment Report");
	}else{
		return $str;
	}
}

function send_cleaner_details_temp($job_id){
	//$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".mysql_real_escape_string($job_id).""));
	//$sites = mysql_fetch_array(mysql_query("select * from sites where id=".mysql_real_escape_string($quote['site_id']).""));
	$eol = "\r\n";
	$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mysql_real_escape_string($job_id).""));	
	$job_details = mysql_query("select * from job_details where job_id=".mysql_real_escape_string($job_id)." AND status != 2 ");		
			   
	/*		   
		    $quote['cleaning_desc'] = $quote['bed']." Beds ".$quote['bath']." Bath ".$quote['property_type']." ";
		   if($quote['furnished']=="Yes"){ $quote['cleaning_desc'].= " Furnished "; }
		   
		   $bool = mysql_query("update quote set cleaning_desc='".$quote['cleaning_desc']."' where id=".$quote['id']."");
		   $quote['cleaning_desc'].= $eol;

		  if($quote['carpet']=="Yes"){ 
			 $quote['carpet_desc']= $quote['c_bedroom']."Bed, ".$quote['c_lounge']." Lounge, "; 			
			 if($quote['c_stairs']!=""){ $quote['carpet_desc'].= $quote['c_stairs']." stairs"; }
			 
			 $bool = mysql_query("update quote set carpet_desc='".$quote['carpet_desc']."' where id=".$quote['id']."");				 
			 $quote['carpet_desc'].= $eol;
		  }*/		  
		 $c_str = "";
		 while($jd = mysql_fetch_assoc($job_details)){
			 //$quote_details = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".$jd['quote_id']." and job_type_id=".$jd['job_type_id'].""));
			 $quote_desc = get_sql("quote_details","description","where quote_id=".$jd['quote_id']." and job_type_id=".$jd['job_type_id']."");
			 $staff = mysql_fetch_array(mysql_query("select * from staff where id=".mysql_real_escape_string($jd['staff_id'])." "));
			
			 $c_str.="<strong>".$jd['job_type']."</strong>: ".$staff['name']." ".$staff['mobile'].''.$eol;			 
			 $c_str.="".$quote_desc.''.$eol;
		 }

	  //changeDateFormate($getquote['date'],'datetime');
	  
$eol = "<br>";
$str = 'Hello '.$quote['name'].$eol.$eol.'We are all set for your job on '.changeDateFormate($quote['booking_date'],'datetime').''.$eol;
$str.='Your Cleaner(s) details are:<br><br>'.$c_str.$eol;

$str.='<br><br>Job ID: '.$job_id.''.$eol;
$str.='Date: '.$quote['booking_date'].''.$eol.'
Address: '.$quote['address'].''.$eol.'';
$str.='Estd. Amount:$'.$quote['amount'].''.$eol.''.$eol.'';

//Please if you can advise me what arrangements you will make to ensure the cleaner can get access to the property?'.$eol.'
//Could you please advise the mode of payment?'.$eol.'';
	
	return $str;
	//sendmail($sendto_name,$sendto_email,$sendto_subject,$sendto_message,$replyto,$site_id);
	//sendmail($quote['name'],$quote['email'],"Bond Cleaning Booking Confirmation from ".$site['domain'],$str,$sites['email'],$quote['site_id']);
	//sendmail($quote['name'],"manish.khanna1@gmail.com","Bond Cleaning Booking Confirmation from ".$site['domain'],$str,$sites['email'],$quote['site_id']);
	//add_job_emails($job_id,$heading,$comment,$email)
}

function send_email_conf_template($job_id){
	$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".mysql_real_escape_string($job_id).""));
	$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mysql_real_escape_string($job_id).""));
	$site = mysql_fetch_array(mysql_query("select * from sites where id=".mysql_real_escape_string($quote['site_id']).""));
	$jobpayment = mysql_fetch_array(mysql_query("select sum(amount) as amount1 from job_payments where job_id=".mysql_real_escape_string($job_id).""));
	$getemailNotes =   mysql_fetch_assoc( mysql_query("SELECT * FROM `quote_email_notes` WHERE id = 2"));
	
	$eol = "\r";
	
$str = 'Hello '.$quote['name'].$eol.$eol.'Thanks for choosing '.$site['domain'].''.$eol.'
This email is to confirm that your Cleaning job is booked with us. '.$eol.$eol.'
Job Id: '.$job_id.''.$eol.'
Date : '.date("d M Y",strtotime($quote['booking_date'])).''.$eol.'
Address: '.$quote['address'].''.$eol.''.$eol.'';
$str.='Estd. Amount:$'.$quote['amount'].''.$eol.'';
if($jobpayment['amount1']>0) {
	   $str.='Amount Received: $'.$jobpayment['amount1'].''.$eol; 
	 } 

$job_details = mysql_query("select * from job_details where job_id=".mysql_real_escape_string($job_id)." ");
$c_str = "";
 while($jd = mysql_fetch_assoc($job_details)){
	 //$quote_details = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".$jd['quote_id']." and job_type_id=".$jd['job_type_id'].""));
	 $quote_desc = get_sql("quote_details","description","where quote_id=".$jd['quote_id']." and job_type_id=".$jd['job_type_id']."");
	 $c_str.="".$jd['job_type'].": ".$quote_desc.''.$eol;
 }

$str.=$c_str.$eol;

$str.='Please Notes :-'.$eol;
$str.=strip_tags($getemailNotes['notes']).$eol;
  
//Property Details: '.$quote['cleaning_desc'].' <br>';
//if($quote['carpet_desc']!=""){ $str.='Carpet Details: '.$quote['carpet_desc'].' <br>'; }
/* $str.=''.$eol.'
We will confirm the time and cleaner details a day before the job via email. '.$eol.'
The cleaner will contact you prior to your clean. At this time, please confirm your best time and access. '.$eol.'
Please prepare your property to be clean, e.g., removal of furniture & belongings (unless furnished) and rubbish prior to cleaning. '.$eol.'
Please note we require electricity at the premises on the cleaning day.'.$eol.'
Please note payment is required 24 hours prior to the booking date. Below are the payment options. (If applicable)'.$eol; */

$str .='Credit Card (1 day Prior)'.$eol.'------------------------'.$eol.'
Please make sure that you send us the paid receipt of bank transfer.'.$eol.'
Please enter your Job Id for reference.'.$eol.'
Account Name: BCIC Trust'.$eol.'
BSB : 014527'.$eol.'
Account No: 295683522'.$eol.''.$eol.'

Bank Transfer (3 days Prior)'.$eol.'------------------------'.$eol.'
To Pay by Card, Please call on our Office Number'.$eol.'
Office number:'.$eol.'
1300 599 644'.$eol.''.$eol.'
For Terms and Conditions, please refer to our website.'.$eol.'';

return trim($str);

}


/*function send_email_conf_template($job_id){
	$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".mysql_real_escape_string($job_id).""));
	$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mysql_real_escape_string($job_id).""));
	$sites = mysql_fetch_array(mysql_query("select * from sites where id=".mysql_real_escape_string($quote['site_id']).""));
	
	$eol = "\r\n";
	
	$job_details = mysql_query("select * from job_details where job_id=".mysql_real_escape_string($job_id)." ");
	$c_str = "";
	 while($jd = mysql_fetch_assoc($job_details)){
		 //$quote_details = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".$jd['quote_id']." and job_type_id=".$jd['job_type_id'].""));
		 $quote_desc = get_sql("quote_details","description","where quote_id=".$jd['quote_id']." and job_type_id=".$jd['job_type_id']."");
		 $c_str.="<strong>".$jd['job_type']."</strong>: ".$quote_desc.''.$eol;
	 }
	
	$str = 'Hello '.$quote['name'].''.$eol.$eol.'Thanks for choosing '.$sites['domain'].''.$eol.'
	This email is to confirm that you have a Bond Cleaning booked with us '.$eol.''.$eol.'
	Date : '.date("d M Y",strtotime($quote['booking_date'])).''.$eol.'
	Address: '.$quote['address'].''.$eol.'';
	
	$str.=$c_str.$eol;
	//Property Details: '.$quote['cleaning_desc'].' '.$eol.'';
	//if($quote['carpet_desc']!=""){ $str.='Carpet Details: '.$quote['carpet_desc'].' '.$eol.''; }
	
	$str.='Estd. Amount:$'.$quote['amount'].''.$eol.'
	We will confirm the time and cleaner details a day before the job. '.$eol.'
	Please if you can advise me what arrangements you will make to ensure the cleaner can get access to the property?'.$eol.'
	Could you please advise the mode of payment?'.$eol.'Below are the payment options. '.$eol.''.$eol.'
	
	Credit Card'.$eol.'
	-------------------'.$eol.'
	To Pay by Card, Please call on our Office Number before the Job Starts'.$eol.' Office number:	1300 599 644'.$eol.''.$eol.'
	Bank Transfer'.$eol.'
	------------------'.$eol.'
	Please make sure that you send us the paid receipt of bank transfer 2 days prior to your Booking Date.'.$eol.'
	Account Name:  Bond Cleaning In Your City Pty Ltd ATF the BCIC Trust'.$eol.'
	BSB : 014527'.$eol.'
	Account No: 295683522'.$eol.'
	'.$eol.'
	Please Note : Please make sure that you remove all the furniture (unless furnished) and rubbish prior to cleaning.'.$eol.'
	Please note we require electricity at the premises on the cleaning day.'.$eol.'';
	
	return $str;	re_clean
}*/

function send_email_conf($job_id,$action = null){
	
	$var = explode('|',$action);
	
	$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".mysql_real_escape_string($job_id).""));
	$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mysql_real_escape_string($job_id).""));
	$site = mysql_fetch_array(mysql_query("select * from sites where id=".mysql_real_escape_string($quote['site_id']).""));
	$jobpayment = mysql_fetch_array(mysql_query("select sum(amount) as amount1 from job_payments where job_id=".mysql_real_escape_string($job_id).""));
	$getemailNotes =   mysql_fetch_assoc( mysql_query("SELECT * FROM `quote_email_notes` WHERE id = 2"));
	
	
	$str = 'Hello '.$quote['name'].'<br><br>Thanks for choosing <a href="'.$site['domain'].'">'.$site['domain'].'</a><br>
	This email is to confirm that your Cleaning job is booked with us. <br><br>
	Job Id: '.$job_id.'<br>
	Date : '.date("d M Y",strtotime($quote['booking_date'])).'<br>	
	Address: '.$quote['address'].'<br>';
	$str.='Estd. Amount:$'.$quote['amount'].'<br>';
	if($jobpayment['amount1']>0) {
	   $str.='<b>Amount Received $'.$jobpayment['amount1'].'</b><br>'; 
	 } 
	 
	$job_details = mysql_fetch_array(mysql_query("select * from job_details where job_id=".mysql_real_escape_string($job_id)." "));
		$c_str = "";
		 while($jd = mysql_fetch_assoc($job_details)){
			 //$quote_details = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".$jd['quote_id']." and job_type_id=".$jd['job_type_id'].""));
			 $quote_desc = get_sql("quote_details","description","where quote_id=".$jd['quote_id']." and job_type_id=".$jd['job_type_id']."");
			 $c_str.="<strong>".$jd['job_type']."</strong>: ".$quote_desc.''.$eol;
		}
	
	$str.=$c_str.$eol;
	 
	
	if($jobs['payment_agree_check'] == '1' && $jobs['payment_agree_check'] == '1'){
	    $str.='<br><b>You have agreed to charge your card on file on the day of job for remaining amount</b><br>';
	}
	$str.= '<strong>Please Notes </strong>';
	$str.= '<div style="margin-left: 26px;padding:  8px;margin-bottom: 21px; margin-top: 6px;">';
	//$str.= $getemailNotes['notes'];
	$str.= str_replace('$tc','<a href='.$site['term_condition_link'].'>term & conditions</a>',$getemailNotes['notes']); 
	$str.= '</div>';
	/* $str.='<br>
	We will confirm the time and cleaner details a day before the job via email. <br>
	The cleaner will contact you prior to your clean. At this time, please confirm your best time and access. <br>
	Please prepare your property to be clean, e.g., removal of furniture & belongings (unless furnished) and rubbish prior to cleaning. <br>
	Please note we require electricity at the premises on the cleaning day. <br>
	Please note payment is required 24 hours prior to the booking date. Below are the payment options. (If applicable)<br>'; */

	$str.='<table width="760" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td align="center" class="text12"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>Credit Card (1 day Prior)</strong></font></td>
    <td align="center" class="text12"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>Bank Transfer (3 days Prior)</strong></font></td>
  </tr>
  <tr>
    <td class="text12"> <font size=\"2\" face=\"Arial, Helvetica, sans-serif\">To Pay by Card, Please call on our Office Number<br>
	Office number:<br>
	1300 599 644
	</font></td>
	<td class="text12"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Please make sure that you send us the paid receipt of bank transfer.<br>
	Please enter your <strong>Job Id for reference</strong>. <br>
	Account Name: BCIC Trust<br>
	BSB : 014527<br>
	Account No: 295683522<br></font>
	</td>
	</tr> 
	</table>
	For Terms and Conditions, please refer to our website.<br>';
	
	//sendmail($sendto_name,$sendto_email,$sendto_subject,$sendto_message,$replyto,$site_id);
	//sendmail($quote['name'],"manish.khanna1@gmail.com","Bond Cleaning Booking Confirmation",$str,$sites['email'],$quote['site_id']);
	
	sendmail($quote['name'],$quote['email'],"Bond Cleaning Booking Confirmation from ".$sites['domain']." Job Id ".$job_id,$str,$sites['email'],$quote['site_id']);	
	//sendmail($quote['name'],"crystal@bcic.com.au","Bond Cleaning Booking Confirmation from ".$site['domain']." Job Id ".$job_id,$str,$sites['email'],$quote['site_id']);
	add_job_emails($job_id,"Bond Cleaning Booking Confirmation from ".$sites['domain']." Job Id ".$job_id,$str,$quote['email']);
}

function send_cleaner_details($job_id){
	//$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".mysql_real_escape_string($job_id).""));
	$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mysql_real_escape_string($job_id).""));
	$sites = mysql_fetch_array(mysql_query("select * from sites where id=".mysql_real_escape_string($quote['site_id']).""));
	//$job_details = mysql_fetch_array(mysql_query("select * from job_details where job_id=".mysql_real_escape_string($job_id)." and job_type='Cleaning'"));
	//$staff = mysql_fetch_array(mysql_query("select * from staff where id=".mysql_real_escape_string($job_details['staff_id']).""));
	
	/*$str = 'Hello '.$quote['name'].'<br><br>We are all set for your job on '.date("d M Y",strtotime($quote['booking_date'])).'<br>
	Our Cleaner '.$staff['name'].' will contact you at the earliest. You can contact them on '.$staff['mobile'].'<br><br>
	Date : '.date("d M Y",strtotime($quote['booking_date'])).'<br>
	Address: '.$quote['address'].'<br>
	Property Details: '.$quote['cleaning_desc'].' <br>';
	if($quote['carpet_desc']!=""){ $str.='Carpet Details: '.$quote['carpet_desc'].' <br>'; }
	$str.='Estd. Amount:$'.$quote['amount'].'<br><br>
	We will confirm the time and cleaner details a day before the job. <br>
	Please if you can advise me what arrangements you will make to ensure the cleaner can get access to the property?<br>
	Could you please advise the mode of payment?<br><br>';*/
	
	$str = send_cleaner_details_temp($job_id);	
	
	//sendmail($sendto_name,$sendto_email,$sendto_subject,$sendto_message,$replyto,$site_id);
	//sendmail($quote['name'],"manish.khanna1@gmail.com","Cleaner Details for Bond Cleaning from ".$site['domain']." Job Id #".$job_id,$str,$sites['email'],$quote['site_id']);
	
	sendmail($quote['name'],$quote['email'],"Cleaner Details for Bond Cleaning from ".$sites['domain']." Job Id #".$job_id,$str,$sites['email'],$quote['site_id']);
	//sendmail($quote['name'],"crystal@bcic.com.au","Cleaner Details for Bond Cleaning from ".$site['domain']." Job Id ".$job_id,$str,$sites['email'],$quote['site_id']);
	
	add_job_emails($job_id,"Cleaner Details for Bond Cleaning",$str,$quote['email']);
}


/* function sms_send_cleaner_details($job_id){
	
    return  send_cleaner_details_temp($job_id);	
	//add_job_emails($job_id,"SMS Cleaner Details for Bond Cleaning",$str,$quote['email']);
} */


function quote_email($quote_id,$sendemail){	  
	 // echo $quote_id; die; 
	  if($quote_id!=""){ 
			$details_data =mysql_query("select * from quote_new where id=".mysql_real_escape_string($quote_id)."");
	
			if(mysql_num_rows($details_data)>0){
				$details =  mysql_fetch_array($details_data);
				$quote = $details;
			
			  $site_data = mysql_query("select * from sites where id=".$details['site_id']."");
			  $sites = mysql_fetch_array($site_data);
			  
			  $details['site_logo'] =   $sites['logo'];
			  $details['site_url'] =   $sites['domain'];
			  $details['term_condition_link'] =   $sites['term_condition_link'];
			  $details['inclusion_link'] =   $sites['inclusion_link'];
			  $details['site_email'] =   $sites['email'];
			  $details['site_phone'] =   $sites['phone'];
			 // $details['ssecret'] =   $details['ssecret'];
			  $details['to'] = $quote['name']."<br>".$quote['address']."<br>".$quote['phone'];
					  
			   /*//if($details['cleaning_desc']==""){ 
				   $details['cleaning_desc'] = $details['bed']." Beds ".$details['bath']." Bath ".$details['property_type']." ".$details['blinds_type'];
				   if($details['furnished']=="Yes"){ $details['cleaning_desc'].= " Furnished "; }
				   
				   $bool = mysql_query("update quote set cleaning_desc='".$details['cleaning_desc']."' where id=".$details['id']."");
				   $details['cleaning_desc'].= $eol;				  
			  //}
			  //if($details['carpet_desc']==""){ 
				  if($details['carpet']=="Yes"){ 
					 $details['carpet_desc']= "Carpet: ".$details['c_bedroom']." Bed, "; 			
					 if($details['c_lounge']!=""){ if($details['c_lounge']=="Yes"){ $details['carpet_desc'].= " + Lounge "; } }
					 if($details['c_stairs']!=""){ $details['carpet_desc'].= $details['c_stairs']." stairs"; }
					 
					 $bool = mysql_query("update quote set carpet_desc='".$details['carpet_desc']."' where id=".$details['id']."");				 
					 $details['carpet_desc'].= $eol;
				  }
			  //}
			  
			   $other_types = mysql_query("Select * from job_type");
			   while($r = mysql_fetch_assoc($other_types)){			  			  
				  	if($details[strtolower($r['name']).'_amount']!=""){ 
						$descx = "";
						if($details[strtolower($r['name']).'_desc']!=""){ $descx = $details[strtolower($r['name']).'_desc']; }else{ $descx= $r['name']; }
						  $invoice_details.='<tr class="text12">
							  <td valign="top" bgcolor="#ebebeb">'.$descx.'</td>				   
							  <td align="center" valign="top" bgcolor="#ebebeb">'.$details[strtolower($r['name']).'_amount'].'</td>
							</tr>';  
					}
			   }*/
			    $quote_details = mysql_query("Select * from quote_details where quote_id=".$quote['id']);
			    while($r = mysql_fetch_assoc($quote_details)){			  			  
				  	//if($details[strtolower($r['name']).'_amount']!=""){ 
						$descx = "";
						
						  $invoice_details.='<tr class="text12">
							  <td valign="top" bgcolor="#ebebeb">'.$r['job_type'].':'.$r['description'].'</td>				   							  
							  <td align="center" valign="top" bgcolor="#ebebeb">'.$r['amount'].'</td> 
							</tr>';  
					//}
			   }
         	$getemailNotes =   mysql_fetch_assoc( mysql_query("SELECT * FROM `quote_email_notes` WHERE id = 1"));
				//print_r($details);
				$file = "quote.php";
				ob_start(); // start buffer
				include ($_SERVER['DOCUMENT_ROOT']."/email_template/".$file);
				$content = ob_get_contents(); // assign buffer contents to variable
				ob_end_clean(); // end buffer and remove buffer contents			
				
				if($sendemail==true){ 
				
				   $heading =  ucfirst($details['name']).", Please check your Bond Cleaning Quote Q#".$quote_id." from ".$sites['domain']."";
				   //$heading = "Bond Cleaning Quote (Q#".$quote_id.") to ".ucfirst($details['name'])." (".$details['suburb'].") from  ".$sites['domain']."";
				
					sendmail($details['name'],$details['email'],$heading,$content,$sites['email'],$details['site_id']);
					sendmail($details['name'],"quotes@bcic.com.au",$heading,$content,$sites['email'],$details['site_id']);
				
					add_quote_emails($quote_id,$heading,$content,$details['email']);
					//add_job_emails($quote['booking_id'],"Bond Cleaning Quote from ".$sites['domain'],$content,$details['email']);
					return error("Quote Sent Successfully..");
				}else{
					return $content;
				}
				
		}else{
			return error("Found issue while creating this Quote Please contact ADMIN".$quote_id);
		}
	  }else{
		  return error("Found issue while creating this Quote Please contact ADMIN".$quote_id);
	  }
}


function invoice_email($quote_id,$job_type,$sendmail,$type= null){	  
	  
	  if($quote_id!=""){ 
			$details_data =mysql_query("select * from quote_new where id=".mysql_real_escape_string($quote_id)."");
	
			if(mysql_num_rows($details_data)>0){
				$details =  mysql_fetch_array($details_data);
				$quote = $details;
				$job_id = $details['booking_id'];
				  
			  $jobdetails = mysql_fetch_array(mysql_query("select work_guarantee,work_guarantee_text from  jobs where id=".$job_id.""));
			  
			     if(!empty($jobdetails)) {
				 
				    if($jobdetails['work_guarantee'] == 2) {
						
					  $work_guarantee_text = $jobdetails['work_guarantee_text'];
					  $work_guarantee = $jobdetails['work_guarantee'];
					  
				    }else{
						$work_guarantee_text = '';
					    $work_guarantee = '';
					}
				  
			    } 
			  
			  
			  
			  //$sites = mysql_fetch_array($site_data);		

					$site_data = mysql_query("select * from sites where id=".$details['site_id']."");
					$sites = mysql_fetch_array($site_data);					  
			  
			  $staff_data = mysql_query("select * from staff where id in (Select staff_id from job_details where job_id=".$job_id." and job_type_id in (select id from job_type where inv=1))");
			  $staff = mysql_fetch_array($staff_data);
			  
			  $getemailNotes =   mysql_fetch_assoc( mysql_query("SELECT * FROM `quote_email_notes` WHERE id = 3"));
			  
			  //print_r($staff);
			  
			  $details['site_logo'] =   $sites['logo'];
			  $details['site_url'] =   $sites['domain'];
			  $details['term_condition_link'] =   $sites['term_condition_link'];
			  $details['site_email'] =   $sites['email'];
			  $details['site_phone'] =   $sites['phone'];
			  $details['to'] = $quote['name']."<br>".$quote['address']."<br>".$quote['phone'];
			  $details['gst']  = $staff['staff_gst'];
			  $details['work_guarantee_text']  = $work_guarantee_text;
			  $details['work_guarantee']  = $work_guarantee;
			 
			  

			      
			  /* if($quote['address'] == '') {
			     $details['to'] = $quote['name'].'</br><input type="text" id="address" onblur="address_save(this,\'quote_new.address\',\''.$quote['id'].'\');"><br>'.$quote['phone'];
			      
			  }else {
			     $details['to'] = $quote['name']."<br>".$quote['address']."<br>".$quote['phone'];
			  } */
			  
			  if($staff['company_name']!=""){ 
			  	$details['staff_name'] = $staff['company_name']."<br>".$staff['name'];
			  }else{
			  	$details['staff_name'] = $staff['name'];
			  }
			  $details['staff_abn'] = "ABN:".$staff['abn'];
			 
			 
			  $invoice_status = get_rs_value("jobs","invoice_status",$job_id);
			  if($invoice_status=="1"){ $details['invoice_status'] = "<strong>Paid</strong>"; }else{ $details['invoice_status'] = "<strong>Pending</strong>"; }
			  
			  /* if($details['cleaning_desc']==""){ 
					$details['cleaning_desc'] = $details['bed']." Beds ".$details['bath']." Bath ".$details['property_type']." ".$details['blinds_type'];
				   if($details['furnished']=="Yes"){ $details['cleaning_desc'].= " Furnished "; }
				   
				   $bool = mysql_query("update quote set cleaning_desc='".$details['cleaning_desc']."' where id=".$details['id']."");
				   $details['cleaning_desc'].= $eol;				  
			  }
			  if($details['carpet_desc']==""){ 
				  if($details['carpet']=="Yes"){ 
					 $details['carpet_desc']= $details['c_bed']."Bed, ".$details['c_lounge']." Lounge, "; 			
					 if($details['c_stairs']!=""){ $details['carpet_desc'].= $details['c_stairs']." stairs"; }
					 
					 $bool = mysql_query("update quote set carpet_desc='".$details['carpet_desc']."' where id=".$details['id']."");				 
					 $details['carpet_desc'].= $eol;
				  }
			  }*/
				
				//$details['to'].="Select * from job_details where job_id=".$job_id." and job_type in (select id from job_type where inv=1)";

			   $invoice_details='';  
				$total_amt = 0;	
			   $other_types = mysql_query("Select * from job_details where job_id=".$job_id." and status != 2 and job_type_id in (select id from job_type where inv=1)");
			   while($r = mysql_fetch_assoc($other_types)){		
			       
			   // echo "<pre>";   print_r($r);
				  	
					 $descx= get_sql("quote_details","description","where quote_id=".$r['quote_id']." and job_type_id=".$r['job_type_id']." and status=0");
					 if($descx==""){ 
					 	edit_quote_str($r['quote_id']);
						$descx.= get_sql("quote_details","description","where id=".$r['quote_id']." and job_type_id=".$r['job_type_id']." and status=0");
					 }
					 $invoice_details.='<tr class="text12"><td valign="top" bgcolor="#ddd" style="color:  #333;padding: 10px 5px;background: #f1f1f1;">'.$r['job_type'].': '.$descx.'</td>';
					 $invoice_details.='<td align="center" valign="top" bgcolor="#ebebeb" style="background: #03b9d5;color: #fff;;padding: 10px 5px;">'.$r['amount_total'].'</td></tr>'; 	
					 $total_amt = ($total_amt+$r['amount_total']);			 
			   }
			   $details['amount'] = $total_amt;
	    //echo $invoice_details; die;
				//print_r($details);
				if($sendmail=="true"){ 
					$file = "invoice_old.php";
				//	$file = "invoice.php";
				}else{
					$file = "invoice.php";
				}
				//echo $_SERVER['DOCUMENT_ROOT']."/email_template/".$file;
				ob_start(); // start buffer
				

				include ($_SERVER['DOCUMENT_ROOT']."/email_template/".$file);
				$content = ob_get_contents(); // assign buffer contents to variable
				ob_end_clean(); // end buffer and remove buffer contents			
				
				//echo $content;
				
				if($sendmail=="true"){ 
					
					if($type == 'members'){
					  sendmailwithattachinvoce($details['name'],$details['email'],"Bond Cleaning Invoice from ".$sites['domain'],$content,$sites['email'],$details['site_id'],$quote_id);
					}else{
					    sendmail($details['name'],$details['email'],"Bond Cleaning Invoice from ".$sites['domain'],$content,$sites['email'],$details['site_id'],$quote_id);
					}
					//sendmail($details['name'],"crystal@bcic.com.au","Bond Cleaning Invoice from ".$sites['domain'],$content,$sites['email'],$details['site_id']);
					
					//sendmail($details['name'],"manish.khanna1@gmail.com","Bond Cleaning Invoice from ".$sites['domain'],$content,$sites['email'],$details['site_id']);
					
					add_job_emails($job_id,"Bond Cleaning Invoice from ".$sites['domain'],$content,$details['email']);
					return error("Invoice Sent Successfuly");
				}else{
					return $content;
				}
				
		}else{
			return error("Found issue while creating this Quote Please contact ADMIN".$quote_id);
		}
	  }else{
		  return error("Found issue while creating this Quote Please contact ADMIN".$quote_id);
	  }
}

function journal_email($staff_id){
	ob_start(); // start buffer
	include ($_SERVER['DOCUMENT_ROOT']."/admin/xjax/view_journal_new.php");
	$content = ob_get_contents(); // assign buffer contents to variable
	$_SESSION['journal_email'] = $content;
	ob_end_clean(); // end buffer and remove buffer contents			
	return $content;
}


		function send_email_agent_msg($job_id){
			//echo
			//$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".mysql_real_escape_string($job_id).""));
			 $quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mysql_real_escape_string($job_id).""));
			$jobDetails = mysql_fetch_array(mysql_query("select * from job_details where job_id=".mysql_real_escape_string($job_id)." AND status != 2")); 
			
			$eol = "<br>";

		   $str = 'Hello '.$jobDetails['agent_name'].$eol.$eol.'We had conducted the bond clean at  '.$quote['address'].'
		on '.changeDateFormate($jobDetails['job_date'], 'datetime').''.$eol.$eol.'
		Please confirm if the property has passed your inspection in order for us to close off this job '.$eol;

			$str .= 'Should we not hear back from you in the next 24 hours we will consider this job as closed.';
			$subject = "Job Id (J#".$job_id.") - ".$quote['address']."";
		  
			$to = $jobDetails['agent_email'];			
			//$to = 'manish@bcic.com.au';			
			$subject = "Job Id ".$job_id." - ".$quote['address']."";
			sendmailbcic($jobDetails['agent_name'],$to,$subject,$str,"reclean@bcic.com.au","0");
		}

	function send_email_reclean_agent_msg($job_id){
		
		$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mysql_real_escape_string($job_id).""));
		$jobDetails = mysql_fetch_array(mysql_query("select * from job_details where job_id=".mysql_real_escape_string($job_id)." AND status != 2 order by job_type_id asc limit 0, 1")); 
		$getJob_date = mysql_fetch_array(mysql_query("select reclean_date from job_reclean where job_id=".mysql_real_escape_string($job_id)." AND status != 2 order by job_type_id asc limit 0, 1")); 
		
		$eol = "<br>";

		$str = 'Hello '.$jobDetails['agent_name'].$eol.$eol.'We had conducted the bond clean at  '.$quote['address'].'
		and will like to confirm that the reclean was completed by our cleaner on  '.changeDateFormate($getJob_date['reclean_date'], 'datetime').''.$eol.$eol.'
		Please confirm if the property has passed your inspection in order for us to close off this job. '.$eol;

		$str .= 'Should we not hear back from you in the next 24 hours we will consider this job as closed.';
		$subject = "RE:Job Id (J#".$job_id.") - ".$quote['address']."";  		
		//echo $str; 
		$to = $jobDetails['agent_email'];		
	    sendmailbcic($jobDetails['agent_name'],$to,$subject,$str,"reclean@bcic.com.au","0");
	}
?>
