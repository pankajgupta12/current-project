
<span style="text-align:left;">
<? $quote = mysql_fetch_array(mysql_query("select site_id, id, login_id, quote_for , booking_id ,  reply_status , name,email,phone,step,amount,inv_sms_date ,inv_email_date , quote_for from quote_new where id=".mres($quote_id).""));

    $siteDetails = mysql_fetch_array(mysql_query("Select * from sites where id = ".$quote['site_id'].""));
    $checkQUotetype = mysql_fetch_assoc(mysql_query("select job_type_id from quote_details where quote_id=".mysql_real_escape_string($quote_id)." AND job_type_id = 11"));  
	$area_code = '';
	if($checkQUotetype['job_type_id'] == 11) { 
			$site_logo =   $siteDetails['br_logo'];	
			$site_url =   $siteDetails['br_domain'];	
			$show_br_button = false;
			$area_code = $siteDetails['br_area_code'];

	} else{
		 if($quote['quote_for'] == 2 || $quote['quote_for'] == 4) {
			 
				//$newlogo = get_rs_value("siteprefs","bcic_new_logo",1);
				 
			$siteUrl1  = Site_url;
			$logo_name =  get_rs_value('quote_for_option' ,'logo_name',$quote['quote_for']);
			$site_logo =   $siteUrl1.'/'.$logo_name;
		 }else {
			$site_logo =   $siteDetails['logo'];
			$show_br_button = true;
			$area_code = $siteDetails['area_code'].$quote['quote_for'];
			$site_url =   $siteDetails['domain'];	
		 }
	}

	//print_r($siteDetails);
	
	if($quote['site_id'] > 0) {
		echo '<hr>';
		echo  '<a href="'.$site_url.'" target="_blank"><img src='.$site_logo.' style="padding: 16px;width: 200px;"></a><br/>';
		
		echo 'Site Phone No: <a href="tel:'.$siteDetails['phone'].'">'.$siteDetails['site_phone_number'].'</a><br />';
	}
	
	echo '<hr>';
	echo '<br/>';
	echo 'Quote id:'.$quote_id.'<br />
	'.$quote['name'].'<br />
	<a href="mailto:'.$quote['email'].'">'.$quote['email'].'</a><br />
	<a href="tel:'.$area_code.$quote['phone'].'">'.$quote['phone'].'</a><br />';  
	
?>
</span>
<div class="modal-content">

<a href="javascript:scrollWindow('email_quote.php?quote_id=<?=$quote_id;?>','1200','850');" class="bb_vquote file_icon"><i class="fa fa-file-o" aria-hidden="true"></i> View Quote</a>

<a href="javascript:custom_data('<?=$quote_id;?>',27,'__email_quote_div_<?=$quote_id;?>')" class="bb_quote file_icon" id="__email_quote_div_<?=$quote_id;?>"><i class="fa fa-envelope-o" aria-hidden="true"></i> Email Quote</a>

<? if($quote['step'] == 1 || $quote['step'] == 2 || $quote['step'] == 3  || $quote['step'] == 9 || $quote['step'] == 8 ){ ?>
<a href="/admin/index.php?task=edit_quote&quote_id=<?=$quote_id;?>" class="bb_edit file_icon"><i class="fa fa-pencil" aria-hidden="true"></i> Book / Edit Quote</a>
<? } ?>

<!--<a href="javascript:send_data('<?=$quote_id;?>',8,'quote_job_<?=$quote_id;?>');" class="bb_convert file_icon" id="quote_job_<?=$quote_id;?>"><i class="fa fa-mail-forward" aria-hidden="true"></i> Convert to Job</a>-->
<?php /*?><a href="javascript:delete_quote('<?=$quote_id;?>');" class="bb_delete">Delete Quote</a><?php */?>

<a href="javascript:custom_data('<?=$quote_id;?>',445,'quote_sms_<?=$quote_id;?>');" class="bb_sms file_icon" id="quote_sms_<?=$quote_id;?>"><i class="fa fa-comment" aria-hidden="true"></i> SMS Quote</a>

<!-- SEND CUSTOM MESSAGE - ADDED ON 9 AUG 2017 -->
<a href="javascript:scrollWindow('custom_sms.php?quote_id=<?=$quote_id;?>','300','300');" class="bb_sms file_icon" id="custom_sms_<?=$quote_id;?>"><i class="fa fa-comment" aria-hidden="true"></i> Send Custom SMS</a>

<?php  if($quote['step'] == '2' && $quote['amount'] != "" && $quote['amount'] != "0") { ?>
<a href="javascript:custom_data('<?=$quote_id.'|'.$quote['step'];?>',446,'quote_approved_<?=$quote_id;?>');" class="bb_approved file_icon" id="quote_approved_<?=$quote_id;?>"><i class="fa fa-check" aria-hidden="true"></i> Quote Approved </a>

<?php }  if($quote['step'] == '1' && $show_br_button == true) { ?>

  <a href="javascript:send_data('<?=$quote_id;?>|sms',447,'quote_incomplete_<?=$quote_id;?>');" id="quote_incomplete_<?=$quote_id;?>" class="bb_incomplete file_icon" ><i class="fa fa-envelope-o" aria-hidden="true"></i> Send Incomplete SMS </a>
 
  <a href="javascript:send_data('<?=$quote_id;?>|email',447,'quote_incomplete_email_<?=$quote_id;?>');" id="quote_incomplete_email_<?=$quote_id;?>" class="bb_sms file_icon" ><i class="fa fa-envelope-o" aria-hidden="true"></i> Send Incomplete Email </a>
  
<? } ?>

