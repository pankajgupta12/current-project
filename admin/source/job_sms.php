<?php
//$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mres($_REQUEST['job_id']).""));

if($_REQUEST['step']=="1"){ 
      
	$issue_type1 = $_REQUEST['email_type_data'];
	$job_type_data = $_REQUEST['job_type_data'];
	$issue_type = '';
	$issue_type = get_sql("work_guarantee","email_type_data"," where  id='".$issue_type1."'");
	if($issue_type != '') {
		$issue_type = $issue_type;
	}
	//print_r($_REQUEST); die;
	
	/* 	Array
(
    [task] => sms
    [job_id] => 4615
    [email_type] => 1111111111
    [mobile] => 1111111111
    [email_type_data] => 0
    [job_type_data] => 0
    [message] => fdfdfdfdfdfd
    [step] => 1
    [staff_id] => 
    [PHPSESSID] => q0psk734umu1ffkl5l8mqvema2
) */
	//sendmail($quote['name'],$_REQUEST['email'],$_REQUEST['subject'],$_REQUEST['message'],"crystal@bcic.com.au",$quote['site_id']);
	//sendmail($quote['name'],"crystal@bcic.com.au",$_REQUEST['subject'],$_REQUEST['message'],"crystal@bcic.com.au",$quote['site_id']);
	//sendmail($quote['name'],"manish.khanna1@gmail.com",$_REQUEST['subject'],$_REQUEST['message'],"crystal@bcic.com.au",$quote['site_id']);
	//add_job_emails($_REQUEST['job_id'],$_REQUEST['subject'],$_REQUEST['message'],$_REQUEST['email']);
	
		
	if($_REQUEST['staff_id']!=''){
		//send sms and notification
		
		if($_REQUEST['job_type_data'] == 2) { 
			//send notification
			$getlogin_device = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(device_id) as deviceid  FROM `login_device` WHERE is_logged_in = 1 AND device_id != '' AND login_id = '".$_REQUEST['staff_id']."'"));
			
			if(!empty($getlogin_device['deviceid'])) {
				if($getlogin_device['deviceid'] != '') {
					$heading = $issue_type." Notification Delivered";  
					$result['deviceid'] = $getlogin_device['deviceid'];
					$error_msg = "Notification has been delivered";
				}else{
					$heading = $issue_type." Notification Failed";  
					$result['deviceid'] = $getlogin_device['deviceid'];
					$error_msg = "Notification Failed";					
				}
				 sendNotificationMsg($_REQUEST['message'] , $result);
				 SMSnotificationAdd($_REQUEST['mobile'] , $_REQUEST['message'] , $_REQUEST['staff_id']);
			}else{
				$heading = $issue_type." Notification failed because is not using the app"; 
				$error_msg = "Notification failed because is not using the app";
			}
		}
		else{
			//send sms
			$messagetext = str_replace("'", '', mysql_real_escape_string($_POST['message']));
			$heading = $issue_type." SMS sent to ".$_REQUEST['mobile'];
			$sms_code = send_sms(str_replace(" ","",$_REQUEST['mobile']),$messagetext);
		
				if($sms_code=="1"){ $heading.=" (Delivered)";
				    
				  $error_msg = "The Message has been Sent"; 
				}else{ 
				  $heading.=" <span style=\"color:red;\">(SMS Failed)</span>"; 
				  $error_msg = "The Message has been Failed"; 
				}
			//send_sms($_REQUEST['mobile'],$messagetext);
			//$error_msg = "The Message has been Sent";
		}		
	}
	else{
		//send sms only
		
		//echo 'dfdfdf'; die;
		//echo strip_tags(mysql_real_escape_string($_REQUEST['message']));  die;
		$heading = $issue_type." SMS sent to ".$_REQUEST['mobile'];
		//send_sms($_REQUEST['mobile'],$_REQUEST['message']);
		//$messagetext = (addslashes($_POST['message']));
		$messagetext = str_replace("'", '', mysql_real_escape_string($_POST['message']));
		$sms_code = send_sms(str_replace(" ","",$_REQUEST['mobile']),$messagetext);
		if($sms_code=="1"){ $heading.=" (Delivered)";
        $error_msg = "The Message has been Sent"; 
  		}else{ 
		$heading.=" <span style=\"color:red;\">(SMS Failed)</span>"; 
		$error_msg = "The Message has been Failed"; 
		}
		
	}
	
	
	//echo $heading; 
	
	add_job_notes($_REQUEST['job_id'],$heading,$_REQUEST['message']);
	echo error($error_msg);
	//$heading = $issue_type." SMS sent to ".$_REQUEST['mobile'];
	//send_sms($_REQUEST['mobile'],$_REQUEST['message']);
	//add_job_notes($_REQUEST['job_id'],$heading,$_REQUEST['message']);
	//echo error("The Message has been Sent");
}
?>

