    <style>
		.tableResponsive {
			width: 100%;
			max-width: 100%;
			margin-bottom: 20px;
			overflow-y: auto;
			height: 630px;
			display: inline-block;
			overflow-x: hidden;
			background-color:#fff;
		}
		
		.tableResponsive tr:nth-child(even) {background: #efefef;}
		.tableResponsive tr:nth-child(odd) {background: #FFF}


	</style>	
	<div class="dataHeaderTable">
							
			<table id = "tableResponsive" class="table-scroll table table-striped table-inverse tableResponsive">
				<thead class="thr">
					<tr>
						
						<th>File</th>
						<th>Date</th>
						<th>Name</th>
						<th>Subject</th>
						<th>Job</th>
						<th>Quote</th>
						<th>Category</th>
						<th>User</th>
						<th>Priority</th>
						<th>Status</th>
						<?php  if($_SESSION['bcic_email']['category_type'] == '') { ?> 
						<th>Type</th>
						<?php }else {?>
						<th></th>
						<?php } ?>
					 
					</tr>
				</thead>
						  
				<thead class="all-mail-list">
					<?php 
					
					 $getallemailType = getactiveEmailiddata();
					if($countResult > 0) { 
						while($getAlldata = mysql_fetch_assoc($getEmailData)) {
						
							$user_email = $getallemailType[$getAlldata['mail_type']];
							
						$arginlinesql =	"
							SELECT 
								GROUP_CONCAT(id) as totalid  
							FROM 
								`bcic_email` 
							WHERE 
							(
									(email_from = '".$getAlldata['email_from']."' AND email_subject_reference = '".mysql_real_escape_string($getAlldata['email_subject_reference'])."') 
								OR 
									email_reply_to = '".$user_email."' AND email_subject_reference = '".mysql_real_escape_string($getAlldata['email_subject_reference'])."') AND mail_type = '".$getAlldata['mail_type']."' AND is_delete = 0 Order By email_date desc"
							;
							
							
							
							$getidSql = mysql_query($arginlinesql);
							$getallCOuntid = mysql_fetch_assoc($getidSql);
							
							$getjobCount = getJobIDByEmail($getallCOuntid['totalid']);
						
						?>
					<tr <?php if($getAlldata['email_assign'] == '1' && $getAlldata['is_error_occurred'] == '1') { ?> style="font-weight:600; background: #ecdada;" <?php  } else if($getAlldata['is_error_occurred'] == '1') { ?>  style="background: #ecdada;" <?php  }else if($getAlldata['email_assign'] == '1') { ?> style="font-weight:600;background :#ffa19e;" <?php   } ?> >	
						
						<!-- File Attachment -->	
						<?php  
							$getAttchment = mysql_query("SELECT *  FROM `bcic_email_attach` WHERE email_id = ".$getAlldata['id']." AND mail_type = '".$getAlldata['mail_type']."'");
							$countresult = mysql_num_rows($getAttchment);						
						?>
						<td onClick="email_details('<?php  echo $getallCOuntid['totalid']; ;?>','<?php echo $getAlldata['mail_type'].'/'.$getAlldata['id']; ?>','email_details');"><?php echo $getAlldata['id']; ?><?php if($countresult > 0) {  ?><span class="filex glyphicon glyphicon-paperclip"></span><?php  } ?></td>
						
						<!-- Date / Time 
						<td title="<?php echo  date('dS M Y h:i:s' , strtotime($getAlldata['email_date'])); ?>"><?php echo date('dS M',strtotime($getAlldata['email_date']));   ?></td>-->
						
						<td onClick="email_details('<?php  echo $getallCOuntid['totalid']; ;?>','<?php echo $getAlldata['mail_type'].'/'.$getAlldata['id']; ?>','email_details');" title="<?php echo  date('dS M Y h:i:s' , strtotime($getAlldata['email_date'])); ?>">
						<?php echo date('dS M Y h:i:s a' , strtotime($getAlldata['email_date'])); ?></td>
						
						<!--<td title="<?php echo  $lastActivity['mailtype']; ?>"><?php echo  $lastActivity['lastmailtype']; ?></td>-->
						
						<td onClick="email_details('<?php  echo $getallCOuntid['totalid']; ;?>','<?php echo $getAlldata['mail_type'].'/'.$getAlldata['id']; ?>','email_details');" <?php if($getAlldata['email_assign'] == '1') { echo "text_un_mark"; }else { echo 'text_mark'; }  ?> > 
						
						<?php 
							if( $getAlldata['email_senderaddress'] == $getAlldata['email_sender'] ) {
							    //	print_r($getAlldata);
								echo $getAlldata['email_toaddress'];
							} else {								
								if(strstr($getAlldata['email_senderaddress'], $getAlldata['email_sender']) == true){
									echo $getAlldata['email_senderaddress'];
								} else {
									echo $getAlldata['email_senderaddress'];
									echo "<br />";
									echo $getAlldata['email_sender'];
								}
							}
						?>
						
						<?php if($getjobCount['totalReco'] > 1) { echo '('.$getjobCount['totalReco'].')';  }?></td>

						<td title="<?php echo  $getAlldata['email_subject'];  ?>" onClick="email_details('<?php  echo $getallCOuntid['totalid']; ;?>','<?php echo $getAlldata['mail_type'].'/'.$getAlldata['id']; ?>','email_details');"><?php if($getAlldata['email_subject'] != '') { echo substr($getAlldata['email_subject'], 0,25); }else {} ?></td>

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
							
								<input type="text" id="quote_id_<?php echo  $getAlldata['id']; ?>" style="width: 60%;" onblur="javascript:text_edit_fields(this.value,'bcic_email.quote_id','<?php echo  $getallCOuntid['totalid']; ?>','quote_id_<?php echo  $getAlldata['id']; ?>');" value="" />
								
							<?php  } ?>
							  
						</td>
					
						
						<td> <?php echo create_dd("email_category","system_dd","id","name","type=50","Onchange=\"check_fields_dropdown(this.value,'".$getAlldata['id']."','email_category');\"",$getAlldata, '' , ' order by name ASC');?></td>						
				
						<td> <?php echo create_dd("admin_id","admin","id","name","is_call_allow = 1 and status = 1","Onchange=\"check_fields_dropdown(this.value,'".$getAlldata['id']."','admin_id');\"", $getAlldata, '' , ' order by name ASC');?></td>						
						
						<td><?php  echo create_dd("priority","system_dd","id","name","type=53","Onchange=\"check_fields_dropdown(this.value,'".$getAlldata['id']."','priority');\"",$getAlldata);?></td>
						
						<td><?php echo create_dd("email_assign","system_dd","id","name","type=51","Onchange=\"check_fields_dropdown(this.value,'".$getallCOuntid['totalid']."','email_assign');\"",$getAlldata);?></td>
						

						<?php  if($_SESSION['bcic_email']['category_type'] == '') { ?>  
						<td onClick="email_details('<?php  echo $getallCOuntid['totalid']; ;?>','<?php echo $getAlldata['mail_type'].'/'.$getAlldata['id']; ?>','email_details');"><?php echo ucfirst($getAlldata['mail_type']); ?></td>
						<?php  }else {  ?>
						<td></td>
						<?php  } ?>
						
					
						
				    </tr>
					<?php  }}else { ?>		
					<tr>	
					 <td>This tab is empty. </td>	
					</tr> 
					<?php  } ?>
						 
				</thead>
				 
			</table>
        </div>
		
		<script>
		   function send_url(qid){
			     window.open('../admin/index.php?task=edit_quote&quote_id='+qid, '_blank');
		   }
		   
		</script>