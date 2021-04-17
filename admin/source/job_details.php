<?php
    $quote = mysql_fetch_array(mysql_query("select booking_date,amount, id, booking_id  from quote_new where booking_id=".mysql_real_escape_string($_REQUEST['job_id']).""));

	
	$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".mysql_real_escape_string($_REQUEST['job_id']).""));
	
	//
	  $getAgentDetails = mysql_fetch_array(mysql_query("select real_estate_agency_name, agent_address , agent_landline_num , agent_name,agent_number,agent_email from job_details where job_id=".mysql_real_escape_string($_REQUEST['job_id'])." AND status != 2 limit 0 , 1"));
	
?>


<div id="tab-1">
    <div class="container">        
        <div class="popup_left_bar" style="<?php if( $_SESSION['job_acc_status'] || $_SESSION['job_Pay_status']){ print $style; } ?>">
        <?php  print $elem;  ?>
        
		    
		      <span class="job_detail_text">Secondery Client Info </span>
				<ul class="input_list input_list3 real_estate_details">
				
					<li><label>Name: </label><input type="text" id="secondary_name" name="secondary_name" placeholder="Name" ></li>
					 
					 <li><label>Email: </label><input type="text" id="secondary_email" name="secondary_email" placeholder="Email"></li>
					 
					
					<li><label> Number: </label><input type="text"  onkeypress="return isNumberKey(event)" maxlength="10" id="secondary_number" name="secondary_number" placeholder="Number"></li>
					
					<li style="margin-top: 17px;">
					    <a class="staff_button" style="float: left;padding: 8px;" href="javascript:add_client_info('<?php echo $quote['id'] ?>','<?php echo $quote['booking_id'] ?>');" >Submit</a> 
					    <a class="staff_button" style="margin: 11px;float: left;" href="javascript:showdiv('client_info_details');">View</a>
					</li>
				</ul>
				
				<ul class="input_list input_list3 real_estate_details" style="margin: 11px 11px 15px 5px; display:none;" id="client_info_details" >
				    <div id="client_info">
                      <?php  include('xjax/job_client_other_info.php'); ?>
                    </div>				   
					
				</ul>
		 
		    <span class="job_detail_text">Real Estate Agent Details </span>
				<ul class="input_list input_list3 real_estate_details" >
				
					<li><label> Agency Name: </label><input type="text" id="real_estate_agency_name" name="real_estate_agency_name" placeholder="Agency name" value="<?php echo $getAgentDetails['real_estate_agency_name'];?>" onblur="javascript:edit_field(this,'job_details.real_estate_agency_name',<?php echo $jobs['id']?>);"></li>
					 
					 <li><label>Agent Name: </label><input type="text" id="agent_name" name="agent_name" placeholder="Agent name" value="<?php echo $getAgentDetails['agent_name'];?>" onblur="javascript:edit_field(this,'job_details.agent_name',<?php echo $jobs['id']?>);"></li>
					 
					
					<li><label>Agent Number: </label><input type="text"  onkeypress="return isNumberKey(event)" maxlength="10" id="agent_number" name="agent_number" placeholder="Agent number" value="<?php echo $getAgentDetails['agent_number'];?>" onblur="javascript:edit_field(this,'job_details.agent_number',<?php echo $jobs['id']?>);"></li>
					
					 <li><label>Agent Email: </label><input type="text" id="agent_email" name="agent_email" placeholder="Agent email" value="<?php echo $getAgentDetails['agent_email'];?>" onblur="javascript:edit_field(this,'job_details.agent_email',<?php echo $jobs['id']?>);"></li>
					 
					  <li><label>Agent LandLine No: </label><input type="text" id="agent_landline_num" name="agent_landline_num" placeholder="Agent LandLine No" value="<?php echo $getAgentDetails['agent_landline_num'];?>" onblur="javascript:edit_field(this,'job_details.agent_landline_num',<?php echo $jobs['id']?>);"></li>
					  
					   <li><label>Agent address: </label><input type="text" id="agent_address" name="agent_address" placeholder="Agent address" value="<?php echo $getAgentDetails['agent_address'];?>" onblur="javascript:edit_field(this,'job_details.agent_address',<?php echo $jobs['id']?>);"></li>
					 
				</ul>
			
		
			<span class="job_detail_text">Job detail </span>
				<ul class="input_list input_list3 job_details_popup">
				
					<li><label>Work Guarantee: </label><span><?php echo create_dd("work_guarantee","system_dd","id","name",'type=35',"onchange=\"javascript:edit_field(this,'jobs.work_guarantee',".$jobs['id'].");getfoucewithtext(this.value);\"",$jobs); ?></span></li>
					 
					<li><label>WG With Reason: </label><input type="text" id="work_guarantee_text" name="work_guarantee_text" placeholder="Reason for work guarantee" value="<?php echo $jobs['work_guarantee_text'];?>" onblur="javascript:edit_field(this,'jobs.work_guarantee_text',<?php echo $jobs['id']?>);"></li>
					 
					
					<!--<li><label>Customer Exp: </label><span><?php echo create_dd("customer_experience","system_dd","id","name",'type=36',"onchange=\"javascript:edit_field(this,'jobs.customer_experience',".$jobs['id'].");\"",$jobs); ?></span></li>-->
					
					<?php if($jobs['work_guarantee'] == 2) { ?>
					   <li id="send_email_to_client_data"><label>Send NG Email</label><input type="button" name="send_email_to_client" value="Send NG Email" onclick="send_data('<?php echo $jobs['id']; ?>',522 , 'send_ng_emails_text');" style="background: #bfe6bf;color: #000;cursor: pointer;"></button></li>
					<?php  }else{ ?>
					   <li style="display:none;" id="send_email_to_client_data"><label>Send NG Email </label><input type="button" name="send_email_to_client" value="Send NG Email" onclick="send_data('<?php echo $jobs['id']; ?>',522 , 'send_ng_emails_text');" style="background: #bfe6bf;color: #000;cursor: pointer;"></button></li>
					<?php  } ?>
					
					
					<!--<li><label>Staff Address: </label><span><?php echo create_dd("staff_display_address","system_dd","id","name",'type=29',"onchange=\"javascript:edit_field(this,'jobs.staff_display_address',".$jobs['id'].");\"",$jobs); ?></span></li>-->
					 
				</ul>	
				<p id="send_ng_emails_text" style="text-align: center;font-weight: 600;color: green;margin-left: 131px;"></p>
			
            <span class="job_detail_text">Customer Payment</span>  
            <ul class="input_list input_list3 custome_payment_details">
			
                <li><label>Amount <?php if($jobs['customer_amount']!=""){ $camount = $jobs['customer_amount']; }else{ $camount = $quote['amount']; } ?></label><input type="text" id="customer_amount" name="customer_amount" value="<?php echo $camount;?>" onblur="javascript:edit_field(this,'jobs.customer_amount',<?php echo $jobs['id']?>);"></li>
                <li><label>Payment Method</label><span><?php echo create_dd("customer_payment_method","system_dd","name","name",'type=27',"onchange=\"javascript:edit_field(this,'jobs.customer_payment_method',".$jobs['id'].");\"",$jobs); ?></span>	
                <li><label>Paid</label><span><?php echo create_dd("customer_paid","system_dd","id","name",'type=18',"onchange=\"javascript:edit_field(this,'jobs.customer_paid',".$jobs['id'].");\"",$jobs); ?></span></li>
                <li><label>Paid Date</label>
                   <input type="text" id="customer_paid_date" name="customer_paid_date" value="<?php echo $jobs['customer_paid_date'];?>" onChange="javascript:edit_field(this,'jobs.customer_paid_date',<?php echo $jobs['id']?>);">
                </li>
                
                <li><label>Invoice Status</label>
                  <span><?php echo create_dd("invoice_status","system_dd","id","name",'type=21',"onchange=\"javascript:edit_field(this,'jobs.invoice_status',".$jobs['id'].");\"",$jobs); ?></span>
                </li>
                
            </ul>
            
            <span class="job_detail_text">email & sms</span>
                
                <div class="usertable-overflow">
                 
                    <table class="email_sms-table">
                            <thead>
                              <th>Confirm Booking</td>
                              <th style="text-align: center;">Cleaner Details to Client</td>
                              <td>Email Client Invoice</td>
                            </thead>
                            <tbody>
                              <tr>
                              <td><a href="javascript:send_data('<?php echo $jobs['id'];?>|email_client_booking_conf','24','email_client_booking_conf_div');">Send Email</a></td>
                              <td><a href="javascript:send_data('<?php echo $jobs['id'];?>|email_client_cleaner_details','24','email_client_cleaner_details_div');">Send Email</a>
                              | <a href="javascript:send_data('<?php echo $jobs['id'];?>|sms_client_cleaner_details','24','sms_client_cleaner_details_div');">Send SMS</a></td>
                              <td><a href="javascript:send_data('<?php echo $jobs['id'];?>|email_client_invoice','24','email_client_invoice_div');">Email</a></td>
                            </tr>
                            <tr>
                              <td id="email_client_booking_conf_div">
                              <?php if($jobs['email_client_booking_conf']!="0000-00-00 00:00:00") { 
                                echo date("d M Y h:i:s",strtotime($jobs['email_client_booking_conf'])); 
                                } ?>
                              </td>
                              <td>
							   <span id="email_client_cleaner_details_div"> <?php if($jobs['email_client_cleaner_details']!="0000-00-00 00:00:00") { 
                              echo date("d M Y h:i:s",strtotime($jobs['email_client_cleaner_details']));
                              } ?></span>
							  |
							    <span id="sms_client_cleaner_details_div">  <?php if($jobs['sms_client_cleaner_details']!="0000-00-00 00:00:00") { 
                              echo date("d M Y h:i:s",strtotime($jobs['sms_client_cleaner_details']));
                              } ?></span>
							  </td>
                              <td id="email_client_invoice_div"><?php if($jobs['email_client_invoice']!="0000-00-00 00:00:00") { 
                              echo date("d M Y h:i:s",strtotime($jobs['email_client_invoice']));
                              } ?></td>
                            </tr>
                            </tbody>
                          </table>                     
                     
                     
                      
                </div>
        </div>
		
		
		
        <div class="popup_right_bar" style="margin-top: 15px;">
		   
		    <div>
				<input type="button" value="All notes" class="staff_button_over" id="all_notes" onclick="show_noraml_notes('all');changeclass(1);" style="float:left; margin-right:10px;">
				
				<input type="button" value="Staff notes" class="staff_button" id="staff_notes" onclick="show_staff_notes('staff');changeclass(2);" style="float:left; margin-right:10px;">
				
				<input type="button" value="Chat notes" class="staff_button" id="chat_notes" onclick="show_chat_notes('chat');changeclass(3);" style="float:left; margin-right:10px;">
				
				<!--<input type="button" value="Booking Question Notes" class="staff_button" id="booking_notes" onclick="show_booking_notes('booking');changeclass(4);" style="float:left; margin-right:10px;">-->
				
				<input type="button" value="3PM Notes" class="staff_button" id="booking_notes" onclick="show_booking_notes('booking');changeclass(4);" style="float:left; margin-right:10px;">
		    </div>
		
		
            <div class="text_box all_notes" style="margin-top: 13px;">
               <textarea name="comments" id="comments" class="textarea_box_notes" placeholder="Type a Job Note Here" ></textarea>
                <span class="textarea_add_btn">
                	<input id="comments_button" name="comments_button"  type="button" value="add" onclick="javascript:add_comment(document.getElementById('comments'),'<?php echo $jobs['id'];?>')" style="height:100%; width:100%">
                </span>
            </div>
			
			
			<div class="text_box staff_details" style="margin-top: 13px; display:none;">
               <textarea name="comments" id="staff_comments" class="textarea_box_notes" placeholder="Staff Note Added by <?php echo get_rs_value("admin","name",$_SESSION['admin']); ?>" ></textarea>
                <span class="textarea_add_btn">
                	<input id="staff_comments_button" name="comments_button" type="button" value="add" onclick="javascript:staff_add_comment(document.getElementById('staff_comments'),'<?php echo $jobs['id'];?>')" style="height:100%; width:100%">
                </span>
            </div>
			
			<div class="text_box chat_details" style="margin-top: 13px;">
             
               
            </div>
            
            
			<div id="job_notes_div">
        			<?php 
						$quote_id = $quote['id'];
            			$job_id=$jobs['id'];
            			include("xjax/job_notes.php");
        			?>
            </div>
        </div>
    </div>
</div>

<script>
	$("#comments").keyup(function(event){
		if(event.keyCode == 13){
			$("#comments_button").click();
		}
	});

		$(function() {
			$("#customer_paid_date").datepicker({dateFormat:'yy-mm-dd'});
		}); 
		
	$("#staff_comments").keyup(function(event){
		if(event.keyCode == 13){
			$("#staff_comments_button").click();
		}
	});
	
	function getfoucewithtext(value){
		 //alert(value);
		 
		$('#work_guarantee_text').focus();
		$('#work_guarantee_text').css('border','3px solid #d28282');
		$('#work_guarantee').css('border','3px solid #d28282');
		if(value== 2) {
			$('#send_email_to_client_data').show();
		}else{
		   $('#send_email_to_client_data').hide();	
		}
	}
	
</script>


