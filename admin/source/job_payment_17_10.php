<?php
require_once 'include_eway.php'; 


	  
	  // For Live Used 
        $merchantEncryptionKey = "ydfsRcMZ85mZ9HaeSrtSDQ9ujcCSMHlV37KivDl9roPtuGT4en0SRlJ+RHarKBVabbtUMbd6UuhvEcUolU6L46m38xkfoNQJhyXAxE8rmTX0a7d1Bb0w5ltld35HZ2ZPynoc8thtEEp0S87u10WUMNKTthLbRNZOmUsUjPTGJ+6Ytcr65jpkRJZMsGgy6FyairbmH79gD9Jlb0RTnuNT3JXgqm0FFQGmAeJA53LbYz7PJgbfnyhaur8hv3m/ihMRn/5B+BiwHz3ETt0WkK3fmFqMQoORZyV5amk/d1WkJLH/IChdzKio6BtxJKK932eg1ZwyW4KCEG3IC4RSJ9Ps8w==";	
        $apiKey = 'F9802AxK0ruzK2uUtcnSa7s7wJGrjG2WcOVXw0Pox5ATuMfqf+7lZrKlR01TCHROHYBAc1';
        $apiPassword = 'WKllXwKL'; 

	$apiEndpoint = \Eway\Rapid\Client::MODE_PRODUCTION;
	$client = \Eway\Rapid::createClient($apiKey, $apiPassword, $apiEndpoint);
	
	//echo "<pre>"; print_r($_POST); die;
 //require_once('ewaypaymentlive.php');
  //echo "<pre>"; print_r($_REQUEST);
	if($_GET['job_id']!=""){ 
		
	    if (($_POST['step']==1)){
				
				
				
			//	print_r($_POST); die;
				
				
                $checkeway_token = get_rs_value("jobs","eway_token",$_GET['job_id']);
				$TransactionID = 0;
			  //echo $checkeway_token; die;
			if($checkeway_token == '') {  
			  
				$table="payment_gateway";
				$fields_name=array("cc_name","cc_number","cc_type","cc_month","cc_year");
				$fields_heading=array("Credit Card Holder Name","Credit Card Number","Credit Card Type","Credit Card Expiry Month","Credit Card Expiry Year");
				$fields_validation=array(1,1,'',1,1);
					
					//echo "step1"; die;
			
				if ($_POST['step']==1){ 
				
						$step=check_form($fields_name,$fields_validation,$fields_heading);
						//echo "after check form".$step."<br>";
						if ($step==2){ 
							$mktime = mktime(0,0,0,$_POST['cc_month'],$_POST['cc_year']);
							$tsnow = time();
							if ($mktime<$tsnow){
								$_SESSION['query[txt]']= "Please Check Credit Card Expiry Dates";
								$_SESSION['query[error]'] = 1;
								$step=1;							
							}
							
							if(empty($_POST['amount']) || $_POST['amount'] == 0){
								$_SESSION['query[txt]']= "Payment Amount should not be empty";
								$_SESSION['query[error]'] = 1;
								$step=1;	
							}
							//echo "step2"; die;
						}
						
						if($step==2){ 
		                         // echo "step3"; die;
							$amt = mysql_real_escape_string($_POST['amount']);
							
							$arg_ins = "insert into payment_gateway(job_id,date,amount,ip,cc_type,cc_name,cc_exp,cc_csv)";
							$arg_ins .=" values(".$_POST['job_id'].",'".date("Y-m-d")."','".$amt."','".$_SERVER['REMOTE_ADDR']."','".mysql_real_escape_string($_POST['cc_type'])."','".mysql_real_escape_string($_POST['cc_name'])."','".$_POST['cc_month']."-".$_POST['cc_year']."','".mysql_real_escape_string($_POST['cc_csv'])."')";
							
							$ins = mysql_query($arg_ins);
							$payment_gateway_id = mysql_insert_id();
							//echo $payment_gateway_id; die;
							$data = mysql_query("select * from quote_new where booking_id=".mres($_REQUEST['job_id'])."");
							if (mysql_num_rows($data)>0){ 
							$users = mysql_fetch_assoc($data);
							
						 /*   echo  "<pre>"; print_r($users); 
						 echo "============"; 
						 print_r($_POST);     */
							  // echo "step4"; die;
							
								
									
								$customer = [
										'Title' => 'Mr.',
										'FirstName' => mysql_real_escape_string(trim($_POST['cc_name'])),
										'LastName' => mysql_real_escape_string(trim($_POST['job_id'])),
										'Email' => trim($users['email']),
										'Phone' => trim($users['phone']),
										'Country' => 'au',
											'CardDetails' => [
											'Name' => mysql_real_escape_string(trim($_POST['cc_name'])),
											'Number' => mysql_real_escape_string(trim($_POST['cc_number'])),
											'ExpiryMonth' => mysql_real_escape_string(trim($_POST['cc_month'])),
											'ExpiryYear' => mysql_real_escape_string(trim($_POST['cc_year'])),
											'CVN' => mysql_real_escape_string(trim($_POST['cc_csv'])),
											]
										];
							 /*  echo  "<pre>"; 
							 echo "============"; 
							 print_r($customer); die;  */
						 
								$response = $client->createCustomer(\Eway\Rapid\Enum\ApiMethod::DIRECT, $customer); 

								//$response = $client->createCustomer(\Eway\Rapid\Enum\ApiMethod::DIRECT, $customer); 
								 
							 //	echo "<pre>";  print_r($response); die;
								 
								 
									if( !empty($response->Errors) )
									{  
										 $step=1; 
										 $errorData = array();
											foreach ($response->getErrors() as $error) {
											    $errorData[] =   \Eway\Rapid::getMessage($error);
												$_SESSION['query[txt]'] = \Eway\Rapid::getMessage($error);
											}
										$errorMsgData = implode(',',$errorData);
										
										
										$_SESSION['query[error]'] = 1;
										$bool = mysql_query("update payment_gateway set result_text='". $errorMsgData."' , status=0 where id=".$payment_gateway_id);
										/* echo "<pre>";
										print_r( $response->Errors );	 */
									}else{
									   
									    //payment_agree_check
									    //$checkagree = $_POST['payment_agree_check'];
									     //$checkagree = ($_POST['payment_agree_check'] == 1 ? '1' : '0');
									     $checkagree = $_POST['payment_agree_check'];
										 $custToken = trim($response->Customer->TokenCustomerID);
										 $cc_num = trim($response->Customer->CardDetails->Number);
										  
									     $updateTokenCustomerID = mysql_query("update jobs set eway_token='".$custToken."',payment_agree_check='".$checkagree."' where id='".$_POST['job_id']."'");  
											//but check once payment should be greater than 0
											  
											 if($checkagree != 0) { 
											   $comment =  'You have' . getSystemvalueByID($checkagree,107);
											 }else{
												 $comment =  'Client not want';
											 }
											  add_job_notes($_POST['job_id'], $comment, $comment);
												
											    /* if( $checkagree = 1 ) { 
                                                    $heading = 'Charge agreed by '.trim($users['name']);
													
                                                   // $comment = 'You have agreed to charge your card on file on the day of job for remaining amount';
                                                    $comment = 'You have agreed to charge this credit card a day before of job';
													
                                                    add_job_notes($_POST['job_id'], $heading, $comment);
											    }else { 
											         $heading = 'Charge denied by '.trim($users['name']);
											         $comment = 'You have (not) agreed to charge this credit card a day before of job';
											        add_job_notes($_POST['job_id'], $heading, $comment);
											    } */
											    
										if( $amt > 0 )
										{ 
											$client = \Eway\Rapid::createClient($apiKey, $apiPassword, $apiEndpoint);

											$transaction = [
												'Customer' => [
												'TokenCustomerID' => $custToken,
												],
												'Payment' => [
													'TotalAmount' => $amt*100,
													'InvoiceDescription' => $payment_gateway_id,
													'InvoiceReference' => " Job Id ".$_POST['job_id'],
												],
												'TransactionType' => \Eway\Rapid\Enum\TransactionType::RECURRING,
											];

											$response = $client->createTransaction(\Eway\Rapid\Enum\ApiMethod::DIRECT, $transaction);
                                         	/////
											//echo "<pre>"; print_r($response); die;
											
											if(($response->ResponseCode=="00") || ($response->ResponseCode=="08")){ 
											    
											   $TransactionID = $response->TransactionID;
											
												$bool = mysql_query("update payment_gateway set status=1, cc_num = '".$cc_num."' , token_id = '".$custToken."' where id=".$payment_gateway_id);
											 //Insert data response  for  Payment Success in eway_responses	
												$responseCode = $response->ResponseCode;
												$responseMsg =  \Eway\Rapid::getMessage($response->ResponseMessage);
												$responseresult = serialize(base64_encode($response));
			                                    $queryresult = "insert into eway_responses(job_id,response_code,response_code_message,status)";
									            $queryresult .=" values(".$_POST['job_id'].",'".$responseCode."','".$responseMsg."','Success')";
										        mysql_query($queryresult);
										        
									      		$step=2;
											  }else{ 
												$bool = mysql_query("update payment_gateway set status=0 , cc_num = '".$cc_num."', token_id = '".$custToken."' where id=".$payment_gateway_id);
												
											   //Insert data response  for  Payment failed in eway_responses	
												$responseCode = $response->ResponseCode;
												$responseMsg =  \Eway\Rapid::getMessage($response->ResponseMessage);
											
												if($responseMsg=='Function Not Permitted to Terminal'){
													
													$responseMsg="Function Not Permitted to Terminal. The customer's card issuer has declined the transaction as this credit card cannot be used for this type of transaction. This may be associated with a test credit card number. The customer should use an alternate credit card, or contact their bank.";
													$responseMsg= str_replace("'", "''", "$responseMsg");
												}
												else{
													$responseMsg = $responseMsg;
												}
												$responseresult = serialize(base64_encode($response));
			                                    $queryresult = "insert into eway_responses(job_id,response_code,response_code_message,status)";
									            $queryresult .=" values(".$_POST['job_id'].",'".$responseCode."','".$responseMsg."','failed')";
										        mysql_query($queryresult);
												
												$step = 1;
												echo error("Payment failed");
											}    

										}else{
											$_SESSION['query[txt]']= "Amount cannot be empty";
											$_SESSION['query[error]'] = 1;
											$step=1;
											
										}
																				
									} 
							    
							}else{
								//echo "4"; die;
								// cannot find your record in users 	
							}
						}else{
							//echo "5"; die;
							//; some error found dont go to payment gateway yet	
						}
				}
			}else{
				
				        $amt = mysql_real_escape_string($_POST['amount']);
					    $step=1;					
							
						$arg_ins = "insert into payment_gateway(job_id,date,amount,ip,cc_type,cc_name,cc_exp,cc_csv)";
						$arg_ins .=" values(".$_POST['job_id'].",'".date("Y-m-d")."','".$amt."','".$_SERVER['REMOTE_ADDR']."','Token Charge')";
						
						$ins = mysql_query($arg_ins);
						$payment_gateway_id = mysql_insert_id(); 
	
						   if($_POST['amount']>0){

								$client = \Eway\Rapid::createClient($apiKey, $apiPassword, $apiEndpoint);

								$transaction = [
									'Customer' => [
									'TokenCustomerID' => $checkeway_token,
									],
									'Payment' => [
										'TotalAmount' => $amt*100,
									//	'InvoiceDescription' => $payment_gateway_id,
										'InvoiceReference' => " Job Id ".$_POST['job_id'],
									],
									'TransactionType' => \Eway\Rapid\Enum\TransactionType::RECURRING,
								];

								$response1 = $client->createTransaction(\Eway\Rapid\Enum\ApiMethod::DIRECT, $transaction);
						   		//echo "<pre>"; print_r($response1); die; 
							    // $bool = mysql_query("update payment_gateway set status=1 where id=".$payment_gateway_id);
								//$step=2;
							    if(($response1->ResponseCode=="00") || ($response1->ResponseCode=="08")){	
								    
									  $TransactionID = $response1->TransactionID;
								
										$bool = mysql_query("update payment_gateway set status=1 where id=".$payment_gateway_id);

										//Insert data response  for  Payment Success in eway_responses	
										$responseCode = $response1->ResponseCode;
										$responseMsg =  \Eway\Rapid::getMessage($response1->ResponseMessage);
										$responseresult = serialize(base64_encode($response1));
										$queryresult = "insert into eway_responses(job_id,response_code,response_code_message,status)";
										$queryresult .=" values(".$_POST['job_id'].",'".$responseCode."','".$responseMsg."','Success')";
										mysql_query($queryresult);

										$step=2;
							    }
								else
								{  

											$step=1; 
											$errorData = array();
											foreach ($response1->getErrors() as $error) {
											$errorData[] =   \Eway\Rapid::getMessage($error);
											$_SESSION['query[txt]'] = \Eway\Rapid::getMessage($error);
											}
											$errorMsgData = implode(',',$errorData);
																					
											$bool = mysql_query("update payment_gateway set result_text='". $errorMsgData."' , status=0 where id=".$payment_gateway_id);
											//Insert data and response for  Payment failed in eway_responses
											$responseCode = $response1->ResponseCode;
											$responseMsg =  \Eway\Rapid::getMessage($response1->ResponseMessage);
											$responseresult = serialize(base64_encode($response1));
											$queryresult = "insert into eway_responses(job_id,response_code,response_code_message,status)";
											$queryresult .=" values(".$_POST['job_id'].",'".$responseCode."','".$responseMsg."','failed')";
											mysql_query($queryresult);	


											$_SESSION['query[error]'] = 1;
											echo error("Payment failed");

											if($_SESSION['query[txt]']==""){ $_SESSION['query[txt]']="Payment Failed"; }
									
						        }  
							}else{
								$_SESSION['query[txt]']= "Amount cannot be empty";
								$_SESSION['query[error]'] = 1;
								$step=1;
							}		
			}
			
			if ($step==2)
			{
					// echo "step4"; die;					
			
				$quote_id = get_rs_value("jobs","quote_id",$_REQUEST['job_id']);

				
				//$bool = mysql_query("update jobs set invoice_status=1, customer_paid_amount='".$amt."', customer_paid=1, customer_paid_date='".date("Y-m-d")."',customer_payment_method='Credit Card' where id='".mres($_REQUEST['job_id'])."'");					
				
				
				
				$uarg = "update jobs set customer_paid_amount='".$amt."', customer_paid=1, customer_paid_date='".date("Y-m-d")."', invoice_status='".$invoice_status."',customer_payment_method='".$pmethod."' where id='".mres($_REQUEST['job_id'])."'";  //die;
				$bool = mysql_query($uarg);
				
				 
				 $job_type_id = get_sql("job_details","job_type_id"," where job_type_id='11' AND job_id='".$_REQUEST['job_id']."' AND status != 2");
				 
				$countsqlpayment =   mysql_query("select * from job_payments where job_id=".$_REQUEST['job_id'].""); 
				 
				$bool = mysql_query("insert into job_payments set job_id=".$_REQUEST['job_id'].", transaction_type= 'Credit', transaction_id='".$TransactionID."', payment_method='Credit Card', date='".date("Y-m-d")."',amount='".$amt."', taken_by='BCIC'");
				
				add_job_notes($_REQUEST['job_id'],"Payment of ".$amt." take by Credit Card ",'');
				
				  
                    if($job_type_id != 11) {
						
						//$totalamount = totalAmountofJob($_REQUEST['job_id']);
						//if(totalAmountofJob($_REQUEST['job_id']) > 0) { }else {
							if(mysql_num_rows($countsqlpayment) == 0) {	
								add_job_notes($_REQUEST['job_id'],"Sent Booking Confirmation Email","");
								send_email_conf($_REQUEST['job_id']);
								
								$bool = mysql_query("update jobs set email_client_booking_conf='".date("Y-m-d h:i:s")."' where id=".$_REQUEST['job_id']."");
							}
						//}   
				    }
				
				echo error("Invoice has been charged and paid successfully");
				die();
			}			
		}
		
			
		$jobTypeId = mysql_fetch_assoc(mysql_query("SELECT job_type_id from job_details where job_id=".$_REQUEST['job_id'].""));
	//$job_details = mysql_fetch_array(mysql_query("select * from job_details where job_id='".mres($_REQUEST['job_id'])."' and job_type='Cleaning'"));		
?>


<script src="https://secure.ewaypayments.com/scripts/eCrypt.min.js"></script>


<script type="text/javascript">
$(function() {
			  $("#p_date").datepicker({dateFormat:'yy-mm-dd'});
        });
</script>
<script language="javascript">
function clicked_submit(){

	var err=false;
	var msg = "Please fill the following fields \n\n";
	
	if (document.getElementById("cc_name").value==""){ err=true; msg = msg + "Credit Card Name \n"; }
	if (document.getElementById("cc_number").value==""){ err=true;  msg = msg +"Credit Card Number \n"; }
	if (document.getElementById("cc_type").value==""){ err=true;  msg = msg +"Credit Card Type \n"; }
	if (document.getElementById("cc_month").value==""){ err=true; msg = msg +"Credit Card Expire Month \n"; }
	if (document.getElementById("cc_year").value==""){ err=true;  msg = msg +"Credit Card Expire Year \n"; }

	if (err){ 
		alert(msg);
	}else{ 
		document.getElementById('submit_button').value ="Please wait ... processing";
		document.getElementById('submit_button').disable = true;
		document.form1.submit();
	}
}
</script>
<style>

	.ac-pay span input {
    background-color: #fff;
    padding: 15px 10px;
    border: solid 1px #cacaca;
    margin-bottom: 15px;
}
.send-sms-pay a {
    background-color: #188596;
    color: #fff;
    padding: 12px 15px;
    border-radius: 4px;
}
.right-tc-pay {
    float: right;
}

</style>

<div id="tab-3">
    <div class="sec3_tabs_main"> 
	
	    <?php 
	        
		 $tc_payment = get_rs_value("siteprefs","tc_payment",1);	
		 $tc_flag = false;
         if($tc_payment == 1) {		 
			$quoteDetails = mysql_fetch_assoc(mysql_query("select phone, id from quote_new where booking_id=".mres($_REQUEST['job_id']).""));
			
				  $accept_terms_status =  get_rs_value("jobs","accept_terms_status",$_REQUEST['job_id']);	
		?>
				 <div class="ac-pay" style="width:48%; float:left;">
				 
				   <span><input name="phone"  <?php  if($accept_terms_status == 1) {  echo "disabled ";       echo 'style="background-color:#eae4e4;"'; }?>   type="text" id="phone" onkeypress="return isNumberKey(event)" autocomplete="off" maxlength="10" pattern="[0-9]{10}" required="" title="Please enter 10 digits" value="<?php echo $quoteDetails['phone']; ?>" size="45" onblur="javascript:edit_field(this,'quote_new.phone','<?php echo $quoteDetails['id']; ?>');"/></span>
					
					<div class="right-tc-pay">
					 
					  <?php  if($accept_terms_status == 0) {    ?>
					
							<span class="send-sms-pay">
							  <a href="javascript:custom_data('<?php echo $quoteDetails['id']; ?>',451,'quote_sms');" class="file_icon" id="quote_sms">
							  Send T&C</a>
							</span>
						
					  <?php  } ?>
						
						<span class="tc-status"> 
						  <?php 
						  
						
							  
							  if($accept_terms_status == 0) { echo '<img src="../admin/images/no_icon.png" style="height:35px; width:35px; margin: 10px 15px">';}else{echo '<img src="../admin/images/check_agree.png" style="height:35px; width:35px; margin: 10px 15px">'; 
							  
							   $tc_flag = true;
							  } 
						  ?>
						</span>
					</div>	
					
					
				 </div>
	 <?php  }        
	 
	 $rs_quote_questions = mysql_query("SELECT * FROM quote_question WHERE status=1 AND quote_type=3");
	 
	 if(mysql_num_rows($rs_quote_questions) > 0) { 
	    if(totalAmountofJob($_REQUEST['job_id']) == 0) { ?>			 
				 
				<div class="booking-quest" style="width:50%; display:inline-block">
					<span class="payment_required">Booking Quote Questions </span>
					<table border="1px" id="quote_questions_list2" class="quote_que quote_questions" style="width:100%">
					   <?php
					   $question_ids = explode(',', get_rs_value('jobs', 'question_id', $_REQUEST['job_id']));
					   
					   while($quote_questions = mysql_fetch_assoc($rs_quote_questions)) {
						   
						   if(!empty($question_ids)){
								if(in_array($quote_questions['id'], $question_ids)){
									$status_check = 'checked' ;
								}
								else{
									$status_check = '';
								}					
							}
							
						?>
							
							<tbody>
								<tr>
									<td> 
										<input class="check" data-page="0" name="booking_quest[]" type="checkbox" value="<?php echo $quote_questions['id']?>" <?php echo $status_check;?>>
									</td>
									<td><?php echo $quote_questions['question'];?></td>
								</tr>
							</tbody>
					   <?php } ?>
					</table>
					<span class="send-sms-pay">
						  <a href="javascript:save_quote_question('<?php echo $quoteDetails['id']; ?>|3',531,'booking_sms');" class="file_icon" id="booking_sms">Submit</a>
						  
					</span>
			   </div>
	 <?php }  } ?>   
	 
	 
	 <?php   if($tc_flag == true) { 
	 
	    $jobdetailsD = mysql_fetch_assoc(mysql_query("SELECT id , accept_terms_status , tc_ip_address , tc_address , tc_createdOn   FROM `jobs` WHERE  id = ".$_REQUEST['job_id']." AND `tc_ip_address` != '' AND `accept_terms_status` = '1'  AND tc_createdOn != '0000-00-00 00:00:00' ORDER BY `id` DESC"));
		
		 if(!empty($jobdetailsD)) {
	 ?>
	   <span class="payment_required">Term Accepted Details </span>
	            <div class="tab3_table1">
					<table class="start_table_tabe3">
							<thead>
							  <tr>
								<th>IP Address</th>
								<th>TC Address</th>
								<th>TC DateTime</th>
								<th>TC Status</th>
								<th>Download TC</th>
							  </tr>
							</thead>
							<tbody>
								<tr>
								  <td><?php echo $jobdetailsD['tc_ip_address']; ?></td>
								  <td style="width: 2px;"><?php echo $jobdetailsD['tc_address']; ?></td>
								  <td><?php echo $jobdetailsD['tc_createdOn']; ?></td>
								  <td><?php if($jobdetailsD['accept_terms_status'] == 1) {  echo 'Yes'; }else {echo 'No'; }?></td>
								   <td><a href="../../tc/tc_files/tc_<?php echo $jobdetailsD['id']; ?>.pdf" download>Download</a></td>
								</tr>
							</tbody>
					</table>   
	            </div>
		<?php  } } ?>
		
	 
	 
    <span class="payment_required">Payments </span>
	  <div>
		 <?php  
			$job_id = $_REQUEST['job_id'];
			 include("xjax/job_type_payment.php");  
		  ?>
	  </div>
	  
	  
    
    <span class="payment_required">Add Job Payments</span>
    <div class="tab3_table1">
         <?php  
			$job_id = $_REQUEST['job_id'];
			$details = $details;
			 include("xjax/add_job_payment.php");  
		  ?>
    </div>
		
    
    <span class="payment_required">Payments Received</span>
    <div id="job_payment_div" class="pay_not_recived"><?php 
    $job_id = $_REQUEST['job_id'];
      include("xjax/view_job_payments.php"); 
	?></div>
	
	 
	 
	 
	 
		<div id="job_payment_div">
		<?php 
		$jobid = $_REQUEST['job_id'];
		include("xjax/creadit_cart_details.php"); 
		$payment_agree_check = get_rs_value("jobs","payment_agree_check",$jobid);
		?></div>
		
		
	 <?php  
	  /*    $admin_show = array(1,3,4);
	    if(in_array($_SESSION['admin'] , $admin_show)) { */
	    ?>
			  <span class="payment_required">Payments Refund</span>
			  <div>
				 <?php  
					 $job_id = $_REQUEST['job_id'];
					 include("xjax/refund_amount.php");  
				  ?>
			  </div>
	    <?php  //} ?>	
	 
       <div class="table3_table1"> <span class="payment_required padding_none">Credit Card Payments</span>
    	 <? //echo $_SESSION['query[txt]'];

			if($_SESSION['query[error]'] == 1){ print error($_SESSION['query[txt]']); }Else If(!empty($_SESSION['query[txt]'])){ print notify($_SESSION['query[txt]']); } ?>
			
		<form   name="form1" action="" id="payment_form" method="POST" data-eway-encrypt-key="<?php echo $merchantEncryptionKey; ?>">
		 <?php   
		    $eway_token = get_rs_value("jobs","eway_token",$job_id);
            if($eway_token == '') {  ?>
			 <div class="tabs_3main"> <span class="credit_card">Pay by Credit Card</span> <span class="fill_payment">Please fill the payment details below. </span>			 
			<ul class="tab3_ul">				
				<li>
				  <label>Name on Credit Card </label>
				  <input name="cc_name" type="text" id="cc_name" value="<? if(rw("cc_name")!=""){ echo rw("cc_name"); }else{ echo get_sql("quote_new","name"," where booking_id=".mres($_REQUEST['job_id']).""); } ?>" />
				</li>
				
				<li>
				  <label>Card Number</label>
				  <input type="text" data-eway-encrypt-name="cc_number" />
				</li>
				
				 
				<li>
				  <label>Invoice Amount</label>
				  <input type="text" name="amount" id="amount"  >
				</li> 
				 
				 <li>
				  <label>Credit Card Type</label>
				     <!--<input type="text" name="cc_type" id="cc_type" placeholder="Credit card type" value="visa" >
					<span class="card_icon" style="margin-top: -30px;float: right;width: 30px;"></span>-->
				  <span class="left_drop_down">
					<span>
					 <select name="cc_type" id="cc_type">
						<option value="0" >Select</option>
						<option value="MasterCard" <? if($_POST['cc_type']=="MasterCard"){ echo " selected "; } ?>>MasterCard</option>
						<option value="Visa" <? if($_POST['cc_type']=="Visa"){ echo " selected "; } ?>>Visa</option>
						<option value="Amex" <? if($_POST['cc_type']=="Amex"){ echo " selected "; } ?>>Amex</option>
					  </select>
					  </span>
				  </span>
				 
				</li>
				
				<li>
				  <label>Expiry Date</label>
				  <span class="left_drop_down"><span>
					<select name="cc_month" id="cc_month">
						<option value="0" >Select</option>
						<option value="01" <? if($_POST['cc_month']=="01"){ echo " selected "; } ?>>01 (Jan)</option>
						<option value="02" <? if($_POST['cc_month']=="02"){ echo " selected "; } ?>>02 (Feb)</option>
						<option value="03" <? if($_POST['cc_month']=="03"){ echo " selected "; } ?>>03 (Mar)</option>
						<option value="04" <? if($_POST['cc_month']=="04"){ echo " selected "; } ?>>04 (Apr)</option>
						<option value="05" <? if($_POST['cc_month']=="05"){ echo " selected "; } ?>>05 (May)</option>
						<option value="06" <? if($_POST['cc_month']=="06"){ echo " selected "; } ?>>06 (Jun)</option>
						<option value="07" <? if($_POST['cc_month']=="07"){ echo " selected "; } ?>>07 (Jul)</option>
						<option value="08" <? if($_POST['cc_month']=="08"){ echo " selected "; } ?>>08 (Aug)</option>
						<option value="09" <? if($_POST['cc_month']=="09"){ echo " selected "; } ?>>09 (Sep)</option>
						<option value="10" <? if($_POST['cc_month']=="10"){ echo " selected "; } ?>>10 (Oct)</option>
						<option value="11" <? if($_POST['cc_month']=="11"){ echo " selected "; } ?>>11 (Nov)</option>
						<option value="12" <? if($_POST['cc_month']=="12"){ echo " selected "; } ?>>12 (Dec)</option>
					</select>
				  </span></span> <span class="right_drop_down"><span>
				  
					<select name="cc_year" id="cc_year">
					  <option value="0" >Select</option>
					  <? 
					  // $currentyear = date("Y");
						$maxy =date("Y")+10;
						for($i= date("Y");$i<=$maxy;$i++){ 
						echo "<option value=".$i." ";
						if($_POST['cc_year']==$i){ echo " selected "; }
						echo ">".$i."</option>" ;
						} 
						?>
					</select>
				  </span></span> 
				 </li>
				
				<li>
				  <label>CVN/CVV2</label>
				  <input name="cc_csv" type="text"   id="cc_csv" value="<? //if(rw("cc_csv")!=""){ echo rw("cc_csv"); } ?>" size="5" maxlength="4"  data-eway-encrypt-name="cc_csv"/>
				</li>
				 
				<li style="width: 100%;">
				  <label>Agree Check</label>
				  <span class="left_drop_down"><span>
				     <?php echo create_dd("payment_agree_check","system_dd","id","name","type = 107","",$details);?>
				     
            				    <!--<input name="payment_agree_check" type="checkbox"   id="check_arree" value="1"/>
            					<?php if($jobTypeId['job_type_id']==11){?>
            					Agreed to charge this credit card on completion of the move for remaining hours
            				  <?php } else { ?>
            				   Agreed to charge this credit card a day before of job for remaining amount
            				  <?php } ?>
            				  </label>-->
				 </li>
			</ul>
				<input type="submit" name="submit_button" id="submit_button" value="Make Payment" class="job_submit" onclick="javascript:clicked_submit();" />
			 	
				<?php  }else {
				   $jobid = $_REQUEST['job_id'];
				   $payment_agree_check = get_rs_value("jobs","payment_agree_check",$jobid);
				
				  //SELECT *  FROM `payment_gateway` WHERE `job_id` = 3021
				  //	$cart_name = get_sql("payment_gateway","cc_name","where job_id=".$jobid." AND status = 1");
				  //	$cc_type = get_sql("payment_gateway","cc_type","where job_id=".$jobid." AND status = 1");
				?>
				
					
					
				
				    <span class="fill_payment">Please fill the amount below. <br /> <a href="javascript:send_data('<?php echo $jobid; ?>','59','remove_token_div');" id="remove_token_div">Click here</a> to remove card on file and refresh to charge with new card. 
				    
					<?php 
					//echo $payment_agree_check . 'sdsds';
					if($payment_agree_check != 0) {
					   echo  '</br>'.getSystemvalueByID($payment_agree_check,107);
					}
					/*
					 if($payment_agree_check == '1') {

					?></br><b><img src="../admin/images/check_agree.png" style="height: 23px;padding: 2px;"/>
					<?php   /* if($jobTypeId['job_type_id']==11) { ?>
					  Agreed to charge this credit card upon completion of job</b>
					<?php  } else { ?>
				    	Agreed to charge this credit card a day before of job</b>
					<?php  } } */ ?>
					</span>
			   	<!--<span class="fill_payment"><b>Agreed to charge this credit card on the day of JOB</b></span>-->
				<ul class="tab3_ul">	
					<li>
					  <label>Invoice Amount</label>
					  <input type="text" name="amount" id="amount"  >
					</li>
				</ul>	
					<!--<input type="hidden" name="eway_token" value="<?php // echo $eway_token; ?>" />-->
					<input type="button" name="submit_button" id="amount_submit_button" value="Make Payment" class="job_submit" onclick="return checkamount();" />
					 
					<!--<span onclick="return checkamount();" id="submit_button" class="">Make Payment</span>-->
					
				<?php  }?>	
			
			
			<input type="hidden" name="step" value="1" />
			<input type="hidden" name="job_id" value="<? echo $_REQUEST['job_id'];?>" />  
			  
			
		  </div>	
        </form>
    </div>
  </div>
</div>
		<script>
			function checkamount() {
				    
						 var x, text;
						// Get the value of the input field with id="numb"
						x = document.getElementById("amount").value;
						// If x is Not a Number or less than one or greater than 10
						if (isNaN(x) || x < 1 || x == '' || x == null || x == undefined) {
							//text = "Input not valid";
						  alert('Please enter valid invoice amount');
						  document.getElementById("amount").value = '';
                            return false;						  
						} else {
							document.getElementById('amount_submit_button').value ="Please wait ... processing";
							document.getElementById('amount_submit_button').style.display = "none";
							document.getElementById("payment_form").submit();
							return false;
							// alert('sds');
						}   
						//document.getElementById("demo").innerHTML = text;
            }
			
			
		</script>
<? 
}else{ echo "you need to have Job id"; }

?>
