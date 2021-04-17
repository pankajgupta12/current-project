	<div class="mail-box">
		<div class="forward_text_heading">Forward Email</div>
		<div class="mail-body forword_body">
			<form class="form-horizontal" id="new_message" enctype="multipart/form-data"> 	
			       
				    <div class="alert alert-info alert-dismissable" id="message_div" style="display:none;">	
						<a class="close" data-dismiss="alert" aria-label="close">×</a>				
						<span id="msg_show"></span>					
					</div>	
				   <?php  //print_r($_SESSION['forward_email']); ?>
				   
					<div class="form-group col-md-3">
						  <label class="col-sm-3 control-label">To:</label>
							<div class="col-sm-9">
							   <input type="text" class="form-control"  id="getemail" onkeyup="searchstaffemail(this.value,'50','getstaff_list' , 'select_staffname_email');"   autocomplete="off" value="" name="to_email" id="to_email"></div>
						 
                                <div class="clear"></div>
                                <div class="searchList shatff_search_box" id="getstaff_list" style="display:none;"></div>
						
						</div>

						<div class="form-group col-md-3">
							<label class="col-sm-3 control-label">Bcc:</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" onkeyup="searchstaffemail(this.value,'50','getstaff_list1' , 'select_staffname_email_1');"  autocomplete="off" value="" name="bcc_email" id="bcc_email">
								
								<div class="clear"></div>
                                <div class="searchList shatff_search_box" id="getstaff_list1" style="display:none;"></div>
								
							</div>
						</div>
						
						<div class="form-group col-md-3">
							<label class="col-sm-3 control-label">Cc:</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" onkeyup="searchstaffemail(this.value,'50','getstaff_list2' , 'select_staffname_email_2');"  autocomplete="off" value="" name="cc_email" id="cc_email">
								
								<div class="clear"></div>
                                <div class="searchList shatff_search_box" id="getstaff_list2" style="display:none;"></div>
							</div>
						</div>
						
						<div class="form-group col-md-3">
							<label class="col-sm-3 control-label">BBC Managment:</label>

							    <div class="col-sm-8">
                                   <input type="checkbox" class="text-left form-control" value=""onClick="CheckBBCManage();" autocomplete="off" name="bbc_manag" id="bbc_manag">
							  	</div>
						</div>
						
						<div class="form-group col-md-12">
							<label class="col-sm-1 control-label">Subject:</label>
							<div class="col-sm-11">
							   <!--<input type="text" id="bcic_subject"  name="bcic_subject" autocomplete="off" class="form-control" value="FWD: <?php  if($_SESSION['forward_email']['email_subject'] != '') { echo $_SESSION['forward_email']['email_subject']; }  ?>">-->
							   
							   <input type="text" id="bcic_subject"  name="bcic_subject" autocomplete="off" class="form-control">
							</div>
						</div>
						
						<div class="form-group col-md-12 mail-chosse-file mail-chosse-file-new">
							<div class="mail-chosse-type" >
							  <input type="file" name="file[]" id="file"  multiple>
							  
							</div>
							
							<div class="mail-submit-btn text-right tooltip-demo">
				    
								<!--<a href="javascript:void(0);" onClick="return sent_message('<?php echo $forwardEmail['mail_type']; ?>','<?php echo $forwardEmail['email_msgno']; ?>','forward')" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Send"><i class="fa fa-reply"></i> Send</a>-->
								
								<input type="button" id="forward_submit" onClick="email_forward()" value="Submit">
							
								
							</div>
						</div>
					    
				
					<!--<div  class="summernote form-group all_message_body" id="message_body"></div>-->
					<textarea id="message_body" class="summernote" name="message_body">
					
						
						<p></p>
						<p></p>
							
						<?php include('signature.php'); ?>	
					
					     <?php echo '------------Forwarded message-------------------'; ?>
					    	<br/>
							From: <?php  echo  ($_SESSION['forward_email']['email_fromaddress']); ?><br/>
							Date: <?php  echo date('l, M d, Y'); ?> <?php echo date('h:i A'); ?><br/>
							Subject: Fwd: <?php  echo $_SESSION['forward_email']['email_subject']; ?><br/>
							To: <?php  echo $_SESSION['forward_email']['email_toaddress']; ?><br/>
                               <br/>

						    <?php 
							   echo  removeStripslashes($_SESSION['forward_email']['email_body']);  ?>
                                        
							<?php	   
								  /*$getAttchment = mysql_query("SELECT *  FROM `bcic_email_attach` WHERE email_id = ".$_SESSION['forward_email']['id']." AND mail_type = '".$_SESSION['forward_email']['mail_type']."'");
								$countmails = mysql_num_rows($getAttchment);      
						   
							 if($countmails > 0) {
									while($getAttchfile = mysql_fetch_assoc($getAttchment)) {
							 ?>
									  <a href="<?php echo  $_SERVER['DOCUMENT_ROOT']; ?>/mail/mail_attachments/<?php  echo $getAttchfile['email_folder']; ?>/<?php echo $getAttchfile['email_attach']; ?>"><?php echo $getAttchfile['email_attach']; ?></a></br>
						   
						   
							<?php  } } */ ?>
						
							
							
					</textarea>
					<ul class="email_replay_list_box">	
                              <?php 				
				              	$getAttchment = mysql_query("SELECT *  FROM `bcic_email_attach` WHERE email_id = ".$_SESSION['forward_email']['id']." AND mail_type = '".$_SESSION['forward_email']['mail_type']."'");
								$countmails = mysql_num_rows($getAttchment);      
						   
							 if($countmails > 0) {
									while($getAttchfile = mysql_fetch_assoc($getAttchment)) {
							 ?>
							 
							 <li class="file-box" style="list-style: none;">
                                <div class="fileNew file">
                                    <a href="../mail/mail_attachments/<?php  echo $getAttchfile['email_folder']; ?>/<?php echo $getAttchfile['email_attach']; ?>"  target="_blank">
                                        <span class="corner"></span>

                                        <div class="image">
                                            <img alt="image" class="img-responsive" src="../mail/images/mail_img/defult_img.png">
                                         
                                        </div>
                                       
                                    </a>

                                </div>
                            </li>
							 
							 
									  <!--<a href="<?php echo  $_SERVER['DOCUMENT_ROOT']; ?>/mail/mail_attachments/<?php  echo $getAttchfile['email_folder']; ?>/<?php echo $getAttchfile['email_attach']; ?>"><?php echo $getAttchfile['email_attach']; ?></a></br>-->
									  
						    <input type="hidden" id="is_attch" value="<?php echo $getAttchfile['email_attach']; ?>" name="is_attch[]">
						    <input type="hidden" id="email_folder" value="<?php echo $getAttchfile['email_folder']; ?>" name="email_folder[]">
							
							
							<?php  } }   ?>
							
			
			
			
						<input type="hidden" id="sent_new_msg_type" name="sent_new_msg_type" value="<?php echo $_SESSION['forward_email']['mail_type']; ?>">
						<input type="hidden" id="email_msgno" name="email_msgno" value="<?php echo $_SESSION['forward_email']['email_msgno']; ?>">
						<input type="hidden" id="email_id" name="email_id" value="<?php echo $_SESSION['forward_email']['id']; ?>">
					</ul>
				
			</form>
		</div>	
    </div>	
	      <script>
		
			</script>