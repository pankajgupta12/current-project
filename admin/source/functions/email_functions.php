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
		
		return error("Staff Payment Report");
	}else{
		return $str;
	}
}

function send_cleaner_details_temp($job_id){
	
	$eol = "\r\n";
	$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mysql_real_escape_string($job_id).""));	
	$job_details = mysql_query("select * from job_details where job_id=".mysql_real_escape_string($job_id)." AND status != 2 ");		
	$quote_for_option = mysql_fetch_array(mysql_query("select * from quote_for_option where id=".$quote['quote_for'].""));
		 
		$c_str = "";
		
		while($jd = mysql_fetch_assoc($job_details)){
			
			$quote_details = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".$jd['quote_id']." and job_type_id=".$jd['job_type_id'].""));
			 
			if($quote_details['job_type_id'] == 11) {
				
			 	$truckList = mysql_fetch_array(mysql_query("select * from truck_list where id =".$quote_details['truck_type_id']));
					
					$bcic_amount = $truckList['amount'];
					$truck_type_name = $truckList['truck_name'];
					$cubic_meter = $truckList['cubic_meter'];
				
					$siteUrl1  = Site_url;
					$qu_id = base64_encode($quote['id']);
					$url = $siteUrl1."/members/".$qu_id."/inventory"; 
					$c_str.="<strong>".$jd['job_type']."</strong>: ".$quote_details['description'].'<br>';
					$c_str.= '<strong>Moving From :</strong> '.$quote['moving_from'].$eol.'<br>
					<strong>Moving To :</strong> '.$quote['moving_to'].$eol.'<br>';
					
					//Quote for '.$r['hours'].' Hours x $'.$bcic_amount.' / hour for '.$truck_type_name.' '.$cubic_meter.'cm3 <br>
					//$c_str.= 'Estimated Cubic metres: '.$quote_details['cubic_meter'].' Cm3'.$eol.'<br>';
					
					$c_str.= 'Estimated  '.$quote_details['hours'].' Hours x $'.$bcic_amount.' / hour for '.$truck_type_name.' '.$cubic_meter.'cm3 '.$eol;
			}else{
				$c_str.="<strong>".$jd['job_type']."</strong>: ".$quote_details['description'].''.$eol;
			}
		}
		
	  
$eol = "<br>";
$str = 'Hello '.$quote['name'].$eol.$eol.'We are all set for your job on '.changeDateFormate($quote['booking_date'],'datetime').''.$eol;
$str.= $c_str.$eol;

//$str.='Your '.$quote_for_option['subject_name'].'(s) details are:<br><br>'.$c_str.$eol;

$str.='<br><br>Job ID: '.$job_id.''.$eol;
$str.='Job Date: '.changeDateFormate($quote['booking_date'] , 'datetime').''.$eol.'
Address: '.$quote['address'].''.$eol.'';
$str.='Estd. Amount:$'.$quote['amount'].''.$eol.''.$eol.'';

//Please if you can advise me what arrangements you will make to ensure the cleaner can get access to the property?'.$eol.'
//Could you please advise the mode of payment?'.$eol.'';
	
	return $str;
	
}

function send_email_conf_template($job_id){
	
	$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".mysql_real_escape_string($job_id).""));
	$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mysql_real_escape_string($job_id).""));
	$site = mysql_fetch_array(mysql_query("select * from sites where id=".mysql_real_escape_string($quote['site_id']).""));
	$jobpayment = mysql_fetch_array(mysql_query("select sum(amount) as amount1 from job_payments where job_id=".mysql_real_escape_string($job_id).""));
	
	
	$quote_for_option = mysql_fetch_array(mysql_query("select * from quote_for_option where id=".$quote['quote_for'].""));
	
	if($quote['quote_for'] == 1) {
		$domain = $site['domain'];
		$term_condition_link = $site['term_condition_link'];
	}else if($quote['quote_for'] == 2 || $quote['quote_for'] == 4){
		 $domain = $quote_for_option['site_url'];
		 $term_condition_link = $quote_for_option['term_condition_link'];
	}else if($quote['quote_for'] == 3){
		$domain = $site['br_domain'];
		$term_condition_link = $site['br_term_condition_link'];
	}else{
		$domain = $site['domain'];
		$term_condition_link = $site['term_condition_link'];
	}
	
	 $checkQUotetype = mysql_fetch_assoc(mysql_query("select job_type_id from quote_details where quote_id=".mysql_real_escape_string($quote['id'])." AND job_type_id = 11"));  
	
	  $subtext = $quote_for_option['subject_name'];
	           if($checkQUotetype['job_type_id'] == 11 && $quote['quote_for'] == 1) { 
			      
				   $domain =   $site['br_domain'];	
			     $subtext = 'Removal';
			    }
				
	
	$eol = "\r";
	$date_txt = 'Date';
	$amt_txt = 'Estd.';
	$addr = 'Address: '.$quote['address'].''.$eol;
	$phonenumber = 'Phone: '.$quote['phone'].''.$eol;
	
	if($checkQUotetype['job_type_id'] == 11) { 
			      
		$date_txt = 'Moving Date';
		$amt_txt = 'Min.';
		$addr = $eol;
	}
				
	$str = '';
	$str .= 'Hello '.$quote['name'].$eol.$eol.'Thanks for choosing '.$domain.''.$eol.'
	This email is to confirm that your '.$subtext.' job is booked with us. '.$eol.$eol.'
	Job Id: '.$job_id.''.$eol.'
	'.$date_txt.' : '.date("d M Y",strtotime($quote['booking_date'])).''.$eol.'
	'.$addr.'  '.$phonenumber;
	$str.=$amt_txt.' Amount:$'.$quote['amount'].''.$eol.'';
				

if($jobpayment['amount1']>0) {
	   $str.='Amount Received: $'.$jobpayment['amount1'].''.$eol; 
	 } 