<ul class="called_details">

	<li><a href="javascript:custom_data('<?=$quote_id;?>|called',44,'quote_called_<?=$quote_id;?>');" class="bb_job file_icon" id="quote_called_<?=$quote_id;?>"><i class="fa fa-phone" aria-hidden="true"></i> Ist</a></li>

	<li><a href ="javascript:custom_data('<?=$quote_id;?>|second_called',44,'second_quote_called_<?=$quote_id;?>');" class="bb_job file_icon" id="second_quote_called_<?=$quote_id;?>"><i class="fa fa-phone" aria-hidden="true"></i> 2nd</a></li>

	<li><a href ="javascript:custom_data('<?=$quote_id;?>|seven_called',44,'seven_quote_called_<?=$quote_id;?>');"  class="bb_job file_icon" id="seven_quote_called_<?=$quote_id;?>"><i class="fa fa-phone" aria-hidden="true"></i> 3rd</a></li>

</ul>

  <?php  if(in_array($quote['step'] , array(1,2,3))) {
	 
   if($quote['reply_status'] == 0 && $quote['booking_id'] == 0) { ?>

	<a href="javascript:send_data('<?=$quote_id;?>|email',537,'stop_sms_email_<?=$quote_id;?>');" id="stop_sms_email_<?=$quote_id;?>"  class="bb_sms file_icon" style="margin-top: 45px;">
		<i class="fa fa-file-o" aria-hidden="true"></i> Stop Sale SMS
	</a>
  <?php }  } ?>
	
	<?php  
	
 	$siteDetails = mysql_fetch_array(mysql_query("Select * from sales_system where quote_id = ".$quote_id.""));
	 
	if($quote['booking_id'] == 0 && !empty($siteDetails)) {
	?>
        <br/>
	  <div><b>Task For </b>  
	  <?php 
	  
	   $admin_name = get_rs_value("admin","name",$siteDetails['task_manage_id']);  
	  if($siteDetails['task_manage_id'] == $_SESSION['admin']) {  
	  
	  echo  $admin_name;
	  ?>

	  <span><?php echo create_dd("stages","system_dd","id","name","type = 103","class=\"heading_drop\" onchange=\"javascript:edit_field(this,'sales_system.stages',".$siteDetails['id'].");\"",$siteDetails);?></span> 
	  <?php  } else { ?>
	  <?php  echo  $admin_name;  ?>  
	  <?php  } ?>
	  </div> 

        <p></p>	  
	<?php  }   ?>
	
			<a href="javascript:getQuoteQuestionNotes();" style="margin-top: 5px;" class="bb_vquote file_icon">
				<i class="fa fa-file-o" aria-hidden="true"></i> Quote Questions
			</a>


<? //if(in_array($_SESSION['admin'] , array(3,17,12))) { ?>
<a href="javascript:scrollWindow('admin_fault.php?quote_id=<?=$quote_id;?>','500','500');" class="bb_sms file_icon" id="admin_fault_<?=$quote_id;?>"><i class="fa fa-comment" aria-hidden="true"></i> Add Admin fault</a>
<?// } ?>

<? if(in_array($_SESSION['admin'] , array(1,3,17))) { ?>
<span> Quote Assign to </span><br/><span style="margin-left: -87px;"><?php echo create_dd("login_id","admin","id","name","is_call_allow = 1 AND status = 1","class=\"heading_drop\" onchange=\"javascript:edit_field(this,'quote_new.login_id',".$quote['id'].");\"",$quote);?></span>
<? } ?>

<!--<ul class="called_details">

	<li style="width: 93px;" title="<?php echo $quote['inv_email_date']; ?>"><a href="javascript:send_data('<?=$quote_id;?>',503,'inventory_email_message<?=$quote_id;?>');" class="bb_job file_icon" style="background: #625680;">Invt Email</a></li>

	<li style="width: 93px;" title="<?php echo $quote['inv_sms_date']; ?>"><a href ="javascript:custom_data('<?=$quote_id;?>',504,'inventory_email_message<?=$quote_id;?>');" class="bb_job file_icon" style="background: #625680;" >Invt SMS</a></li>
</ul>-->
<span id="inventory_email_message<?=$quote_id;?>" style="font-size: 12px;white-space:  nowrap;margin-left: -112px;"></span>

<div id="quote_questions_notes" style="display:none;">
<?php 
$quote_type = 1;
include("quote_question_notes.php"); 
?>
</div>

<div id="q_notes_content">
<?
 include("quote_notes.php"); 
 
?>
<style>
  .called_details {
    list-style-type: none;
   
}
 .called_details li {
    float: left;
}

#quote_notes_div {
    display: inline-block;
}
</style>
</div>
</div>