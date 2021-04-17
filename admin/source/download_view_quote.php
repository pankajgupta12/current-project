<?php

if(isset($_POST)) {
    
	if(isset($_POST['export_data'])) {
		 
			 ob_clean();
			  
			  
			  if(!isset($_POST['from_date'])){ $from_date = date("Y-m-1"); }else{ $from_date = $_POST['from_date']; }
			  if(!isset($_POST['to_date'])){ $to_date = date("Y-m-t"); }else{ $to_date = $_POST['to_date']; }

              $booking_quote_id = $_POST['quote_type_1'];
			  
				$from_date1 = date('dS_M_Y',strtotime($from_date));		
				$to_date1 = date('dS_M_Y',strtotime($to_date));		

				$filename = 'view_quote_'.$from_date1.'_'.$to_date1.'.csv';

				$file = fopen($filename,"w");
				
				
				
				$arg = "select * from quote_new where 1=1";
				
				/* if($from_date != '' && $to_date != '') {
					$arg.= " AND date >= '".$from_date."' and date <= '".$to_date."'";
				} */
				
				/* if($booking_quote_id > 0) {
					   $arg.= " AND booking_id != '0'";
				} */
				
				if($from_date != '' && $to_date) {
			
					if($booking_quote_id == 1) {
						
						  $arg.= " AND date >= '".$from_date."' and date <= '".$to_date."'";
						  
					}elseif($booking_quote_id == 2) {
						   
						   $arg.= " AND  booking_date >= '".$from_date."' and booking_date <= '".$to_date."'";
						   
					}elseif($booking_quote_id == 3) {
						   
						   $arg.= " AND  quote_to_job_date  >= '".$from_date."' and quote_to_job_date  <= '".$to_date."'";
					}	
			    }
				
				
				$arg.=" order by id desc";
				
				$sql = mysql_query($arg);
				
				
				$heading = array('Id','Job Id',	'Q For'	, 'Site',	'Ref',	'Quote Date','Name',	'Email',	'Phone',	'Suburb','Address','Job Type',	'J Date',	'SMS Quote',	'Email Date', 'Amt','1st Call',	'2nd Call','3rd Call','Status','Response',	'Pending', 'OTO',	'Have Removal',	'Admin');
				
				 fputcsv($file,$heading);
				 
				 
				
				
					$status = dd_value(31);
					$response = dd_value(33);
					$pending = dd_value(34);
					$haverevale = dd_value(90);
				
				while($data = mysql_fetch_assoc($sql)) {
					
					$quote_for =  get_rs_value("quote_for_option","name",$data['quote_for']);
					$site_id =  get_rs_value("sites","name",$data['site_id']);
					
					if($data['booking_id'] == '0') {
					  $sql_icone = ("select GROUP_CONCAT(job_type) as jobtype from quote_details where  status != 2 AND quote_id=".$data['id']);
					}else{
					   $sql_icone = ("select GROUP_CONCAT(job_type) as jobtype from job_details where  status != 2 AND quote_id=".$data['id']);  
					}
					$quote_details = mysql_query($sql_icone);
					
					$jobtypedata  = mysql_fetch_assoc($quote_details);
					
					/* $status = getSystemvalueByID($data['step'],31);
					$response = getSystemvalueByID($data['step'],33);
					$pending = getSystemvalueByID($data['step'],34);
					$haverevale = getSystemvalueByID($data['step'],90); */
					
					$adminname = get_rs_value("admin","name",$data['login_id']);
					
					
					if($data['oto_time'] != '0000-00-00 00:00:00') {
							 if($data['oto_flag'] == 1) {
								 if($data['booking_id'] == 0) {
									 $oto = 'Yes';
								 }else{
									  $oto = 'Not Booked';
								 }
							 }else{
								  $oto = 'Exp';
							 }
					}else{
						$oto =  "N/A"; 
					}
					
				/* if($data['booking_id'] != 0) {
					$qtype = 'booked';
				}	else {
					$qtype = 'quote';
				} */
					
					$dataval = array($data['id'] , $data['booking_id'],  $quote_for , $site_id, $data['job_ref'] , $data['createdOn'] ,$data['name'] , $data['email'], $data['phone'] , $data['suburb'],$data['address'], $jobtypedata['jobtype'] , $data['booking_date'],$data['sms_quote_date'] , $data['emailed_client'] ,$data['amount'],$data['called_date'] , $data['second_called_date'], $data['seven_called_date'],$status[$data['step']] , $response[$data['response']] ,$pending[$data['pending']] , $oto,$haverevale[$data['have_removal']] , $adminname);
					
					 fputcsv($file,$dataval);
					
				}
				
				 fclose($file);
				 
				header("Content-Description: File Transfer");
				header("Content-Disposition: attachment; filename=".$filename);
				header("Content-Type: application/csv; ");  
				ob_clean();

				readfile($filename);
				ob_flush();
				unlink($filename);
				exit();
	}
	 
}
?>