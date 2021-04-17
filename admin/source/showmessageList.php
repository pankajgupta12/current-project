<?php  

     	include("functions/functions.php");
		include("functions/config.php");

    if($_POST) {
      
        if($_POST['page'] == 'getdata') {
              
            if($_POST['addressmessage'] != '') {   
 
            $fromnumber = trim($_POST['addressmessage']);
            $name = $_POST['name'];
			//echo "UPDATE `mysms_parents_conversation` SET `messagesUnread` = '0' WHERE `mysms_parents_conversation`.`from_address` = '".$fromnumber."'";
			
			mysql_query("UPDATE `mysms_parents_conversation` SET `messagesUnread` = '0' WHERE from_address = '".$fromnumber."'");
		//	echo "UPDATE `mysms_child_conversation` SET `read_by` = '".$_SESSION['admin']."' WHERE from_address = '".$fromnumber."' AND read_by = 0";
			mysql_query("UPDATE `mysms_child_conversation` SET `read_by` = '".$_SESSION['admin']."' WHERE from_address = '".$fromnumber."' AND read_by = 0");
			
            $sql = mysql_query("SELECT * FROM `mysms_child_conversation` WHERE p_id = '".$fromnumber."'  ORDER by dateSent asc");
          
            $count = mysql_num_rows($sql);
			
			
 
   
 ?>
 
           <div class="msg_history_one">
		   
			<div class="userName" id="lefttopbar">
				<div class="vpb_left_header newoNEClass admin_staff_details" align="left">
				<span id="sessionUserID"><?php  echo $name;  ?></span>


				<span id="sessionUserMob"><a id="usr_num" href="tel:<?php echo $fromnumber; ?>" data-tel="<?php echo $fromnumber; ?>" data-comp="<?php echo $fromnumber; ?>" style="display:block"><?php echo $fromnumber; ?></a></span>
				</div>
		    </div>
                
                <?php   
                 if($count > 0) {
                while($data = mysql_fetch_assoc($sql)) { 
                
                 $Textmessage = str_replace(array("\r\n",'\n'),array("",''),$data['message']);
                 $Textmessage = preg_replace('/\\\\/', '', $Textmessage);
                
                if($data['incoming'] == 'true') {
                ?>
                
                    <div class="incoming_msg">
                      
                      <div class="received_msg">
					  <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> 
					  <span class="time_date"><?php  echo date('H:s' , strtotime($data['dateSent']));  ?>  |    <?php  echo date('M d' , strtotime($data['dateSent']));  ?> <?php if($data['read_by'] > 0) { ?> ( Seen by <?php echo get_rs_value('admin','name', $data['read_by']).' )';  } ?></span> </div>
                        <div class="received_withd_msg">
                          <p><?php  echo  $Textmessage;  ?></p>
                         </div>
                      </div>
                    </div>
             <?php  } else if($data['incoming'] == 'false') { ?>        
                    
                <div class="outgoing_msg">
                  <div class="sent_msg">
					<div class="outgoing_msg"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
					<span class="time_date"><?php  echo date('H:s' , strtotime($data['dateSent']));  ?>  |    <?php  echo date('M d' , strtotime($data['dateSent']));  ?> </span></div>
					
                    <p><?php  echo  $Textmessage;  ?></p>
                   </div>
					
                </div>
                
             <?php  } }  } else { ?>    
                 <div class="outgoing_msg" style="margin-top: 81px;">
                      <div class="sent_msg">
                        <p>No Messages</p>
                       
                    </div>
            <?php  } ?>    
          
            </div>
 
 
 
 <?php } } else if($_POST['page'] == 'sendpage') { 
         $name = $_POST['name'];
        $message = mysql_real_escape_string($_POST['message']);
        //$sendto = substr($_POST['sendid'] ,3);
        $sendto = mysql_real_escape_string($_POST['sendid']);
        
        $sms_code = send_sms(str_replace(" ","",$sendto),$message);
        
       // echo $sms_code;

     $fromnumber = trim($_POST['sendid']);
   //  echo "SELECT * FROM `mysms_child_conversation` WHERE p_id = '".$fromnumber."'  ORDER by dateSent asc"; die;
   
        mysql_query("UPDATE `mysms_child_conversation` SET `read_by` = '".$_SESSION['admin']."' WHERE from_address = '".$fromnumber."' AND read_by = 0");
        $sql = mysql_query("SELECT * FROM `mysms_child_conversation` WHERE p_id = '".trim($fromnumber)."'  ORDER by dateSent asc");
          
          $count = mysql_num_rows($sql);
    
  ?>
  
      <div class="msg_history">
                
				<div class="userName" id="lefttopbar">
					<div class="vpb_left_header newoNEClass admin_staff_details" align="left">
					<span id="sessionUserID"><?php  echo $name;  ?></span>


					<span id="sessionUserMob"><a id="usr_num" href="tel:<?php echo $fromnumber; ?>" data-tel="<?php echo $fromnumber; ?>" data-comp="<?php echo $fromnumber; ?>" style="display:block"><?php echo $fromnumber; ?></a></span>
					</div>
				</div>
				
                <?php   
                 if($count > 0) {
                while($data = mysql_fetch_assoc($sql)) { 
                
                 $Textmessage = str_replace(array("\r\n",'\n'),array("",''),$data['message']);
                 $Textmessage = preg_replace('/\\\\/', '', $Textmessage);
                
                if($data['incoming'] == 'true') {
                ?>
                
                     <div class="incoming_msg">
                      
                      <div class="received_msg">
					  <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> 
					  <span class="time_date"><?php  echo date('H:s' , strtotime($data['dateSent']));  ?>  |    <?php  echo date('M d' , strtotime($data['dateSent']));  ?> </span> </div>
                        <div class="received_withd_msg">
                          <p><?php  echo  $Textmessage;  ?></p>
                         </div>
                      </div>
                    </div>
                <?php  } else if($data['incoming'] == 'false') { ?>
				
                <div class="outgoing_msg">
                  <div class="sent_msg">
					<div class="outgoing_msg"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
					<span class="time_date"><?php  echo date('H:s' , strtotime($data['dateSent']));  ?>  |    <?php  echo date('M d' , strtotime($data['dateSent']));  ?> </span></div>
					
                    <p><?php  echo  $Textmessage;  ?></p>
                   </div>
					
                </div>
                
             <?php  } }  } else { ?>    
                 <div class="outgoing_msg">
                      <div class="sent_msg">
                        <p>No Messages</p>
                       
                    </div>
            <?php  } ?>    
          
            </div>
  
  <?php 

    }  
	  else if($_POST['page'] == 'sendnewmessage') 
	{
		
         $message = mysql_real_escape_string($_POST['message_id']);
        //$sendto = substr($_POST['sendid'] ,3);
        $fromnumber = mysql_real_escape_string($_POST['mobilenumber']);
        
		 //print_r($_POST); die;
		
        $sms_code = send_sms(str_replace(" ","",$fromnumber),$message); 
		
		//$fromnumber = '0478950060';
		
		 //echo "SELECT * FROM `mysms_child_conversation` WHERE p_id = '".$fromnumber."'  ORDER by dateSent asc";
		 $sql1 = mysql_query("SELECT * FROM `mysms_child_conversation` WHERE p_id = '".$fromnumber."'  ORDER by dateSent asc");
          
         $count1 = mysql_num_rows($sql1);
		
 ?>

          <div class="msg_history_one">
		   
			<div class="userName" id="lefttopbar">
				<div class="vpb_left_header newoNEClass admin_staff_details" align="left">
				<span id="sessionUserID"><?php if($name != '') { echo $name; }  ?></span>


				<span id="sessionUserMob"><a id="usr_num" href="tel:<?php echo $fromnumber; ?>" data-tel="<?php echo $fromnumber; ?>" data-comp="<?php echo $fromnumber; ?>" style="display:block"><?php echo $fromnumber; ?></a></span>
				</div>
		    </div>
                
                <?php   
                 if($count1 > 0) {
                while($data = mysql_fetch_assoc($sql1)) { 
                
                 $Textmessage = str_replace(array("\r\n",'\n'),array("",''),$data['message']);
                 $Textmessage = preg_replace('/\\\\/', '', $Textmessage);
                
                if($data['incoming'] == 'true') {
                ?>
                
                    <div class="incoming_msg">
                      
                      <div class="received_msg">
					  <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> 
					  <span class="time_date"><?php  echo date('H:s' , strtotime($data['dateSent']));  ?>  |    <?php  echo date('M d' , strtotime($data['dateSent']));  ?> </span> </div>
                        <div class="received_withd_msg">
                          <p><?php  echo  $Textmessage;  ?></p>
                         </div>
                      </div>
                    </div>
             <?php  } else if($data['incoming'] == 'false') { ?>        
                    
                <div class="outgoing_msg">
                  <div class="sent_msg">
					<div class="outgoing_msg"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
					<span class="time_date"><?php  echo date('H:s' , strtotime($data['dateSent']));  ?>  |    <?php  echo date('M d' , strtotime($data['dateSent']));  ?> </span></div>
					
                    <p><?php  echo  $Textmessage;  ?></p>
                   </div>
					
                </div>
                
             <?php  } }  } else { ?>    
                 <div class="outgoing_msg" style="margin-top: 81px;">
                      <div class="sent_msg">
                        <p>No Messages</p>
                       
                    </div>
            <?php  } ?>    
          
            </div>

<?php  }else if($_POST['page'] == 'countermessage') { 
    
     $getUnread = getUnreadMessage();
    
    ?>
        
                     <li class="class-txt active" id="class_txt_1" onClick="getMessageType(1);">
							    <label style="color:#000">S#</label> 
							       <input value="staff" data-id='1' class="default_option" type="radio" checked="checked" name="invoke_lst">
									<?php if($getUnread['staff']['message_type'] == 'staff') { ?>
									  <div class="cnt_staff" id="sms_counter_message_1" ><?php echo $getUnread['staff']['unreadmessage']; ?></div>
									<?php  } ?>
							  </li>
							  <li class="class-txt" id="class_txt_2" onClick="getMessageType(2);">
							    <label style="color:#000">Q#</label> <input value="quote"   data-id='2' class="default_option" type="radio" name="invoke_lst">
									<?php if($getUnread['quote']['message_type'] == 'quote') { ?>
									  <div class="cnt_staff" id="sms_counter_message_2"><?php echo $getUnread['quote']['unreadmessage']; ?></div>
									<?php  } ?>
							  </li>
							  <li class="class-txt" id="class_txt_3" onClick="getMessageType(3);">
							    <label style="color:#000">J#</label> <input value="jobs"  data-id='3' class="default_option" type="radio" name="invoke_lst">
									
									<?php if($getUnread['jobs']['message_type'] == 'jobs') { ?>
									  <div class="cnt_staff" id="sms_counter_message_3" ><?php echo $getUnread['jobs']['unreadmessage']; ?></div>
									<?php  } ?>
							  </li>
							  <li class="class-txt" id="class_txt_4" onClick="getMessageType(4);">
							    <label style="color:#000">H#</label> <input value="hr"  data-id='4' class="default_option" type="radio" name="invoke_lst">
									<?php if($getUnread['hr']['message_type'] == 'hr') { ?>
									  <div class="cnt_staff" id="sms_counter_message_4"><?php echo $getUnread['hr']['unreadmessage']; ?></div>
									<?php  } ?>
							  </li>
							  <li class="class-txt" id="class_txt_5" onClick="getMessageType(5);">
							    <label style="color:#000">N#</label> <input value="new"  data-id='3' class="default_option" type="radio" name="invoke_lst">
									
									<?php if($getUnread['nothing']['message_type'] == 'nothing') { ?>
									  <div class="cnt_staff" id="sms_counter_message_5"><?php echo $getUnread['nothing']['unreadmessage']; ?></div>
									<?php  } ?>
							  </li>
							  <li class="class-txt1">
							  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" style="margin-top: 3px;">
								   <span class="glyphicon glyphicon-plus"></span>
								</button>
							  </li>
       
       
      <?php 
 
	} }
 ?>