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

function checkamount() {
				    
						 var amt, text;
						// Get the value of the input field with id="numb"
						token_number = document.getElementById("token_number").value;
						amt = document.getElementById("amount").value;
						job_id = document.getElementById("job_id").value;
						
						//alert(token_number);
						
						
						if(token_number == 0 || token_number == undefined) {
							 alert('Please Select Cart Number');
						}else if (isNaN(amt) || amt < 1 || amt == '' || amt == null || amt == undefined) {
							//text = "Input not valid";
						  alert('Please enter valid invoice amount');
						  document.getElementById("amount").value = '';
                            return false;						  
						} else {
							document.getElementById('amount_submit_button').value ="Please wait ... processing";
							/* document.getElementById('amount_submit_button').style.display = "none";
							document.getElementById("token_payment_form").submit();
							return false; */
							// alert('sds');
							
							var str = token_number+'|'+amt+'|'+job_id;
							//alert(str);
							send_data(str , 452 , 'show_payment_text');
						}   
						//document.getElementById("demo").innerHTML = text;
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
						  
						
							  
							  if($accept_terms_status == 0) {
								  echo '<img src="../admin/images/no_icon.png" style="height:35px; width:35px; margin: 10px 15px">';}else{echo '<img src="../admin/images/check_agree.png" style="height:35px; width:35px; margin: 10px 15px">'; 
							  
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
	 
	 <?php  if($tc_flag == true) {  ?>
	    <span class="payment_required">Term Accepted Details  </span>
		  <div>
		 <?php  
			 $job_id = $_REQUEST['job_id'];
			 include("xjax/tc_details.php");  
		  ?>
	  </div>
	 <?php  } ?>
	 
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
		?>
	</div>
		
	  <span class="payment_required">Payments Refund</span>
	  <div>
		 <?php  
			 $job_id = $_REQUEST['job_id'];
			 include("xjax/refund_amount.php");  
		  ?>
	  </div>