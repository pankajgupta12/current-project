<?php 
$getUser = mysql_query("Select name,id from admin where is_call_allow = 1 AND status = 1 ");
 
/* $getassigndata['assign_admin']['admin_task_id'] = '';

 $comlt_date = date('Y-m-d' , strtotime('-1 day'));
 $arg = 'SELECT * FROM `site_notifications`  WHERE task_type = 2 AND staff_id = 0 AND ( task_complete_date= "0000-00-00 00:00:00" OR  DATE(task_complete_date) >= "'.$comlt_date.'" )'; 

//echo  $arg;
//echo  $loginid;

 //echo  $loginid .'=='.$type;

 if($loginid > 0 && $type == 1) {
   $arg .= ' AND login_id = "'.$loginid.'"';
   $getassigndata['assign_admin']['admin_task_id'] = $loginid;
 }if($loginid == 0 && $type == 2) {
   $arg .= ' AND login_id = 0';
   $getassigndata['assign_admin']['message_status'] = $loginid;
 }elseif($loginid > 0 && $type == 2) {
      $arg .= ' AND message_status = "'.$loginid.'"';
     $getassigndata['assign_admin']['message_status'] = $loginid;
   }
   
   //echo $arg;

 $getSql = mysql_query($arg);
$countResult = mysql_num_rows($getSql);

$adminname=get_rs_value("admin","name",$_SESSION['admin']);*/
?>
<div class="messageBox modal-content bd_noti_pop">   
<div class="tab1">
   <div class="bd_noti_quote">
     <div class="tabs-wrapper">
         
			<!--<div class="messageArea">
				<div class="noti_head allMessages " onclick="tabMsg(11)"><?php //if($countResult > 0) { ?>
				<span class="new-notification"> <?php // echo  $countResult; ?></span>
				   <span>
				     <?php // echo create_dd("admin_task_id","admin","id","name",'status = 1 AND is_call_allow = 1',"onchange=\"javascript:search_task_data(this.value , 1);\"",$getassigndata['assign_admin']); ?>
				   </span>
				   
				    <span>
				     <?php  //echo create_dd("message_status","system_dd","id","name",'type in(135, 136) Order by type desc',"onchange=\"javascript:search_task_data(this.value, 2);\"",$getassigndata['assign_admin']); ?>
				   </span>
				   
				<?php // } ?></div>
				<div class="noti_head composeMessage" onclick="tabMsg(12)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
			</div>-->
			
			
			
			
			<div class="tabSectionMessage">
			    
				<div class="messageFormArea active" id="12" style="display: block;">
				<div class="alertMsg"></div>
				
				<div class="messageForm" >
				     
					<strong>New Message</strong>
					<p id="task_messags_id" style="color:#108c10; text-align: center;"></p>
					<div class="formArea">
    					<span class=" tittle">Select </span>
    					<select class="form-controls" id="admin_to"  style="height: auto !important;">
    					      
    					       <option value="0">All</option>
    							<?php  while($data= mysql_fetch_assoc($getUser)) { ?>
    								 <option value="<?php  echo $data['id']; ?>"><?php  echo $data['name']; ?></option>
    							<?php  } ?>
    					</select>
					</div>
					<div class="formArea offsettop20">
						<span class="tittle">Subject</span>
						<input type="text" class="textareaNew form-controls" placeholder="Please enter  subject" name="subject" id="subject">
					</div>
					
					<div class="formArea offsettop20">
					<span class="tittle">Message</span>
					<textarea class="form-controls" name="message" placeholder="Please enter message" id="message" rows="3"></textarea>
					</div>
					
					<div class="formArea">
					<select class="form-controls" id="quote_job_id" style="float: left; width:50%" style="height: auto !important;">
					       <option value="0">Select</option>
					       <option value="1">Job ID</option>
					       <option value="2">Quote ID</option>
					</select>
					  <input type="text"  style="float: right;width:50%"  class="textareaNew form-controls" placeholder="Please enter  Q/J ID" name="q_j_id" id="q_j_id">
					</div>
					
					
					<div class="formArea offsettop20">
					<!--<span class="tittle">Urgent</span>-->
					  <input type="checkbox" name="urgent_noti" id="urgent_noti"/>  Urgent
					</div>
					
					<div class="buttonArea offsettop20">
						<div  class="btn btnSent" onclick="return task_send_message()">Send</div>
					</div>
				</div>
			</div>
				
			</div>
		 </div>
	    </div>
	</div>

	 <style>
		textarea.replytext {
			width: 100%;
			min-height: 50px;
			margin-bottom: 10px;
		}
		.msgText {
			margin-top: 17px;
			font-size: 14px;
			    padding: 8px;
		}
	 </style>
	
</div>
</div>