$job_details = mysql_query("select * from job_details where job_id=".mysql_real_escape_string($job_id)." AND status != 2 AND job_type_id != 20");
$c_str = "";
 while($jd = mysql_fetch_assoc($job_details)){
	$quote_details = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".$jd['quote_id']." and job_type_id=".$jd['job_type_id'].""));
	       if($jd['job_type_id'] == 11) {
				
					$siteUrl1  = Site_url;
					$qu_id = base64_encode($quote['id']);
					$url = $siteUrl1."/members/".$qu_id."/inventory"; 
					//$bcic_amount = check_cubic_meter_amount($quote_details['cubic_meter']);
					//$bcic_amount = get_rs_value("truck_list","amount",$quote_details['truck_type_id']);
					
					$truckList = mysql_fetch_array(mysql_query("select * from truck_list where id =".$quote_details['truck_type_id']));

								$bcic_amount = $truckList['amount'];
								$truck_type_name = $truckList['truck_name'];
								$cubic_meter = $truckList['cubic_meter'];
								
					
				$q_desc  = $eol.'Moving From : '.$quote['moving_from'].' ,'.$eol.' Moving To : '.$quote['moving_to'].$eol; 
				//Quote Booked for '.$jd['hours'].' Hours x $'.$bcic_amount.' / hour for '.$truck_type_name.' '.$cubic_meter.'cm3 '.$eol;
				//Quote for '.$quote_details['hours'].' Hours x $'.$bcic_amount.' / hour for '.$quote_details['cubic_meter'].' Cubic Meter'.$eol;
				
				$getemailNotes1 =   mysql_fetch_assoc( mysql_query("SELECT notes FROM `quote_email_notes` WHERE emal_type = 'booking_confirmation' AND quote_for_type_id = 3"));				   
				    $br_in_bcic = 1;
			        $domain =   $site['br_domain'];					 
					$br_term_condition_link =   $site['br_term_condition_link'];
					$br_inclusion_link =   $site['br_inclusion_link'];
				
				
			}else{
				$q_desc  ="";
				$getemailNotes =   mysql_fetch_assoc(mysql_query("SELECT * FROM `quote_email_notes` WHERE quote_for_type_id = ".$quote['quote_for']."  AND  emal_type = 'booking_confirmation'"));
			}
		
	    $c_str.="".$jd['job_type'].": ".$quote_details['description'].$q_desc.''.$eol;
 }

$str.=$c_str.$eol;

$str.='Please Notes :-'.$eol;
$str.=strip_tags($getemailNotes['notes']).$eol;

if($br_in_bcic == 1) {
//$str.='BR'.$eol;
//$str.=strip_tags($getemailNotes1['notes']).$eol;
$link = "<a href='".$term_condition_link."'>term & conditions</a>";
$str.=str_replace('$tc',$link,strip_tags($getemailNotes1['notes'])).$eol;
}

if($checkQUotetype['job_type_id'] != 11) { 
  
	$str .='Credit Card (1 day Prior)'.$eol.'------------------------'.$eol.'
	Please make sure that you send us the paid receipt of bank transfer.'.$eol.'
	Please enter your Job Id for reference.'.$eol.'
	Account Name: '.$quote_for_option['account_name'].$eol.'
	BSB : '.$quote_for_option['bsb'].$eol.'
	Account No: 295683522'.$eol.''.$eol.'

	Bank Transfer (3 days Prior)'.$eol.'------------------------'.$eol.'
	To Pay by Card, Please call on our Office Number'.$eol.'
	Office number:'.$eol.'
	'.$site['site_phone_number'].' '.$eol.''.$eol.'
	For Terms and Conditions, please refer to our website.'.$eol.'';

}

return trim($str);

}