<div id="tab-5">
	<form name="form1" method="post" action="">
      <div class="tab5_main">
        <ul class="tabs_5_ul">
          <li> <span>
			<select id="email_type" name="email_type" onchange="javascript:select_mobile(this);">
              <option value="0">Select</option>
              <?php $quote = mysql_fetch_array(mysql_query("select name,phone from quote_new where booking_id=".$_REQUEST['job_id']));?>
              <option value="<?php echo str_replace(" ","",$quote['phone']);?>"><?php echo $quote['name']?></option>
                <?
                  $staff_data = mysql_query("select * from staff where id in (select staff_id from job_details where job_id=".$_REQUEST['job_id']." and status!=2)");
           
					while($staff = mysql_fetch_assoc($staff_data)){ 
						
						echo '<option value="'.str_replace(" ","",$staff['mobile']).'" id="'.$staff['id'].'">'.$staff['name'].' (Staff)</option>';
					}
                ?>
            </select>
            </span> </li>
          <li>
            <input type="text" id="mobile" name="mobile" value="" placeholder="Mobile no">
          </li>
		  <li>
              <!--<span><?php echo create_dd("email_type_data","system_dd","id","name","type = 75","Onchange=\"job_sms_change(this.value ,'".$_REQUEST['job_id']."' );\"", $_SESSION['email_type_data']);?></span>-->
			  <span><?php echo create_dd("email_type_data","work_guarantee","id","email_type_data","status = 1","Onchange=\"job_sms_change(this.value ,'".$_REQUEST['job_id']."' );\"", $_SESSION['email_type_data']);?></span>
          </li>
		  <li id="sms_notif">
              <span><?php echo create_dd("job_type_data","system_dd","id","name","type = 79","Onchange=\"job_notif_change(this.value ,'".$_REQUEST['job_id']."' );\"", $_SESSION['job_type_data']);?></span>
          </li>
          <li>
            <textarea class="tab_textarea" name="message" id="message" placeholder="Message"></textarea>
          </li>
        </ul>
        
        <input type="hidden" name="step" id="step" value="1">
        <input type="hidden" name="task" id="task" value="<?php echo $_REQUEST['task'];?>">
        <input type="hidden" name="job_id" id="job_id" value="<?php echo $_REQUEST['job_id'];?>">
		<input type="hidden" name="staff_id" id="staff_id" value="">
        <input type="submit" class="job_submit" value="Send SMS">
      </div>
  </form>
</div>

<script>
   function job_sms_change(id , job_id){
	   send_data(id+'|'+job_id , 526 , 'message');
   }
   
   function job_notif_change(id){
	   if(id==2){
		   $('.job_submit').attr('value', 'Send Notification');
	   }else{
		  $('.job_submit').attr('value', 'Send SMS'); 
	   }
   }
   
   $(document).ready(function(){
	   $('#sms_notif').hide();
	   $('select#email_type').change(function(){
		   var id = $(this).children("option:selected").attr('id');
		   if(id==null){
			   $('#sms_notif').hide();
			   $('#staff_id').val('');
		   }else{
			   $('#sms_notif').show();
			   $('#staff_id').val(id);
		   }
	   })
	   
   })
   
</script>
