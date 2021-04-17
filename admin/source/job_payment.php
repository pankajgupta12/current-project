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
	if($_GET['job_id']!="")
	{ 
		
	    if (($_POST['step']==1)){
				
				
                
			$TransactionID = 0;
			  //echo $checkeway_token; die;
			if($_POST['page']=='new_c') 
			{  
			  
				$table="payment_gateway";
				$fields_name=array("cc_name","cc_number","cc_type","cc_month","cc_year");
				$fields_heading=array("Credit Card Holder Name","Credit Card Number","Credit Card Type","Credit Card Expiry Month","Credit Card Expiry Year");
				$fields_validation=array(1,1,'',1,1);
					
					  //print_r($_POST); die;
				
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
											    $comment =  'You have ' . getSystemvalueByID($checkagree,107);
											 }else{
												 $comment =  'Did not a charged agreed to card before of a day';
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
				//}
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
		
			
		//$jobTypeId = mysql_fetch_assoc(mysql_query("SELECT job_type_id from job_details where job_id=".$_REQUEST['job_id'].""));
	//$job_details = mysql_fetch_array(mysql_query("select * from job_details where job_id='".mres($_REQUEST['job_id'])."' and job_type='Cleaning'"));		
?>


<script src="https://secure.ewaypayments.com/scripts/eCrypt.min.js"></script>

<div id="tab-3">
    <div class="sec3_tabs_main"> 
	 
	  <?php  
	     $eway_token = get_rs_value("jobs","eway_token",$_REQUEST['job_id']);
		 
		 //echo  '===' .  $payment_agree_check;  die;
		  $details['token_number'] = $eway_token;
	  
	  include('all_payment_list.php'); ?>
	  
	  <script>
	    function checkCartPay(typeid){
			
			if(typeid == 1) {
				$('#job_payment_div_1').show();
				$('#new_credit_cart').hide();
			}else if(typeid == 2){
				$('#new_credit_cart').show();
				$('#job_payment_div_1').hide();
			}
		}
		
		
		
	  </script>
	  
	 
	    <?php  
		 
		 
		 
	     $checkcartSql = mysql_query("SELECT id , token_id from payment_gateway where job_id=".$_REQUEST['job_id']." AND cc_num != '' AND token_id != 0 AND charge_type = 1 ");
		 if(mysql_num_rows($checkcartSql) > 0) {
			 
			
	    ?>
	   <p id="show_payment_text"></p>
	  <script>
	   $(function() {
			  $("#job_payment_div_1").show();
			  $("#new_credit_cart").hide();
        });
	  </script>
		
		<div class="radio-btn-section">
		   <input type="radio"  name ="exitcart_1" onClick="checkCartPay(1);" id="exitcart_1" class="cart" checked><b>Existing Card</b>
		   <input type="radio" name ="exitcart_1"  onClick="checkCartPay(2);" id="exitcart_1" class="cart-1"><b>New Card Details</b>
		</div>
			
			<div id="job_payment_div_1" class="pay_not_recived" style="display:none; margin-top: 29px;">
			   
            <?php  $payment_agree_check = get_rs_value("jobs","payment_agree_check",$_REQUEST['job_id']); 
                if($payment_agree_check != 0) {
                 //$agreed_type = get_sql("system_dd","name"," where type='107' AND id='".$payment_agree_check."'");
				 $details['payment_agree_check'] = $payment_agree_check;
				 $details['job_id'] = $_REQUEST['job_id'];
				 $onchng1 = "onchange=\"javascript:edit_field(this,'jobs.payment_agree_check',".$details['job_id'].");\"";
				 
			//	 onblur="javascript:edit_field(this,\'jobs.payment_agree_check\','".$_REQUEST['job_id']."');"
            ?>
                <!--<span><b><i><?php echo $agreed_type; ?><span></i></b><br/>-->
			     <span class="left_drop_down credit-detail-select" style="width: 40%;"><span><?php echo create_dd("payment_agree_check","system_dd","id","name","type = 107",$onchng1,$details);?></span></span>
				     
            <?php  } ?>  
			    
			    
			<span class="payment_required">Card details</span>
			<?php 
			$job_id = $_REQUEST['job_id']; ?>
				<!--<form   name="form1" action="" id="token_payment_form" method="POST" data-eway-encrypt-key="<?php echo $merchantEncryptionKey; ?>">-->
					<ul  class="tab3_ul card-details">
						<li style="width: 30%;">
						  <label>Card Number</label>
						  <span class="left_drop_down credit-detail-select"><span>
							 <?php echo create_dd("token_number","payment_gateway","token_id","cc_num","job_id = ".$job_id." AND cc_num != '' AND token_id != '' AND charge_type = 1 ","",$details);?></span></span>
						</li>
						<li>
							  <label>Invoice Amount</label>
							  <input type="text" name="amount" id="amount"  >
						</li>
						<li>
						 <!--<input type="submit" name="submit_button" id="submit_button" value="Make Payment" class="job_submit" onclick="javascript:clicked_submit();" />-->
						 <input type="button" name="submit_button" style="width: 50%;" id="amount_submit_button" value="Make Payment" class="job_submit submit-btn" onclick="return checkamount();">
						</li>
						<!--<input type="hidden" name="step" value="1" />
						<input type="hidden" name="page" value="exit_c" />--> 
						<input type="hidden" name="job_id" id="job_id" value="<? echo $_REQUEST['job_id'];?>" />	
						
					</ul>
				<!--</form>-->
			</div>
		<?php  
		}
		?>
	
	 <style>
	 
		.job_body_box {padding-bottom: 50px;}
	 
		.radio-btn-section input[type="radio" i] {width: 16px;height: 16px;vertical-align: middle;}
		.cart{margin: 0 7px 0 0px;}
		.cart span{font-weight:500;}
		.cart-1{margin: 0 5px 0 10px;}
		.card-details li{width:30%;}
		.card-details li:nth-child(2n+1){clear: inherit;}
		.submit-btn{background: #03b9d5;color: white !important;margin: 24px 0 0 10px;}
		.submit-btn:hover {color: #7b7b7b !important;}
		.credit-detail-select{width:100%;}
		
		#card-payment-form {margin-top: 12px;}
		.payment-section{margin-top:10px;}
		.payment-heading{padding:5px 0 5px 0px;}
	 </style>
	 
       <div class="table3_table1" id="new_credit_cart"> 
	   
	   <span  class="payment_required padding_none payment-heading">Credit Card Payments</span>
	   <!--<span style="float: right;width: 50%;" class="payment_required padding_none"><a href="#">Add New Credit Card Details</a></span>-->
          
	   <? //echo $_SESSION['query[txt]'];

			if($_SESSION['query[error]'] == 1){ print error($_SESSION['query[txt]']); }Else If(!empty($_SESSION['query[txt]'])){ print notify($_SESSION['query[txt]']); } ?>
			
		<form   name="form1" action="" id="payment_form card-payment-form" method="POST" data-eway-encrypt-key="<?php echo $merchantEncryptionKey; ?>">
		    
		 <div class="tabs_3main payment-section"> <span class="credit_card">Pay by Credit Card</span> <span class="fill_payment">Please fill the payment details below. </span>			 
			<ul class="tab3_ul">				
				<li>
				  <label>Name on Credit Card </label>
				  <input name="cc_name" type="text" id="cc_name" value="<? if(rw("cc_name")!=""){ echo rw("cc_name"); }else{ echo get_sql("quote_new","name"," where booking_id=".mres($_REQUEST['job_id']).""); } ?>" />
				</li>
				
				<li>
				  <label>Card Number</label>
				  <input type="text" oncopy="return false;" data-eway-encrypt-name="cc_number"  />
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
				    <?php echo create_dd("payment_agree_check","system_dd","id","name","type = 107","",$details);?></span></span>
				     
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
			 	
			<input type="hidden" name="step" value="1" />
			<input type="hidden" name="page" value="new_c" />
			<input type="hidden" name="job_id" value="<? echo $_REQUEST['job_id'];?>" />  
			  
			
		</div>	
        </form>
    </div>
  </div>
</div>
<? 
}else{ echo "you need to have Job id"; }

?>