function send_email_conf($job_id,$action = null){
	
	$var = explode('|',$action);
	$eol = '<br/>';
	$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".mysql_real_escape_string($job_id).""));
	$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mysql_real_escape_string($job_id).""));
	$site = mysql_fetch_array(mysql_query("select * from sites where id=".mysql_real_escape_string($quote['site_id']).""));
	$jobpayment = mysql_fetch_array(mysql_query("select sum(amount) as amount1 from job_payments where job_id=".mysql_real_escape_string($job_id).""));
	
	$quote_for_option = mysql_fetch_array(mysql_query("select * from quote_for_option where id=".$quote['quote_for'].""));
	
	
		if($quote['quote_for'] == 1) {
			$domain = $site['domain'];
			$term_condition_link = $site['term_condition_link'];
		}else if($quote['quote_for'] == 2 || $quote['quote_for']){
			 $domain = $quote_for_option['site_url'];
			 $term_condition_link = $quote_for_option['term_condition_link'];
		}else if($quote['quote_for'] == 3){
			$domain = $site['br_domain'];
			$term_condition_link = $site['br_term_condition_link'];
		}else{
			$domain = $site['domain'];
			$term_condition_link = $site['term_condition_link'];
		}
	
	 $checkQUotetype = mysql_fetch_assoc(mysql_query("select job_type_id from quote_details where quote_id=".mysql_real_escape_string($quote['id'])." AND job_type_id = 11"));  
	    $check_quote = 0;
		$amttext = 'Estd';
		$jobdatetext = 'Job Date';
	    if($checkQUotetype['job_type_id'] == 11) {
			$check_quote = 1;
		   $domain = $site['br_domain'];
		   	$amttext = 'Min';
			$jobdatetext = 'Moving Date';
	    }
	
	if($check_quote == 1) {
	     $str = 'Hello '.$quote['name'].'<br><br>Thanks for choosing <a href="'.$domain.'">'.$domain.'</a><br>
	     This email is to confirm that your Removal job is booked with us. <br><br>';
	}else {
		$str = 'Hello '.$quote['name'].'<br><br>Thanks for choosing <a href="'.$domain.'">'.$domain.'</a><br>
	    This email is to confirm that your '.$quote_for_option['subject_name'].' job is booked with us. <br><br>';
	}
	
	$str .= 'Job Id: '.$job_id.'<br>
	'.$jobdatetext.' : '.date("d M Y",strtotime($quote['booking_date'])).'<br>';	
	if($check_quote != 1) {
	  $str .='Address: '.$quote['address'].'<br>';
	}
	 $str .=' <strong>Phone: </strong> : '.$quote['phone'].'<br>';
	$str.=$amttext.' Amount: $'.$quote['amount'].'<br>';
	//echo $str;
	 
	$job_details = mysql_query("select * from job_details where job_id=".mysql_real_escape_string($job_id)." AND status != 2 AND job_type_id != 20 order by job_type_id asc");
	
	
	   $countRecords = mysql_num_rows($job_details);
	
		$c_str = "";
		while($jd = mysql_fetch_assoc($job_details)){
			 
			// print_r($jd);
			 $quote_details = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".$jd['quote_id']." and job_type_id=".$jd['job_type_id'].""));
			 
			
			if($quote_details['job_type_id'] == 11) {
				
				   if($countRecords > 1) {
					   $jobdate = '<strong> BR Job date </strong>  ('.changeDateFormate($jd['job_date'] , 'datetime').')<br>';
					}else{
						 $jobdate = '';
					}
				
					$siteUrl1  = Site_url;
					$qu_id = base64_encode($quote['id']);
					//$bcic_amount = check_cubic_meter_amount($quote_details['cubic_meter']);
					
					//$bcic_amount = get_rs_value("truck_list","amount",$quote_details['truck_type_id']);
					$truckList = mysql_fetch_array(mysql_query("select * from truck_list where id =".$quote_details['truck_type_id']));
					
					$bcic_amount = $truckList['amount'];
					$truck_type_name = $truckList['truck_name'];
					$cubic_meter = $truckList['cubic_meter'];
					
					
				$url = $siteUrl1."/members/".$qu_id."/inventory"; 
				$c_str.="<strong>".$jd['job_type']."</strong>: ".$quote_details['description'].''.$eol;
				$c_str.= '<strong>Moving From :</strong> '.$quote['moving_from'].' , <strong><br>Moving To :</strong> '.$quote['moving_to'].' <br>';
				
						//'.$jobdate.' Quote for '.$quote_details['hours'].' Hours x $'.$bcic_amount.' / hour for '.$truck_type_name.' '.$cubic_meter.'cm3'.$eol;
						
						//Please <a href='.$url.'> Click </a> here to View your Inventory
						
					$getemailNotes1 =   mysql_fetch_assoc( mysql_query("SELECT * FROM `quote_email_notes` WHERE emal_type = 'booking_confirmation' AND quote_for_type_id = 3"));

					$br_in_bcic = 1;
					$domain =   $site['br_domain'];					 
					$br_term_condition_link =   $site['br_term_condition_link'];
					$br_inclusion_link =   $site['br_inclusion_link'];			
						
			}else{
				$br_in_bcic = 0;
				$c_str.="<strong>".$jd['job_type']."</strong>: ".$quote_details['description'].''.$eol;
				$getemailNotes =   mysql_fetch_assoc( mysql_query("SELECT * FROM `quote_email_notes` WHERE quote_for_type_id = ".$quote['quote_for']."  AND  emal_type = 'booking_confirmation'"));
			}
			
		}
		
	if($quote['ssecret'] != '' && $check_quote == 0)  {
              
			  $Protocol = ($_SERVER['HTTPS'] == 'on') ? "https://" : "http://" ;
			  $siteUrl1  = Site_url;
			  //images_upload&imgtype=job&type=1&secret=GRJfhbi4zptoUmEX
			  //$url = $siteUrl1."/members/quote/index.php?action=checkkey&secret=".$details['ssecret']; 
			  $url = $siteUrl1."/members/quote/index.php?task=images_upload&imgtype=job&type=1&secret=".$quote['ssecret']; 
			  
			  $click = '<a href="'.$url.'">click</a>';
			  
			  $c_str.=  '<span style="margin-top: -38px;float: right;font-size: 18px;margin-right: 33px;font-weight: 600;border: 1px solid;padding: 7px;color: #c75050;">Please be advised all our quotes are estimates.</span>';
			  
	        //  $c_str.=  '<span style="margin-top: -38px;float: right;font-size: 15px;margin-right: 110px;font-weight: 600; border: 1px solid; padding: 7px;">Please upload your Before images '.$click.' on the link <br/> given below of the most concerned areas for an accurate quote.</span>';
	}
	
	$str.=$c_str.$eol;
	
		if($jobpayment['amount1']>0) {
		   $str.='<b>Amount Received $'.$jobpayment['amount1'].'</b><br>'; 
		} 
		
		if($jobs['payment_agree_check'] != 0) {
	       $str.= '<br><b>' .getSystemvalueByID($jobs['payment_agree_check'],107).'</b><br>';
		}
	
	/* if($jobs['payment_agree_check'] == '1' && $jobs['payment_agree_check'] == '1'){
		 if($check_quote == 1) {
			 $str.='<br><b>You have Agreed to charge this credit card on completion of the move for remaining hours</b><br>';
		 }else{
	       $str.='<br><b>You have Agreed to charge this credit card a day before of job for remaining amount</b><br>';
		 }
	} */
	
	
	$str.= $eol;
	$str.= '<strong>Please Notes </strong>';
	$str.= '<div>';
	$str.= str_replace('$tc','<a href='.$term_condition_link.'>term & conditions</a>',$getemailNotes['notes']); 
	$str.= '</div>';
	
	if($br_in_bcic == 1 && $check_quote == 1) {	
		
			 $br_term_condition_link1   =  '<a href='.$br_term_condition_link.'>term & conditions</a>';
			 $url1   =  '<a href='.$url.'> Click </a>';
			 $br_inclusion_link1   =  '<a href='.$br_inclusion_link.'> Click </a>';
		
			$search1 = array('$inclusion', '$tc' , '$inventory');  
			$replace1 = array($br_inclusion_link1, $br_term_condition_link1 , $url1); 
			
			$str.= '<div style="margin-left: 26px;padding:  8px;margin-bottom: 21px; margin-top: 6px;">';
			$str.= str_replace($search1, $replace1, $getemailNotes1['notes']); 
			$str.= '</div>';
		}
	
    if($check_quote != 1) {	
		$str.='<table width="760" border="0" cellspacing="3" cellpadding="3">
	  <tr>
		<td align="center" class="text12"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>Credit Card (1 day Prior)</strong></font></td>
		<td align="center" class="text12"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>Bank Transfer (3 days Prior)</strong></font></td>
	  </tr>
	  <tr>
		<td class="text12"> <font size=\"2\" face=\"Arial, Helvetica, sans-serif\">To Pay by Card, Please call on our Office Number<br>
		Office number:<br>
		'.$site['site_phone_number'].'
		</font></td>
		<td class="text12"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Please make sure that you send us the paid receipt of bank transfer.<br>
		Please enter your <strong>Job Id for reference</strong>. <br>
		Account Name: '.$quote_for_option['account_name'].'<br>
		BSB : '.$quote_for_option['bsb'].'<br>
		Account No: 295683522<br></font>
		</td>
		</tr> 
		</table>
		For Terms and Conditions, please refer to our website.<br>';
    }
	//echo $str; die;
	 if($check_quote == 1) {
		  $subject = "Removal Booking Confirmation from ".$domain." Job Id #".$job_id;
	 }else {
		  $subject = $quote_for_option['subject_name'] ."  Booking Confirmation from ".$domain." Job Id #".$job_id;
	 }
	 
	
	sendmail($quote['name'],$quote['email'],$subject,$str,$quote_for_option['email_out_booking'],$quote['site_id'] ,$quote['quote_for']);	
	
	add_job_emails($job_id, $subject, $str,$quote['email']);
}

