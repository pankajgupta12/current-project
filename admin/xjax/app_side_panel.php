<br/>
<?php  
 //$requoteid = $requoteid;
 $applicationID = $appid;
 $appdetails = mysql_fetch_assoc(mysql_query("SELECT id, first_name FROM `staff_applications` WHERE id = '".$appid."'"));
 
 echo 'Application Id ' .$appid.'<br/>';
 // echo 'Job Id ' .$Redata['job_id'].'<br/>';
 echo '<p id="custsms></p>';
 
 ?>
<br/>

<div class="modal-content"> 

  
	
    <div>
		<span id="message_show"></span>
		<a href="javascript:scrollWindow('application_emails.php?email_task=first_email&app_id=<?php echo $appid; ?>','800','600')"  class="bb_vquote file_icon"><i class="fa fa-envelope-o" aria-hidden="true"></i> Send First Email</a>
		<a href="javascript:scrollWindow('application_emails.php?email_task=docs_required&app_id=<?php echo $appid; ?>','800','600')" class="bb_vquote file_icon"><i class="fa fa-envelope-o" aria-hidden="true"></i> Docs Email</a>
		<a href="javascript:scrollWindow('application_emails.php?email_task=welcome_email&app_id=<?php echo $appid; ?>','800','600')" class="bb_vquote file_icon"><i class="fa fa-envelope-o"aria-hidden="true"></i> Welcome Email</a>
    </div>
   
   <ul class="called_details_app">

    	<li><a href="javascript:scrollWindow('app_custom_sms.php?sms_task=first&app_id=<?php echo $appid; ?>','500','500')"  class="bb_job file_icon" id="appid_first_<?php echo $appid; ?>"><i class="fa fa-comment-o" aria-hidden="true"></i> SMS NA </a></li>
    
    	<li><a href="javascript:scrollWindow('app_custom_sms.php?sms_task=second&app_id=<?php echo $appid; ?>','500','500')"  class="bb_job file_icon" id="appid_second_<?php echo $appid; ?>"><i class="fa fa-comment-o" aria-hidden="true"></i> SMS NA 2</a></li>
    
    	<li><a href="javascript:scrollWindow('app_custom_sms.php?sms_task=third&app_id=<?php echo $appid; ?>','500','500')"  class="bb_job file_icon" id="appid_third_<?php echo $appid; ?>"><i class="fa fa-comment-o" aria-hidden="true"></i> SMS LOST</a></li>
    	
    	<li><a href="javascript:scrollWindow('app_custom_sms.php?sms_task=fourth&app_id=<?php echo $appid; ?>','500','500')"  class="bb_job file_icon" id="appid_fourth_<?php echo $appid; ?>"><i class="fa fa-comment-o" aria-hidden="true"></i> SMS1 DOCS </a></li>
    	
    	<li><a href="javascript:scrollWindow('app_custom_sms.php?sms_task=fifth&app_id=<?php echo $appid; ?>','500','500')"  class="bb_job file_icon" id="appid_fifth_<?php echo $appid; ?>"><i class="fa fa-comment-o" aria-hidden="true"></i> SMS 2 DOCS (final) </a></li>
    	
    	<li><a href="javascript:scrollWindow('app_custom_sms.php?sms_task=six&app_id=<?php echo $appid; ?>','500','500')"  class="bb_job file_icon" id="appid_fifth_<?php echo $appid; ?>"><i class="fa fa-comment-o" aria-hidden="true"></i> Follow up SMS </a></li>

   </ul>
   
   <br/> <br/>
   <hr/>
    <div style="margin-top: 49px;">
       <a href="javascript:scrollWindow('app_custom_sms.php?sms_task=cust&app_id=<?php echo $appid; ?>','500','500')"  class="bb_vquote file_icon"><i class="fa fa-comment-o" aria-hidden="true"></i> Cust SMS</a>
    </div>   
  
    <div style="margin-top: 15px;" id="manual_email">
      <!--<a href="javascript:send_sop_email('<?php echo $appid; ?>|<?php echo $appdetails['first_name'] ?>', 639);"  class="bb_vquote file_icon"><i class="fa fa-comment-o" aria-hidden="true"></i> SOP Email</a>-->
      <a href="javascript:scrollWindow('application_emails.php?email_task=sop_email&app_id=<?php echo $appid; ?>','800','600')" class="bb_vquote file_icon"><i class="fa fa-envelope-o"aria-hidden="true"></i> SOP Email</a>
    </div>
	
<br/>

<h4>Application Add Notes</h4>

<div class="form-group">
	<textarea name="comments" id="comments" class="form-control" placeholder="Type a Note Here" onkeypress="return check_press_enter_app(event);" style="width:100%"></textarea>
    <input id="comments_button" name="comments_button" type="button" value="add" onclick="javascript:add_app_comment(document.getElementById('comments'),'<?php echo $appid; ?>')" style="display:none; height:100%; width:100%">
</div>

<div id="quote_notes_comments_div">
	<?php include('application_notes.php'); ?>
</div>

</div>


<span>
    
 
    <style>
        .called_details_app li {
            width: 50%;
            float: left;
            background-color: #cf3620;
            list-style: none;
            margin-top: 6px;
        }
    </style>