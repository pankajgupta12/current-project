               <?php 
			   
			     // echo '<pre>';  print_r($_SESSION['email_folder']);
			       $siteUrl = get_rs_value("siteprefs","site_url",1);
			       
					$getValue = getJobIDByEmail($_SESSION['mail_details']);  
					//$mail_type = get_rs_value("bcic_email","mail_type",$_SESSION['mail_details_id']);	
					//echo $mail_type;
					$getfromemails = mysql_fetch_assoc(mysql_query("SELECT email_from , email_toaddress FROM `bcic_email` WHERE id in (".$_SESSION['mail_details'].") GROUP by email_from LIMIT 0 ,1"));
					
					$getallemals = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(user_email) as useremails FROM `email_config` WHERE status = 0"));
					
					$allemails = $getallemals['useremails'];
					
					if(!in_array($getfromemails['email_from'] , explode(',' , $allemails))) {
						
						$blockemails = $getfromemails['email_from'];
						$bloc_flag = 1;
						
					}else{
						$bloc_flag = 0;
					}
					
					
			   ?>
			   
				<span  onclick="send_data('',6,'quote_view');" class="icoz" ><i class="fa fa-angle-left" aria-hidden="true"></i> Back</span>

				<span class="email_dd"><?php  echo create_dd("priority","system_dd","id","name","type=53","Onchange=\"check_fields_dropdown(this.value,".$_SESSION['mail_details'].",'priority');\"",$getValue); ?></span>

				<span class="email_dd"><?php  echo create_dd("email_assign","system_dd","id","name","type=51","Onchange=\"check_fields_dropdown(this.value,".$_SESSION['mail_details'].",'email_assign');\"",$getValue); ?></span>

				<span class="email_dd"><?php  echo create_dd("admin_id","admin","id","name","is_call_allow = 1 AND status = 1","Onchange=\"check_fields_dropdown(this.value,".$_SESSION['mail_details'].",'admin_id');\"", $getValue, '' , ' order by name ASC');?></span>

				<span class="email_dd"><?php echo create_dd("email_category","system_dd","id","name","type=50","Onchange=\"check_fields_dropdown(this.value,'".$_SESSION['mail_details']."','email_category');\"",$getValue, '' , ' order by name ASC');?></span>
				
		
				<?php  if($getValue['jobid'] > 0) { ?>
				    <a href="vaid:javascript(0);" class="qid-jid">
				      <span  onclick = "javascript:scrollWindow('<?php echo $siteUrl; ?>/admin/popup.php?task=jobs&job_id=<?php echo $getValue['jobid']; ?>','1200','850')"> J#<?php echo  $getValue['jobid']; ?>
					  </span>
					</a>
				<?php   } ?>
				
				<?php  if($getValue['quote_id'] > 0) { ?>
				    <a href="vaid:javascript(0);" class="qid-jid">
				     <span onclick = "send_url('<?php  echo $getValue['quote_id']; ?>');"> Q#<?php echo  $getValue['quote_id']; ?></span> 
					</a>
				<?php   } ?>
				
				<?php  if($_SESSION['email_folder'] == 'INBOX' && $bloc_flag == 1) { ?>
				  <a href="vaid:javascript(0);" class="qid-jid"><span onclick="block_emails('<?php echo $_SESSION['mail_details']; ?>' , '<?php echo $blockemails; ?>', 'quote_view');">Spam </a></span>
				<?php  } ?>
				
			<?php 
				
				$next = ($_SESSION['mail_details_id'] + 1);
				$priv = ($_SESSION['mail_details_id'] - 1);	
				
				//$main_getemailresults = getnext_privids($_SESSION['mail_details_id']);
				
				$next_getemailresults = getnext_privids($next);
				$priv_getemailresults = getnext_privids($priv);
				
			?>
								
				<span style="margin-left: 64px;"><a onClick="email_details('<?php  echo $priv_getemailresults['totalids']; ?>','<?php echo $priv_getemailresults['mail_type'].'/'.$priv; ?>','email_details');" class="next_priv_buttone"><?php// echo $priv; ?>Previous</a> <a  onClick="email_details('<?php  echo $next_getemailresults['totalids']; ?>','<?php echo $next_getemailresults['mail_type'].'/'.$next; ?>','email_details');" class="next_priv_buttone">Next</a></span>
				
			
			<style>
					.qid-jid {
				       padding-left: 16px;
					   cursor: pointer;
					   font-size: 21px;
					}
			</style>
			