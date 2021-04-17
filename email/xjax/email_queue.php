<?php
if($_SESSION['email_folder'] == '' && !isset($_SESSION['email_folder'])) { $_SESSION['email_folder'] = 'INBOX'; }
	$count = '';
    $cond = '';
    $arg = '';
	$arg .= "SELECT * FROM `bcic_email` where 1 = 1  AND id IN (  select max(id) from bcic_email  where 1 = 1  ";
	
	//inbox  + //sent
	 if($_SESSION['email_folder'] != '') {

       $arg .=" AND folder_type = '".$_SESSION['email_folder']."' "; 
	 }
	 
	 $arg .=" AND email_status = '1'";  // For 1=> Active / 0=> Deactivate
	 // Drop-down searching
	 
	if(!empty($_SESSION['bcic_email'])) {
		foreach($_SESSION['bcic_email'] as $key=>$value) {
			if($value != '' && $value != '0') {
			    $arg .= "  AND $key = '".$value."' "; 			
			}			
		}
	}
		
		
		//print_r($_SESSION['bcic_email']);
	
	// Searching By search text Box Subject + body + from + to + job id + quote + staff + email client  +agent email 
	if($_SESSION['email_search_value'] != '') {
		 $arg .= "  AND (email_subject like  '%".$_SESSION['email_search_value']."%' OR email_body like  '%".$_SESSION['email_search_value']."%' OR  email_from like  '%".$_SESSION['email_search_value']."%' OR  email_toaddress like  '%".$_SESSION['email_search_value']."%' OR job_id like  '%".$_SESSION['email_search_value']."%' OR quote_id like  '%".$_SESSION['email_search_value']."%' OR staff_id like  '%".$_SESSION['email_search_value']."%' OR client_email_id like  '%".$_SESSION['email_search_value']."%' OR real_agent_email_id like  '%".$_SESSION['email_search_value']."%') "; 
	}
	
	/* if($_SESSION['bcic_email']['mail_type'] != '') {
	  //echo getEmailIDbyemailtype($_SESSION['bcic_email']['mail_type']);	
	      $arg .= "  OR move_to = ".getEmailIDbyemailtype($_SESSION['bcic_email']['mail_type'])."";	
	} */
	 
	if($_SESSION['bcic_email']['mail_type'] != '') {
	  //echo getEmailIDbyemailtype($_SESSION['bcic_email']['mail_type']);	
	  //$arg .= "  OR move_to = ".getEmailIDbyemailtype($_SESSION['bcic_email']['mail_type'])."";	
	}
	
	$arg .= " GROUP by email_from , email_subject_reference Order by id desc";
	
	$arg .= "  ) order by id desc" ;	
	$count .= $arg;
	
	//set scroll length
	if( isset( $emailTrCount ) && $emailTrCount > 0 ) {
		$arg .= " Limit  "; 
		$arg .= $emailTrCount . " , 50"; 
	} else {
		$arg .= " Limit 0, 50 "; 
	}
	
	//echo $arg;
	
	$getEmailData = mysql_query($arg);
	$countResult = mysql_num_rows($getEmailData);	
	$totalcount = getTotalRecordofEmail($count);