function send_cleaner_details($job_id){
	//$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".mysql_real_escape_string($job_id).""));
	$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mysql_real_escape_string($job_id).""));
	$sites = mysql_fetch_array(mysql_query("select * from sites where id=".mysql_real_escape_string($quote['site_id']).""));
	
	$getQuotetype =  mysql_fetch_assoc(mysql_query("SELECT * FROM `quote_for_option` where id = ".$quote['quote_for'].""));
			  
			$job_type_id = get_sql("job_details","job_type_id"," where job_type_id='11' AND job_id='".$job_id."' AND status != 2");
			  
			if($job_type_id == 11) {
				$domain =   $sites['br_domain'];
				$string = 'Removal Specialist';
				$text_subj = 'Removal';
			} else{
				 if($quote['quote_for'] == 2) {
					$domain =   $getQuotetype['site_url']; 
				 }else{
				  $domain =   $sites['domain'];	 
				 }
				
				$string = 'Cleaner';
				$text_subj = 'Bond Cleaning ';
			} 
			  
	
	/* if($quote['quote_for'] == 3) {
		$string = 'Removal Specialist';
	}else{
		$string =  'Cleaner'; 
	} */
	
	$subject = $string ." Details  from ".$domain." Job Id #".$job_id;
	$str = send_cleaner_details_temp($job_id);	
	
	sendmail($quote['name'],$quote['email'],$subject,$str,$getQuotetype['booking_email'],$quote['site_id'] , $quote['quote_for']);
	
	
	add_job_emails($job_id,$subject,$str,$quote['email']);
}


