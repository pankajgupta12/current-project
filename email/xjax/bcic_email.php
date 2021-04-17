<?php

    if($_SESSION['page_limit'] == '')   { $_SESSION['page_limit'] = 10;  }
    if($_SESSION['page_initial'] == '') { $_SESSION['page_initial'] = 0; }

	if($_SESSION['email_folder'] == '' && !isset($_SESSION['email_folder'])) { $_SESSION['email_folder'] = 'INBOX'; }
	$count = '';
    $cond = '';
    $arg = '';
	$arg .= "SELECT * FROM `bcic_email` where  id IN (  select max(id) from bcic_email FORCE INDEX (`mail_serach_index`, `mail_grouping`) where is_delete = 0 AND email_status = '1' ";
	
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
		if($_GET['emails_noti_id'] != '') {
		      $quid = base64_decode($_GET['emails_noti_id']);
		     $arg .= "  AND quote_id =  '".$quid."'";
		}
	
	// Searching By search text Box Subject + body + from + to + job id + quote + staff + email client  +agent email 
	if($_SESSION['email_search_value'] != '') {
		 $arg .= "  AND (id like  '%".$_SESSION['email_search_value']."%' OR email_subject like  '%".$_SESSION['email_search_value']."%' OR email_body like  '%".$_SESSION['email_search_value']."%' OR  email_from like  '%".$_SESSION['email_search_value']."%' OR  email_toaddress like  '%".$_SESSION['email_search_value']."%' OR job_id like  '%".$_SESSION['email_search_value']."%' OR quote_id like  '%".$_SESSION['email_search_value']."%' OR staff_id like  '%".$_SESSION['email_search_value']."%' OR client_email_id like  '%".$_SESSION['email_search_value']."%' OR real_agent_email_id like  '%".$_SESSION['email_search_value']."%') "; 
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
	
	//$count .= $arg;
	
	//set scroll length
	if( isset( $emailTrCount ) && $emailTrCount > 0 ) {
		$arg .= " Limit  "; 
		$arg .= $emailTrCount . " , 50"; 
	} else {
		$arg .= " Limit 0, 50 "; 
	}
		
	
	//$arg .= " Limit  "; 
	//$arg .= $_SESSION['page_initial'].", ".$_SESSION['page_limit']; 
	
	//echo $arg;
	
	$getEmailData = mysql_query($arg);
	$countResult = mysql_num_rows($getEmailData);
	
	//$totalcount = getTotalRecordofEmail($count);
	
?>
	<div class="emailTemp container" id="" style="width:100%">
		<div class="row">
			<div class="col-md-2">
			   <h3>BCIC Email</h3>
			</div>	
			<div class="col-md-10">
			<div class="row">
			
			
				<div class="infoSec">
				        <?php 
							if(empty($_SESSION['mail_details'])) {
								 include ('email_heder.php');
							}else {
							   //if(!empty($_SESSION['forward_email'])) {
					    ?>
					    
						<!--<span onclick="send_data('',8,'quote_view');" class="icoz" ><i class="fa fa-angle-left" aria-hidden="true"></i> Back</span>-->
					   
						<?php // } else {
							
							include('mail_list_dropdown.php');
							} //} 
						?>
				</div>
				</div>
			</div>
		</div>
    <hr class="hrNew">
		<div class="row">
			    <div class="col-md-2 email_left_panel_box">
				
					    <!--<span class="firstSelect1">		   
			              <?php echo create_dd("sent_new_msg_type","email_config","email_type","email_type","","Onchange=\"check_mail_type(this.value,'sent_new_msg_type');\"", $_SESSION);?>
					    </span>-->
						
						<hr  class="hrNew">
							<div id="mail_folderName">	
								<?php  include('email_left_panel.php'); ?>
							</div>
				</div>
	
			<div class="col-md-10 email_right_panel_box">
				<?php  
				    if(empty($_SESSION['mail_details'])) { 
				
						   if(!empty($_SESSION['new_message']) && $_SESSION['new_message'] == 'new_message') {
						   ?>
							<div id="forward_new_email_div">			
							   <?php  include('forward_new_email.php'); ?>
							</div>
						<?php   } else { ?>
					   <!-- Nav tabs -->
							<ul class="nav nav-tabs">
							
								<!--<li <?php if($_SESSION['bcic_email']['mail_type'] == '') { ?>class="active" <?php  } ?>><a onClick="getemail_type('',1,'quote_view');"  data-toggle="tab"><span class="glyphicon glyphicon-inbox">
								</span>ALL</a></li>-->
								
								<li <?php if($_SESSION['bcic_email']['category_type'] == '') { ?>class="active" <?php  } ?>><a onClick="getcategory_type('',1,'quote_view');"  data-toggle="tab"><span class="glyphicon glyphicon-inbox">
								</span>ALL</a></li>
						
								<!--<?php    foreach(getEmailConfig() as $key=>$value) {  ?>
							
								<li <?php if($_SESSION['bcic_email']['mail_type'] == $value['email_type']) { ?> class="active" <?php  } ?> ><a onClick="getemail_type('<?php echo $value['email_type']; ?>',1,'quote_view');" data-toggle="tab"><span class="glyphicon glyphicon-user"></span>
									<?php echo $value['name']; ?></a>
								</li>
								<?php  } ?>-->
								
								<?php foreach(setEmailTabbing() as $key=>$value) {  ?>
							
								<li <?php if($_SESSION['bcic_email']['email_category'] == $value['id']) { ?> class="active" <?php  } ?> ><a onClick="getcategory_type('<?php echo $value['id']; ?>',1,'quote_view');" data-toggle="tab"><span class="glyphicon glyphicon-user"></span>
									<?php echo $value['name']; ?></a>
								</li>
								<?php  } ?>
								
							</ul>
					
						<?php
						 // Email Listing file
						  include ('mail_list.php'); 
						}
					} else
					{ 
			  
					if($_SESSION['get_mail_type'] == 'reclean_email') {	
						// Email Reply 
								include('reclean_create_email.php'); 
							
					}elseif($_SESSION['get_mail_type'] == 'reclean_email_reply') {	
						// reclean Reply 
						    include('reclean_email_reply.php'); 
							
					}elseif($_SESSION['get_mail_type'] == 'complaint_email_reply') {	
						// complaint Reply 
								include('complaint_email_reply.php'); 
							
					}elseif($_SESSION['get_mail_type'] == 'reply_mail') {	
						// Email Reply 
								include('email_reply.php'); 
							
					}elseif($_SESSION['get_mail_type'] == 'forward_email') {	
						
						$forwardEmail =  $_SESSION['forward_email'];
				?>
						<div id="forward_email_div">
											 
							<?php 
							// Forward Email file
							include('forword_email.php'); 
							
							?>
						</div>
				<?php 	
					}elseif($_SESSION['mail_details'] != '') {
                    //echo "sdhsds";						

						   
					//$getemaildetails = mysql_query("SELECT *  FROM `bcic_email` WHERE `id` IN (".$_SESSION['mail_details'].") order by FIELD (id, ".$_SESSION['mail_details'].")  Desc");
						$getemaildetails = mysql_query("SELECT *  FROM `bcic_email` WHERE `id` IN (".$_SESSION['mail_details'].") order by id Desc");
						$k = 0;
					while($emaildetails = mysql_fetch_assoc($getemaildetails)) {
						
				    ?>

							<div class="animated fadeInRight" id="email_details_parts">
						
							<div class="mail-box-header">
								<div class="toolTipx pull-right tooltip-demo" >
								    
								   <?php  if($updateemail == $emaildetails['id'] ) {
								     $message = '<span style="color:red;font-weight:600;">Re-Checked</span>';
								    // unset($updateemail);
								    } else{
								        $message = 'Re-Check';
								    }
								    ?>
								
								<?php   if($emaildetails['job_id'] != 0) { ?>
								
								<a href="javascript:void(0);" onClick="send_data('<?php echo $emaildetails['id']; ?>|<?php echo $emaildetails['job_id']; ?>|<?php echo  $emaildetails['mail_type']; ?>','51','quote_view');" class="btn btn-white btn-sm bc_click_btn"  data-toggle="tooltip" data-placement="top" title="Reply" style="border: 1px solid;margin: 6px;"> Re-Clean Create </a>
								
								<a href="javascript:void(0);" onClick="send_data('<?php echo $emaildetails['id']; ?>|<?php echo $emaildetails['job_id']; ?>|<?php echo  $emaildetails['mail_type']; ?>','54','quote_view');" class="btn btn-white btn-sm bc_click_btn"  data-toggle="tooltip" data-placement="top" title="Reply" style="border: 1px solid;margin: 6px;"> Reclean Reply</a>
								
								<a href="javascript:void(0);" onClick="send_data('<?php echo $emaildetails['id']; ?>|<?php echo $emaildetails['job_id']; ?>|<?php echo  $emaildetails['mail_type']; ?>','53','quote_view');" class="btn btn-white btn-sm bc_click_btn"  data-toggle="tooltip" data-placement="top" title="Reply" style="border: 1px solid;margin: 6px;">Complaint Reply</a>
								
								<?php  }  ?>
								
								  	<a onClick="return send_data('<?php echo $emaildetails['id']; ?>|<?php echo  $emaildetails['mail_type']; ?>' , '25' , 'quote_view');" style="padding:10px;" ><span id="recheck_email_<?php echo $emaildetails['id']; ?>" class="recheck_email"><?php echo $message; ?></span></a>
								
									<a href="javascript:void(0);" onClick="add_emails_notes('<?php echo $emaildetails['id']; ?>','<?php echo $emaildetails['mail_type']; ?>');" class="btn btn-white btn-sm bc_click_btn"  data-toggle="tooltip" data-placement="top" title="Reply"><i class="fa fa-edit"></i> Add Notes</a>
									

									<a class="btn btn-sm btn-white" href="javascript:void(0);" onClick="send_data('<?php echo $emaildetails['id']; ?>|<?php echo  $emaildetails['mail_type']; ?>','17','quote_view');" ><i class="fa fa-reply"></i> Reply</a>
									 
									 <a class="btn btn-sm btn-white" href="javascript:void(0);" onclick="send_data('<?php echo $emaildetails['id']; ?>|<?php echo  $emaildetails['mail_type']; ?>','7','quote_view');"><i class="fa fa-arrow-right"></i> Forward</a>
									 
									<!--<a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </a>-->
									
								</div>
								<!--<h2>
									View Message
								</h2>-->
								<?php $lastActivity =   checkLastActivity($emaildetails['id']); ?>
								<div class="mailTop" id="hederpart">
								
									<div class="mailHead" onclick="showmaildiv('mail_heading<?php echo $emaildetails['id']; ?>')">
										<h3>
											<span class="font-normal" title="<?php echo  $lastActivity['mailtype']; ?>"><?php echo  $lastActivity['lastmailtype']; ?> Subject: </span><?php echo $emaildetails['email_subject'] ?>.
										</h3>
									</div>
									<div class="mailHeadNew mail_heading<?php echo $emaildetails['id']; ?>" <?php if($k != 0) { ?> style="display:none;" <?php } ?>>
									<h5>

										<span class="dateSec pull-right font-normal"><?php echo changeDateFormate($emaildetails['email_date'],'timestamp'); ?></span>
										<span class="font-normal">From: </span><?php echo $emaildetails['email_from']; ?><br/>
										<span class="font-normal">To: </span><?php echo htmlentities($emaildetails['email_toaddress']); ?>
									</h5>
									</div>
								</div>
							</div>
								<div class="mail-box mail_heading<?php echo $emaildetails['id']; ?>" <?php if($k != 0) { ?> style="display:none;" <?php  } ?>>

									<div class="mail-body mail-body-space">
										 <?php   echo  removeStripslashes($emaildetails['email_body']); ?>
									</div>
											 
										<?php   
										// Email attachment File
											 include('email_attachment.php');  
											
										?> 
								</div>
							</div>
				
				<?php $k++;  
				    } 
				    }} ?>
			</div>
			
				<div id="emails_notes">
						<?php 
				     	 include 'bcic_emails_notes.php';
						?>
				</div>		
				
				<script>
						$('.black_screen1').click(function(e){
							
							$('#emails_notes').removeClass('toggle');
							$('#quote_view').removeClass('parentDisable');
							$('.black_screen1').fadeOut(700);	
							
						}); 
						
				       function uncheck(){}
				</script>
			
		</div>
    </div>
    