?>
<?php  if($countResult > 0) { 

		while($getAlldata = mysql_fetch_assoc($getEmailData)) {
			
		 /*  $getallCOuntid['totalid']  =  getTotamailIds($_SESSION['bcic_email']['mail_type'] , $getAlldata);
	   
		$getjobCount = getJobIDByEmail($getallCOuntid['totalid']);
		
		$lastActivity =   checkLastActivity($getallCOuntid['totalid']); */
		
		$getType = getactiveEmailid($getAlldata['mail_type']);
		// print_r($getType);  
		// echo $_SESSION['email_folder'];   
		$getidSql = mysql_query("SELECT   GROUP_CONCAT(id) as totalid  FROM `bcic_email` WHERE ((email_from = '".$getAlldata['email_from']."' AND email_subject_reference = '".$getAlldata['email_subject_reference']."') OR email_reply_to = '".$getType	['user_email']."' AND email_subject_reference = '".$getAlldata['email_subject_reference']."') AND mail_type = '".$getAlldata['mail_type']."' Order By email_date desc");

		$getallCOuntid = mysql_fetch_assoc($getidSql);

		$getjobCount = getJobIDByEmail($getallCOuntid['totalid']);
		
	?>
	<tr <?php if($getAlldata['email_assign'] == '1' && $getAlldata['is_error_occurred'] == '1') { ?> style="font-weight:600; background: #ecdada;" <?php  } elseif($getAlldata['is_error_occurred'] == '1') { ?>  style="background: #ecdada;" <?php }else if($getAlldata['email_assign'] == '1') { ?> style="font-weight:600;" <?php   } ?> >	
		
		<!-- File Attachment -->	
		<?php  //echo  CheckAttachMent($getAlldata['id'],$getAlldata['mail_type']);
			$getAttchment = mysql_query("SELECT *  FROM `bcic_email_attach` WHERE email_id = ".$getAlldata['id']." AND mail_type = '".$getAlldata['mail_type']."'");
			$countresult = mysql_num_rows($getAttchment);						
		?>
		<td onClick="email_details('<?php  echo $getallCOuntid['totalid']; ;?>','<?php echo $getAlldata['mail_type']; ?>','email_details');"><?php echo $getAlldata['id']; ?><?php if($countresult > 0) {  ?><span class="filex glyphicon glyphicon-paperclip"></span><?php  } ?></td>
		
		<!-- Date / Time -->
		<td onClick="email_details('<?php  echo $getallCOuntid['totalid']; ;?>','<?php echo $getAlldata['mail_type']; ?>','email_details');" title="<?php echo  date('dS M Y h:i:s' , strtotime($getAlldata['email_date'])); ?>">
						<?php echo date('dS M Y h:i:sa' , strtotime($getAlldata['email_date'])); ?></td>
		
		
		<!--<td title="<?php echo  $lastActivity['mailtype']; ?>"><?php echo  $lastActivity['lastmailtype']; ?></td>-->
		
		<td onClick="email_details('<?php  echo $getallCOuntid['totalid']; ;?>','<?php echo $getAlldata['mail_type']; ?>','email_details');" <?php if($getAlldata['email_assign'] == '1') { echo "text_un_mark"; }else { echo 'text_mark'; }  ?> >
		<?php 
			if( $getAlldata['email_senderaddress'] == $getAlldata['email_sender'] ) {
				echo $getAlldata['email_senderaddress'];
			} else {
				echo $getAlldata['email_senderaddress'];
				echo "<br />";
				echo $getAlldata['email_sender'];
			}
		?>
		<?php if($getjobCount['totalReco'] > 1) { echo '('.$getjobCount['totalReco'].')';  }?></td>

		<td title="<?php echo  $getAlldata['email_subject'];  ?>" onClick="email_details('<?php  echo $getallCOuntid['totalid']; ;?>','<?php echo $getAlldata['mail_type']; ?>','email_details');"><?php if($getAlldata['email_subject'] != '') { echo substr($getAlldata['email_subject'], 0,25); }else {} ?></td>

		<td>
			<?php if($getjobCount['jobid'] > 0) {  echo  $getjobCount['jobid']; ?>
				 <a href="javascript:void(0);" id="job_icon_<?php echo  $getAlldata['id']; ?>" onClick="send_data('<?php echo  $getallCOuntid['totalid']; ?>|job_id' , 23 ,'quote_view');"><i style="margin-left: -10px !important;" class="glyphicon glyphicon-remove-sign"></i></a>
			 <?php  }else { ?>
		 
			   <input type="text" id="job_id_<?php echo  $getAlldata['id']; ?>" style="width: 60%;" onblur="javascript:text_edit_fields(this.value,'bcic_email.job_id','<?php echo  $getallCOuntid['totalid']; ?>','job_id_<?php echo  $getAlldata['id']; ?>');" />
			
			<?php  } ?>
			
		</td>
		
		<td>
		
		<?php if($getjobCount['quote_id'] > 0) {  echo  $getjobCount['quote_id']; ?>
			 <a href="javascript:void(0);" id="quote_icon_<?php echo  $getAlldata['id']; ?>" onClick="send_data('<?php echo  $getallCOuntid['totalid']; ?>|quote_id' , 23 ,'quote_view');"><i style="margin-left: -10px;" class="glyphicon glyphicon-remove-sign"></i></a>							 
		<?php  }else { ?>
		
			<input type="text" id="quote_id_<?php echo  $getAlldata['id']; ?>" style="width: 60%;" onblur="javascript:text_edit_fields(this.value,'bcic_email.quote_id','<?php echo  $getallCOuntid['totalid']; ?>','quote_id_<?php echo  $getAlldata['id']; ?>');"    value="" />
			
		<?php  } ?>
			  
		</td>
		
		<!--<td> <?php echo create_dd("move_to","email_config","id","email_type","status = 1","Onchange=\"check_fields_dropdown(this.value,'".$getallCOuntid['totalid']."','move_to');\"", $getjobCount);?></td>-->
		
		<!-- Email Category -->
		<td> <?php echo create_dd("email_category","system_dd","id","name","type=50","Onchange=\"check_fields_dropdown(this.value,'".$getallCOuntid['totalid']."','email_category');\"",$getjobCount, '' , ' order by name ASC');?>    </td>
		
		<!-- Admin List -->
		<td> <?php echo create_dd("admin_id","admin","id","name","is_call_allow = 1 and status = 1","Onchange=\"check_fields_dropdown(this.value,'".$getallCOuntid['totalid']."','admin_id');\"", $getjobCount, '' , ' order by name ASC');?></td>
		
		<!-- Priority -->
		<td><?php  echo create_dd("priority","system_dd","id","name","type=53","Onchange=\"check_fields_dropdown(this.value,'".$getallCOuntid['totalid']."','priority');\"",$getjobCount);?>   </td>
		
		<!-- Email Status -->
		<td><?php  echo create_dd("email_assign","system_dd","id","name","type=51","Onchange=\"check_fields_dropdown(this.value,'".$getallCOuntid['totalid']."','email_assign');\"",$getjobCount);?>   </td>
		
		
		

		<?php  if($_SESSION['bcic_email']['mail_type'] == '') { ?>  
		<td><?php echo ucfirst($getAlldata['mail_type']); ?></td>
		<?php  }else {  ?>
		<td></td>
		<?php  } ?>
		
	
		
	</tr>
	<?php  }}else { ?>		
	<!--<tr>	
	 <td>This tab is empty. </td>	
	</tr> -->
	<?php  } ?>