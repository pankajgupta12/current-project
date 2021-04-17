<?php

$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mres($_REQUEST['job_id']).""));

if($_REQUEST['step']=="1"){ 	
	if($_POST['subject']==""){
		echo error("Subject cannot be empty");
	}else if($_POST['message']==""){
		echo error("Message cannot be empty");
	}else if($_POST['email']==""){
		echo error("Email cannot be empty");
	}else{
		$_REQUEST['step']="2";	
	}
}

if($_REQUEST['step']=="2"){ 	
	$sites = mysql_fetch_assoc(mysql_query("select * from sites where id=".$quote['site_id']));
	
	$quote_for_option = mysql_fetch_array(mysql_query("select * from quote_for_option where id=".$quote['quote_for'].""));
	
	if($quote['quote_for'] == 1) {
		$domain = $sites['domain'];
	}else if($quote['quote_for'] == 2){
		 $domain = $quote_for_option['site_url'];
	}else if($quote['quote_for'] == 3){
		$domain = $sites['br_domain'];
	}else{
		$domain = $sites['domain'];
	}
	
	//var_dump($quote['name'],$_REQUEST['email'],$_REQUEST['subject'],$_REQUEST['message'],$domain,$quote['site_id'] , $quote['quote_for']);
	
	
	//sendmail($staff['name'],"manish.khanna1@gmail.com","Staff Payment Report ".date("d m Y")." ".$sites['domain'],$str,$sites['email'],$sites['site_id']);
	$_REQUEST['message']  = str_replace("\r\n","<br>",$_REQUEST['message']);
	sendmail($quote['name'],$_REQUEST['email'],$_REQUEST['subject'],$_REQUEST['message'],$domain,$quote['site_id'] , $quote['quote_for']);
	//sendmail($quote['name'],"crystal@bcic.com.au",$_REQUEST['subject'],$_REQUEST['message'],"crystal@bcic.com.au",$quote['site_id']);
	//sendmail($quote['name'],"manish.khanna1@gmail.com",$_REQUEST['subject'],$_REQUEST['message'],"crystal@bcic.com.au",$quote['site_id']);
	add_job_emails($_REQUEST['job_id'],$_REQUEST['subject'],$_REQUEST['message'],$_REQUEST['email']);
	echo error("The Email has been Sent to the Client");
}
?>

<div id="tab-4">
    <?php 
		//if($_SESSION['query[error]'] == 1){ print error($_SESSION['query[txt]']); }else if(!empty($_SESSION['query[txt]'])){ print notify($_SESSION['query[txt]']); }
	?>
    <form name="form1" method="post" action="">
    <div class="job_back_box job_back2">
        <ul class="job_lst job_list2">
            <li>
                <label>Template</label>
                <span>
                <!--<select id="email_type" name="email_type" onChange="javascript:select_email_template(this,'<?php echo $_REQUEST['job_id'];?>');">
                  <option value="0">Select</option>
                  <option value="confirmation">Booking Confirmation to Client</option>
                  <option value="cleaner_details">Send Client Cleaner Details</option>
                </select>-->
				<?php echo create_dd("email_type","email_tpl","id","subject","","class=\"heading_drop\" onchange=\"javascript:select_email_template_data(this,".$_REQUEST['job_id'].");\"",$siteDetails);?>
				 <?php   //echo   create_dd("email_type","email_tpl","id","subject","status = 1 AND","",'',$r); ?> 
                </span>
            </li>
            <li>
            <label>To</label>
            <input name="email" id="email" value="<?php echo $quote['email']?>">
            </li>
            <li>
                <label>Subject:</label>
                <input type="text" name="subject" id="subject" value="">
            </li>
           <li>
           	<label>Message:</label>
            <textarea class="tab_textarea" name="message" id="message"></textarea>
           </li>
        </ul>
        
        <input type="hidden" name="step" id="step" value="1">
        <input type="hidden" name="task" id="task" value="<?php echo $_REQUEST['task'];?>">
        <input type="hidden" name="job_id" id="job_id" value="<?php echo $_REQUEST['job_id'];?>">
        <input type="submit" name="submit" id="submit" class="job_submit" value="send email">
          
    </div>
    </form>
</div>


<script>
  function select_email_template_data(obj,jobid){
	var str = obj.value+"|"+jobid;
	//alert(str);
	send_data(str,569,'message');	
  }
</script>