/* function sms_send_cleaner_details($job_id){
	
    return  send_cleaner_details_temp($job_id);	
	//add_job_emails($job_id,"SMS Cleaner Details for Bond Cleaning",$str,$quote['email']);
} */


    function quote_email($quote_id,$sendemail){
		
	    if($quote_id!=""){
		  
			$details_data =mysql_query("select * from quote_new where id=".mysql_real_escape_string($quote_id)."");
	
			if(mysql_num_rows($details_data)>0){
				$details =  mysql_fetch_array($details_data);
				$quote = $details;
			
			  $site_data = mysql_query("select * from sites where id=".$details['site_id']."");
			  $sites = mysql_fetch_array($site_data);
			
			$getQuotetype =  mysql_fetch_assoc(mysql_query("SELECT * FROM `quote_for_option` where id = ".$details['quote_for'].""));
			
			
			  $checkQUotetype = mysql_fetch_assoc(mysql_query("select job_type_id from quote_details where quote_id=".mysql_real_escape_string($quote_id)." AND job_type_id = 11"));  
		
			   $siteUrl1  = Site_url;
			   
			   //echo $details['quote_for'];
			 //  print_r($getQuotetype);
			   
			    if($details['quote_for'] == '3') {
					$details['site_url'] =   $sites['br_domain'];

					$details['term_condition_link'] =   $sites['br_term_condition_link'];
					$details['inclusion_link'] =   $sites['br_inclusion_link'];

					$newlogo = get_rs_value("siteprefs","bcic_new_logo",1);
					$details['site_logo'] =   $siteUrl1.'/'.$newlogo;
					  
			    }elseif($details['quote_for'] == '2' || $details['quote_for'] == '4') {
						$details['site_url'] =   $getQuotetype['site_url'];
						$details['term_condition_link'] =   $getQuotetype['term_condition_link'];
						$details['inclusion_link'] =   $getQuotetype['inclusion_link'];
						
						if($details['quote_for'] == '2') {
						   $details['site_logo'] =   $getQuotetype['company_logo'];
						}else{
							 //$newlogo = get_rs_value("siteprefs","bcic_new_logo",1);
						     $details['site_logo'] =   $siteUrl1.'/'.$getQuotetype['logo_name'];
						}
			    }else{
					$details['site_url'] =   $sites['domain'];					 
					$details['term_condition_link'] =   $sites['term_condition_link'];
					$details['inclusion_link'] =   $sites['inclusion_link'];
					
						$newlogo = get_rs_value("siteprefs","bcic_new_logo",1);
						$details['site_logo'] =   $siteUrl1.'/'.$newlogo;
			    }
			  
			  
			//echo $details['quote_for']; die;
			 
			  $details['quote_for'] =   $details['quote_for'];	
			  $details['step'] =   $quote['step'];	
			  
			  
			  $details['site_email'] =   $sites['email'];
			  //$details['site_phone'] =   $sites['phone'];  //commented on 07-3-2019
			  
			  //added by monu to change number for better removal quotes
			  if($checkQUotetype['job_type_id']==11){
				  $details['site_phone']='1300 766 422';
			  }
			  else{
				    if($quote['quote_for'] == 2){
						$details['site_phone'] =   '1300 838 722';
					}else{
				      $details['site_phone'] =   $sites['phone'];
					}
			  }
			
			 // $details['ssecret'] =   $details['ssecret'];
			 
			  
			  $details['to'] = $quote['name']."<br>".$quote['address']."<br>".$quote['phone'];
					  
			  
			    $quote_details = mysql_query("Select * from quote_details where quote_id=".$quote['id']."  AND job_type_id != 20 Order by job_type_id asc");
				
				$countRecords = mysql_num_rows($quote_details);
				$invoice_details = '';
				
				$qudiscount = 0;
			//	$br_in_bcic
				
			    while($r = mysql_fetch_assoc($quote_details))
				{	
			       // if($r['job_type_id'] != 20) { 
					
							$descx = "";
						$invoice_details.='<tr class="text12" style="background-color:#ebebeb;">';
						
						$qu_id = base64_encode($quote['id']);
						$url = $siteUrl1."/members/".$qu_id."/inventory"; 
						
						if($r['job_type_id'] == 11) 
						{

							if($countRecords > 1) {
							   $jobdate = '<strong> Job date </strong>  ('.changeDateFormate($r['booking_date'] , 'datetime').')<br>';
							}else{
								 $jobdate = '';
							}
					
					   
						$truckList = mysql_fetch_array(mysql_query("select * from truck_list where id =".$r['truck_type_id']));
						
						$bcic_amount = $truckList['amount'];
						$truck_type_name = $truckList['truck_name'];
						$cubic_meter = $truckList['cubic_meter'];
		
					
							$invoice_details.= '<td valign="top" style="background-color:#ebebeb;"><strong>'.$r['job_type'].'</strong>:'.$r['description'].'<br>
								<strong>From :</strong> '.$quote['moving_from'].' , <strong><br>To :</strong> '.$quote['moving_to'].' <br>'.$jobdate.'
							</td>';	
						
						//Quote for '.$r['hours'].' Hours x $'.$bcic_amount.' / hour for '.$truck_type_name.' '.$cubic_meter.'cm3 <br>
						
							
							
							$br_in_bcic = 1;
							$details['site_url'] =   $sites['br_domain'];					 
							$details['br_term_condition_link'] =   $sites['br_term_condition_link'];
							$details['br_inclusion_link'] =   $sites['br_inclusion_link'];
							
							$heading_text = 'Better Removal';
						
					}
					 else
					{
						
						 $br_in_bcic = 0;
						 
						
						   $invoice_details.= '<td valign="top" style="background-color:#ebebeb;"><strong>'.$r['job_type'].':</strong>'.$r['description'].'</td>';	
					
						 
						 //echo "SELECT * FROM `quote_email_notes` WHERE emal_type = 'email_quote' AND quote_for_type_id = ".$details['quote_for']."";
						 
						
						 
						   
						   
					}	
					
					if($checkQUotetype['job_type_id']==11){
					 $heading_text = 'Better Removal';
					    $getemailNotes1 =   mysql_fetch_assoc( mysql_query("SELECT * FROM `quote_email_notes` WHERE emal_type = 'email_quote' AND quote_for_type_id = 3"));	
					}else{
					 $getemailNotes =   mysql_fetch_assoc(mysql_query("SELECT * FROM `quote_email_notes` WHERE emal_type = 'email_quote' AND quote_for_type_id = ".$details['quote_for'].""));
					  $heading_text = 'Bond Cleaning';
					}			
					
					
					  	
						if($r['discount'] != 0 && $r['job_type_id'] == 1) {
							
						   $qudiscount = $r['discount'];
						   $invoice_details.= '<td align="center" valign="top" style="background-color:#ebebeb;">'.($r['amount']+$qudiscount).'</td> </tr>'; 
						   $invoice_details.= '<tr><td valign="top" style="background-color:#ebebeb;">Discount: </td>';
						   $invoice_details.= '<td align="center" valign="top" style="background-color:#ebebeb;"> - '.$r['discount'].'</td> </tr>'; 
						   
						}else{
							
							$invoice_details.= '<td align="center" valign="top" style="background-color:#ebebeb;">'.$r['amount'].'</td> </tr>'; 
						}	
					//}
			    }
         	    $details['url'] =   $url;
			
			
			 //echo $br_in_bcic; die;
			// print_r($getemailNotes); die;
			
			
				$file = "quote.php";
				ob_start(); // start buffer
				include($_SERVER['DOCUMENT_ROOT']."/email_template/".$file);
				$content = ob_get_contents(); // assign buffer contents to variable
				ob_end_clean(); // end buffer and remove buffer contents			
				
				if($sendemail==true){ 
				
				    $heading =  ucfirst($details['name']).", Please Check Your ".$heading_text." Quote Q#".$quote_id." from ".$details['site_url']."";
				
					sendmail($details['name'],$details['email'],$heading,$content,$sites['email'],$details['site_id'], $details['quote_for']);
					sendmail($details['name'],$getQuotetype['email_out_quote'],$heading,$content,$sites['email'],$details['site_id'] , $details['quote_for']);
				
					add_quote_emails($quote_id,$heading,$content,$details['email']);
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


function invoice_email($quote_id,$job_type,$sendmail,$type= null , $real_estate = null, $staff_id, $jobinv)

    {
	
	
	   //echo $quote_id; die;
		
	  
	if($quote_id!=""){
		  
			$details_data =mysql_query("select * from quote_new where id=".mysql_real_escape_string($quote_id)."");
	
			if(mysql_num_rows($details_data)>0){
				$details =  mysql_fetch_array($details_data);
				$quote = $details;
				$job_id = $details['booking_id'];
				
				$bbcapp_staff_id = $details['bbcapp_staff_id'];	
				  
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
			  
			  
			$re_ = 1;
			
			//echo $details['client_type']; die;
			/* if($details['client_type'] == 2) {
				$details['quote_for'] =  2;
				$re_ = 2;
			}else{
				$details['quote_for'] = $details['quote_for'];
			} */
           
		     $details['quote_for'] = $details['quote_for'];
		   
		    $site_data = mysql_query("select * from sites where id=".$details['site_id']."");
			$sites = mysql_fetch_array($site_data);					  
			  
			//$staff_data = mysql_query("select * from staff where id in (Select staff_id from job_details where job_id=".$job_id." and job_type_id in (select id from job_type where inv=1))");
			
			 $staff_data = mysql_query("select * from staff where id = ".$staff_id."");
			 $staff = mysql_fetch_array($staff_data);
			
			/* $staff_data = mysql_query("select * from staff where id in (Select staff_id from job_details where job_id=".$job_id." AND job_type_id='".$job_type_id."' AND job_type_id in (select id from job_type where inv=1))");
			$staff = mysql_fetch_array($staff_data); */

			
//echo  "SELECT * FROM `quote_for_option` where id = ".$details['quote_for'].""; die;

			$getQuotetype =  mysql_fetch_assoc(mysql_query("SELECT * FROM `quote_for_option` where id = ".$details['quote_for'].""));
			
			 /*print_r($getQuotetype);
			 die;*/
			  
			$siteUrl1  = Site_url;
				
			 $checkQUotetype = mysql_fetch_assoc(mysql_query("select job_type_id from quote_details where quote_id=".mysql_real_escape_string($quote_id)." AND job_type_id = 11")); 
			
			   
			
				 if($details['quote_for'] == '3') {
				      $details['site_url'] =   $sites['br_domain']; 
					   $details['term_condition_link'] =   $sites['br_term_condition_link'];
					   
							$newlogo = get_rs_value("siteprefs","bcic_new_logo",1);
							$details['site_logo'] =   $siteUrl1.'/'.$newlogo;
					 
			    }elseif($details['quote_for'] == '2' || $details['quote_for'] == '4') {
					
					   
					    $details['site_url'] =   $getQuotetype['site_url'];
						$details['term_condition_link'] =   $getQuotetype['term_condition_link'];
						$details['inclusion_link'] =   $getQuotetype['inclusion_link'];
						$details['site_logo'] =   $getQuotetype['company_logo'];
						
						if($details['quote_for'] == '2') {
						   $details['site_logo'] =   $getQuotetype['company_logo'];
						}else{
							 //$newlogo = get_rs_value("siteprefs","bcic_new_logo",1);
						     $details['site_logo'] =   $siteUrl1.'/'.$getQuotetype['logo_name'];
						}
						
			    }else{
					$newlogo = get_rs_value("siteprefs","bcic_new_logo",1);
					$details['site_logo'] =   $siteUrl1.'/'.$newlogo;
					$details['site_url'] =   $sites['domain'];
					$details['term_condition_link'] =   $sites['term_condition_link'];
			    }
				
		  
			// getQuotetype
			  $details['site_email'] =   $getQuotetype['booking_email'];
			  $details['site_phone'] =   $getQuotetype['phone'];
			  $details['to'] = $quote['name']."<br>".$quote['address']."<br>".$quote['phone'];
			  $details['gst']  = $staff['staff_gst'];
			  $details['work_guarantee_text']  = $work_guarantee_text;
			  $details['work_guarantee']  = $work_guarantee;
			 
			  if($staff['company_name']!=""){ 
			  	$details['staff_name'] = $staff['company_name']."<br>".$staff['name'];
			  }else{
			  	$details['staff_name'] = $staff['name'];
			  }
			  
			  if($real_estate == 'real_estate') {
				 $details['agent_name'] =   'Agent Name : '. ucfirst(get_rs_value("real_estate_agent","name",$details['real_estate_id']));
			  }else{
				  $details['agent_name'] = '';
			  }
			  
			  $details['staff_abn'] = "ABN:".$staff['abn'];
			 
			// echo '<pre>';  print_r($details);  die;
			 
			 
			 
			  $invoice_status = get_rs_value("jobs","invoice_status",$job_id);
			  
			  if($invoice_status=="1"){ $details['invoice_status'] = "<strong>Paid</strong>"; }else{ $details['invoice_status'] = "<strong>Pending</strong>"; }
			  

			   $invoice_details='';  
				$total_amt = 0;	
			
			   //$other_types = mysql_query("Select * from job_details where job_id=".$job_id." and status != 2 and job_type_id in (select id from job_type where inv=1)");
			 
     //echo "Select * from job_details where job_id=".$job_id." and status != 2 AND job_type_id='".$staff_id."'"; die;
 
    // echo "Select * from job_details where job_id=".$job_id." and status != 2 AND job_type_id='".$staff_id."'";
 
			   $other_types = mysql_query("Select * from job_details where job_id=".$job_id." and status != 2 AND staff_id='".$staff_id."'  AND  job_type_id in (select id from job_type where inv=1)");
			   
			   
			   $countRecords = mysql_num_rows($other_types);
			   
			    while($r = mysql_fetch_assoc($other_types)){
					
					//print_r($r); 
				  	
					 $quote_details = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".$r['quote_id']." and job_type_id=".$r['job_type_id'].""));
					
					//print_r($quote_details); die;
					
				    if($quote_details['job_type_id'] == 11) {	
						
						$qu_id = base64_encode($quote['id']);
						$url = $siteUrl1."/members/".$qu_id."/inventory"; 
						
						if($countRecords > 1) {
						   $jobdate = '<strong> Job date </strong>  ('.changeDateFormate($r['job_date'] , 'datetime').')<br>';
						}else{
							 $jobdate = '';
						}

						$truckList = mysql_fetch_array(mysql_query("select * from truck_list where id =".$quote_details['truck_type_id']));
						
						$bcic_amount = $truckList['amount'];
						$truck_type_name = $truckList['truck_name'];
						$cubic_meter = $truckList['cubic_meter'];
					
					    
						$c_str.= '<strong>Moving From :</strong> '.$quote['moving_from'].' , <strong><br>Moving To :</strong> '.$quote['moving_to'].'  <br>';
						
						//$jobdate Quote for '.$quote_details['hours'].' Hours x $'.$bcic_amount.' / hour for '.$truck_type_name.' '.$cubic_meter.' cm3 <br>';
					
						 $invoice_details.='<tr class="text12"><td valign="top" bgcolor="#ddd" style="color:  #333;padding: 10px 5px;background: #f1f1f1;"><strong>'.$r['job_type'].'</strong>: '.$quote_details['description'].'<br/>'.$c_str.'</td>';
						 
						 $invoice_details.='<td align="center" valign="top" bgcolor="#ebebeb" style="background: #03b9d5;color: #fff;;padding: 10px 5px;">$ '.number_format($r['amount_total'] , 2).'</td></tr>';
						 
						 
							$getemailNotes1 =   mysql_fetch_assoc( mysql_query("SELECT * FROM `quote_email_notes` WHERE emal_type = 'invoice_notes' AND quote_for_type_id = 3"));

							$br_in_bcic = 1;
							$details['site_url'] =   $sites['br_domain'];					 
							$details['br_term_condition_link'] =   $sites['br_term_condition_link'];
							$details['br_inclusion_link'] =   $sites['br_inclusion_link'];

							$qu_id = base64_encode($quote_id);
							$details['url'] = $siteUrl1."/members/".$qu_id."/inventory";  
						 
						 
					}else{
						
						$invoice_details.='<tr class="text12"><td valign="top" bgcolor="#ddd" style="color:  #333;padding: 10px 5px;background: #f1f1f1;"><strong>'.$r['job_type'].'</strong>: '.$quote_details['description'].'</td>';
						 
						$invoice_details.='<td align="center" valign="top" bgcolor="#ebebeb" style="background: #03b9d5;color: #fff;;padding: 10px 5px;">$ '.number_format($r['amount_total'] , 2).'</td></tr>';
						 
						$getemailNotes =   mysql_fetch_assoc( mysql_query("SELECT * FROM `quote_email_notes` WHERE emal_type = 'invoice_notes' AND quote_for_type_id = ".$details['quote_for'].""));
						$br_in_bcic = 0;
					}	
					
					 $total_amt = ($total_amt+$r['amount_total']);			 
			    }
				
			     $details['amount'] = $total_amt;
				 
				// echo $invoice_details; die;
				// print_r($details); die;
			   
				if($sendmail=="true"){ 
					$file = "invoice_old.php";
				}else{
					$file = "invoice.php";
				}
				
				ob_start(); // start buffer
				
				//echo $file;

				include ($_SERVER['DOCUMENT_ROOT']."/email_template/".$file);
				$content = ob_get_contents(); // assign buffer contents to variable
				ob_end_clean(); // end buffer and remove buffer contents			
				
				//echo $sendmail;  die;
				/*  echo $content;
				 die;*/
				   
				 if($bbcapp_staff_id > 0) {
				    $fromstaff = $staff['email'];
				    $staffphone = $staff['mobile'];
				}  else {
				    
				    $fromstaff = '';
				    $staffphone = '';
				}  
				   
				   
				if($sendmail=="true"){
                     if($br_in_bcic == 1) {
                        $subject_name = 'Removal';				
					 }else {
					   $subject_name = $getQuotetype['subject_name'];					 
					 }
					$subject = $subject_name .'  Invoice from '.$details['site_url'];
					
					//echo  $subject; die; 
					
					if($type == 'members'){
					 // sendmailwithattachinvoce($details['name'],$details['email'],$subject,$content,$getQuotetype['booking_email'],$details['site_id'],$quote_id , $details['quote_for'] , $real_estate, $jobinv);
					  sendmailwithattachinvoce($details['name'],$details['email'],$subject,$content,'team@bcic.com.au',$details['site_id'],$quote_id , $details['quote_for'] , $real_estate, $jobinv, $fromstaff,$staffphone);
					}else{
					   // sendmail($details['name'],$details['email'],$subject,$content,$getQuotetype['booking_email'],$details['site_id'],$details['quote_for']);
					    sendmail($details['name'],$details['email'],$subject,$content,'team@bcic.com.au',$details['site_id'],$details['quote_for'] , $fromstaff,$staffphone);
					}
					
					add_job_emails($job_id,$subject,$content,$details['email']);
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

function journal_email($staff_id, $emailtype = 0){
    
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
	
	function inventory_email($quote_id) {
		
			$quote = mysql_fetch_array(mysql_query("select * from quote_new where id=".mysql_real_escape_string($quote_id).""));
		    //print_r($quote);			
			$jobDetails = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".mysql_real_escape_string($quote_id)." AND job_type_id = 11"));
				
			$quote_for_option = mysql_fetch_array(mysql_query("select * from quote_for_option where id=".$quote['quote_for'].""));	
				
				$siteUrl1  = Site_url;
                $qu_id = base64_encode($quote['id']);
				$url = $siteUrl1."/members/".$qu_id."/inventory"; 
				$url1 = '<a href='.$url.' target="_blank" style="color:red;"> Click </a>';
				$url2 = '<a href='.$url.' target="_blank"> Please Click here to view your inventory </a>';
					
				 $string = '<span style="font-size:15px;">'.$url1. ' SUBMIT INVENTORY</span>';	
				 
				    $eol = "<br/>";
					$str = '';
					$str .= 'Hello '.ucfirst($quote['name']).$eol;
					$br_domain = get_rs_value("sites","br_domain",$quote['site_id']);
					
					$str .=	'Thank you for requesting Removal Quote from '.$br_domain.' '.$eol.'

						To provide you with the best possible Quote, we would like to request if you can submit your Inventory from the Links below'.$eol.$eol.' 

						<span style="font-size: 16px;font-weight:  600;padding: 4px;">Please Note:</span>'.$eol;
						
					$str .=	'1. We have auto selected the generic items in each room. '.$eol.'
						2. In the inventory link you can add or remove items '.$eol.'
						3. Items that you may not find in our inventory you can add them in others Box on the bottom of the page.'.$eol.' 
						4. Once Completed, please make sure to '.$string.' one the page 
						'.$eol.$eol;
						
						 $str .='<b><span style="color:blue;">'.$url2.'</b>'.$eol.'
						   Below you can find details you have provided.';

              $str .= '<table border="1">
			    <tr>
				  <td style="padding: 4px;font-weight: 600;">Property Details</td>
				  <td style="padding: 4px;">'.$jobDetails['description'].'</td>
				</tr>
				 <tr>
				  <td style="padding: 4px;font-weight: 600;">Moving from</td>
				  <td style="padding: 4px;">'.$quote['moving_from'].'</td>
				</tr>
				 <tr>
				  <td style="padding: 4px;font-weight: 600;">To Address</td>
				  <td style="padding: 4px;">'.$quote['moving_to'].'</td>
				</tr>
				 <tr>
				  <td style="padding: 4px;font-weight: 600;">Date of Travel </td>
				  <td style="padding: 4px;">'.changeDateFormate($quote['booking_date'], 'datetime').'</td>
				</tr>
				 <tr>
				  <td style="padding: 4px; font-weight: 600;">Start Time</td>
				  <td style="padding: 4px;">'.ucfirst(getbrSystemvalueByID($jobDetails['travel_time'] , '5')).' </td>
				</tr>
			  
			  </table>';						   
						
						
		//echo $str;				
			 $subject = ucfirst($quote['name']).' (Q#'.$quote['id'].'), Please check your removal quote';
			 sendmail($quote['name'],$quote['email'],$subject,utf8_encode($str),$quote_for_option['booking_email'],$quote['site_id'],$quote['quote_for']);
			 add_quote_emails($quote['id'],$subject,$str,$quote['email']);
			 $bool = mysql_query("update quote_new set inv_email_date='".date('Y-m-d H:i:s')."' where id=".$quote_id);	
			 
			//sendmail($quote['name'],'pankaj.business2sell@gmail.com',$subject,$str,$quote_for_option['booking_email'],$quote['site_id'],$quote['quote_for']);
	}
	
   function send_sms_to_clnt_staff($job_id, $type , $staffid) {
		
		
		   //echo $job_id. ' == '.$type . '===='.$staffid;
		        $clientname = mysql_fetch_array(mysql_query("SELECT name, id, booking_date, booking_id FROM `quote_new` where booking_id=".$job_id.""));	
				$jobs = mysql_fetch_assoc(mysql_query("select id, start_time,get_entry , cleaner_park  from jobs where id=".$job_id.""));
		
		     $str = '';
		      if($type == 1) {
				 // echo "select  GROUP_CONCAT(name) as sname  from staff where id in (".implode(',' , $staffid).")";
				  $staffdetails = mysql_fetch_assoc(mysql_query("select  GROUP_CONCAT(name) as sname  from staff where id in (".implode(',' , $staffid).")"));
				  
				  $str = " Hello ".$clientname['name'].", We are all set for your Job tomorrow – our cleaner ( ".$staffdetails['sname']." ) will be at your property between ( ".$jobs['start_time']." ) and he will follow your instructions for entering the property and for parking. For any further communication please call our office and request us to communicated with the cleaner. ";
				  
			  }elseif($type == 2 && $staffid > 0) {
				     
					  $staffname =  get_rs_value('staff' ,  'name',  $staffid);
				   
				   $str = " Hello ".$staffname." J#".$job_id." is set for tomorrow – Client have requested start time of (".$jobs['start_time']." ), please make sure you reach property on time. You will be able to access property from (".$jobs['get_entry'].") . and You can find parking at (".$jobs['cleaner_park'].") . Please do not interact with client and contact office for any further communication.  ";
			  }
			  
			 return $str; 
		
	}
	

// 	function sop_manual_email_attchment_info($appid) {
// 	     $appdetails = mysql_fetch_assoc(mysql_query("select * from staff_applications where 1 = 1 AND  id=".mysql_real_escape_string($appid).""));
//         $folderpath = $_SERVER['DOCUMENT_ROOT'] . '/application/manual/';
//         $sendto_email = 'pankaj.business2sell@gmail.com';
//         $subject = 'A#'.$appid. ' Please Check  SOP Manual Document  ';
//         add_application_notes($appid,$subject,$subject ,'','','', 0);        
//         sendmailwithattach_application($name, $sendto_email, $subject, $str, 'hr@bcic.com.au', $folderpath);
// 	}

	
	function sop_manual_email_attchment($appid, $name) {
	    
	    $eol = '<br/>';
        $str = 'Hello '.$name.$eol.'
        Hope this email finds you well.'.$eol.'
        Please note that we acknowledge the receipt of your documents.'.$eol.'
        As discussed, please find the SOP, checklist and the training video in this email.'.$eol.'
        <a href="https://youtu.be/IqI3dj5q-6w">https://youtu.be/IqI3dj5q-6w</a>.'.$eol.'
        The receipt of the signed SOP completes your documentation with us and we shall forward you the welcome email and onboard you with the jobs with us.'.$eol.'
        Thanks .'.$eol.'
        Rima(HR).'.$eol.'
        Team BCIC
        ';
	    
	    //echo $str;
	     $appdetails = mysql_fetch_assoc(mysql_query("select * from staff_applications where 1 = 1 AND  id=".mysql_real_escape_string($appid).""));
	    
        $folderpath = $_SERVER['DOCUMENT_ROOT'] . '/application/manual/';
        
        //$foldername = $folder . $getbcicinvoice['staff_id'];
	    
        /*$filename = $getbcicinvoice['date_name'] . '_' . $getbcicinvoice['year'] . '_bbc_report';
         $name = $filename . '.pdf';*/
        // $sendto_email = $appdetails['email']; sendmailwithattach_staff_invoce1
        $sendto_email = 'pankaj.business2sell@gmail.com';
        $subject = 'A#'.$appid. ' Please Check  SOP Manual Document  ';
        add_application_notes($appid,$subject,$subject ,'','','', 0);        
        sendmailwithattach_application($name, $sendto_email, $subject, $str, 'hr@bcic.com.au', $folderpath);
        
	}
?>
