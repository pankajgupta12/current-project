<?php 
$getUser = mysql_query("Select name,id from admin where is_call_allow = 1 AND status = 1 ");
$getSql = mysql_query('Select * from message_board where status = 0 Order by id desc'); 
$countResult = mysql_num_rows($getSql);

$adminname=get_rs_value("admin","name",$_SESSION['admin']);
?>
<div class="messageBox modal-content bd_noti_pop">   
<div class="tab1">
   <div class="bd_noti_quote">
     <div class="tabs-wrapper">
		<input name="tab" id="tab1" class="tab-head" checked="checked" type="radio">
			<div class="messageArea">
				<div class="noti_head allMessages active" onclick="tabMsg(11)"><?php if($countResult > 0) { ?><span class="new-notification"> <?php echo  $countResult; ?></span> <?php  } ?>All Messages</div>
				<div class="noti_head composeMessage" onclick="tabMsg(12)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
</div>
			</div>
			<div class="tabSectionMessage">
				<div class="messageFormArea" id="12">
				<div class="alertMsg"></div>
				<div class="messageForm" >
					<strong>New Message</strong>
					<div class="formArea">
					<span class=" tittle">Select </span>
					<select class="form-controls" id="admin_to" multiple style="height: auto !important;">
					       <option value="0">Select</option>
							<?php  while($data= mysql_fetch_assoc($getUser)) { ?>
								 <option value="<?php  echo $data['id']; ?>"><?php  echo $data['name']; ?></option>
							<?php  } ?>
					</select>
					</div>
					<div class="formArea offsettop20">
						<span class="tittle">Subject</span>
						<input type="text" class="textareaNew form-controls" placeholder="Only allow 50 characters" name="subject" id="subject">
					</div>
					
					<div class="formArea offsettop20">
					<span class="tittle">Message</span>
					<textarea class="form-controls" name="message" placeholder="Only allow 100 characters" id="message" rows="3"></textarea>
					</div>
					<div class="formArea offsettop20">
					<span class="tittles tittle">Priority </span>
					<select class="form-controls" id="priority" >
					       <option value="0">Select</option>
					       <option value="1">High</option>
						   <option value="2">Low</option>
					</select>
					</div>
					
					<!--<div class="formArea offsettop20">
						<span class="tittles tittle">Task Type </span>
						<select class="form-controls" id="add_task" >
							   <option value="0">Select</option>
							   <option value="1"  selected>Message Board</option>
							   <option value="2">Add Task</option>
						</select>
					</div>-->
					
					<div class="buttonArea offsettop20">
						<div  class="btn btnSent" onclick="return send_message()">Send</div>
					</div>
				</div>
			</div>
				<div class="AllMsgArea" id="message_board_list">
				 <ul class="qulist1">
                   <?php 
				   if($countResult > 0) {
				    while($getmsg = mysql_fetch_assoc($getSql)) {
						
						
				     //$to =   get_rs_value("admin","name",$getmsg['message_to']);
				     $from =  get_rs_value("admin","name",$getmsg['message_from']);
					 $tovalue = explode(',',$getmsg['message_to']);
				   ?> 
					<li class="quote_notification <?php if($getmsg['priority'] == 1) {  ?> latest <?php  } ?>">
					    <span class="bd_list_border"><span class="toUser"><strong>To : </strong> <?php //print_r($tovalue); //echo $getmsg['message_to']; 
						$tolist = array();
						foreach($tovalue as $valueto) {
							$tolist[] =  get_rs_value("admin","name",$valueto);
						}
						echo implode(',',$tolist);
						?></span>
                            <span onclick="messageboard_delete('<?php echo $getmsg['id'];  ?>');" class="hideIt">X</span>

							<span class="subjectUser"><strong>Subject : <span class="nameFrom"><?php echo ucfirst($getmsg['subject']); ?> </span></strong></span>
                              <p class="timeUser offsetRight"><?php echo changeDateFormate($getmsg['createdOn'],'datetime');  ?></p><b class="fs13"><?php echo $getmsg['message']; ?></b>
						</span>
						
					<span class="formUser"><strong>From : <span class="nameFrom"><?php echo $from; ?> </span></strong></span>
					
					<?php  if($getmsg['message_replay_user'] != '' && trim($getmsg['replay_text']) != '') { ?>
				 	  <span class="formUser" style="float: left;margin-top: -5%;padding: 9px;"><strong>Reply From : <span class="nameFrom"><?php echo  $getmsg['message_replay_user']; ?> </span><p style="float: right;margin-left: 29px;font-size: 13px;">	<?php echo changeDateFormate($getmsg['replay_date'],'datetime');  ?></p></strong>
					  </span>
					   
					  
					<?php  }  
					if(trim($getmsg['replay_text']) != '') { echo '<p class="msgText">'.$getmsg['replay_text'].'</p>'; } else { ?>
					
					<span><textarea type="text" class="replytext" id="replay_text_<?php echo $getmsg['id'];  ?>" placeholder="Reply by <?php echo $adminname;  ?>" col="4" rows="5"  onblur="javascript:edit_field(this,'message_board.replay_text','<?php echo $getmsg['id'];  ?>');"><?php if($getmsg['replay_text'] != '') { echo $getmsg['replay_text']; } ?></textarea></span>
					
					<?php  } ?>
					
					</li>
				   <?php } }else { ?>
				   <li class="quote_notification" >
				   <span class="subjectUser"><strong><span class="nameFrom">  No messages.  </span></strong></span>
				    
				   </li>
				   <?php  } ?>
				</ul>
				   <?php //include('message_board_list.php');   ?>
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