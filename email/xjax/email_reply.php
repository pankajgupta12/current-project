<style>
 .compose_dropdown1 select{
    background-color: #fff;
    width: 100%;
    padding: 9px;
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    border-radius: 4px;
}
</style>
	   <div class="mail-box">                
			<div class="mail-body replay_body">				   
			    <form class="form-horizontal" id="new_message" enctype="multipart/form-data"> 	
        
				<input type="hidden" name="job_id" id="job_id" value="<?php if($_SESSION['reply_email']['job_id'] != '') { echo $_SESSION['reply_email']['job_id']; }else {echo 0; }?>">
  			   
					<div class="alert alert-info alert-dismissable" id="message_div" style="display:none;">	
						<a class="close" data-dismiss="alert" aria-label="close">×</a>				
						<span id="msg_show"></span>					
					</div>	
				    <?php  //print_r($_SESSION['reply_email']); ?>
					
				    <div class="replay_text_heading">Reply Email from <?php echo ucfirst($_SESSION['reply_email']['mail_type']); ?></div>        
				        <div class="form-group col-md-4">
						  <label class="col-sm-3 control-label">To:</label>
                            <div class="col-sm-9">
							   <input type="text" class="form-control" value="<?php 
								if( strpos( $_SESSION['reply_email']['email_reply_to'], $_SESSION['reply_email']['mail_type'] ) === false ) {
									echo trim($_SESSION['reply_email']['email_reply_to']);
								} else {
									echo trim($_SESSION['reply_email']['email_toaddress']);
								}
									

							   ?>" name="to_email"  id="getemail" onkeyup="searchstaffemail(this.value,'50','getstaff_list' , 'select_staffname_email');"></div>
							   	<div class="clear"></div>
								<div class="searchList shatff_search_box" autocomplete="off" id="getstaff_list" style="display:none;"></div>
								
                        </div>
                        
                        
                        
                        

                        <div class="form-group col-md-3">
						    <label class="col-sm-3 control-label">Bcc:</label>

                            <div class="col-sm-9">
							    <input type="text" class="form-control"  onkeyup="searchstaffemail(this.value,'50','getstaff_list1' , 'select_staffname_email_1');"  autocomplete="off" value="" name="bcc_email" id="bcc_email">
								
								<div class="clear"></div>
								<div class="searchList shatff_search_box" autocomplete="off" id="getstaff_list1" style="display:none;"></div>
								
							</div>
                        </div>
						<div class="form-group col-md-3">
						    <label class="col-sm-3 control-label">Cc:</label>

                            <div class="col-sm-9">
							    <input type="text" onkeyup="searchstaffemail(this.value,'50','getstaff_list2' , 'select_staffname_email_2');"  autocomplete="off" class="form-control" value="" name="cc_email" id="cc_email">
								
								<div class="clear"></div>
								<div class="searchList shatff_search_box" autocomplete="off" id="getstaff_list2" style="display:none;"></div>
								
							</div>
                        </div>
                        
                        <div class="form-group col-md-2">
						    <label class="col-sm-2 control-label">BBC Managment</label>
                                <div class="col-sm-8">
                                   <input type="checkbox" class="text-left form-control" value=""onClick="CheckBBCManage();" autocomplete="off" name="bbc_manag" id="bbc_manag">
							  	</div>
							
                        </div>
                        
                         <div class="form-group col-md-3">
                        	<label class="col-sm-5 control-label">Template Type:</label>
                            <div class="col-sm-6 compose_dropdown1">
							   <?php echo create_dd("temp_type","bcic_template","id","heading","status = 1","onchange=\"javascript:templateType(this.value);\"", '');?>
						    </div>	
						 </div>   
						
						<div class="form-group col-md-12">
						    <label class="col-sm-1 control-label">Subject:</label>
                            <div class="col-sm-11">
							   <input type="text" id="bcic_subject" class="form-control" name="bcic_subject" value="<?php echo  $_SESSION['reply_email']['email_subject']; ?>">
						    </div>
                        </div>
						
						
						<!--<span>
							<div style="margin-right: 84px;margin-bottom: -33px;position:  relative;">
							  <input type="file" name="file[]" id="file"  multiple>
							</div>
						</span>-->
						<div class="form-group col-md-12 mail-chosse-file mail-chosse-file-new">
							<div class="mail-chosse-type" >
							  <input type="file" name="file[]" id="file"  multiple>
							  
							</div>
							
							<div class="mail-submit-btn text-right tooltip-demo">
							
								<!--<span>
									<div style="margin-right: 84px;margin-bottom: -33px;position:  relative;">
									  <input type="file" name="file[]" id="file"  multiple>
									</div>
								</span>-->
								
								<input type="hidden" id="sent_new_msg_type" name="sent_new_msg_type" value="<?php echo $_SESSION['reply_email']['mail_type']; ?>">
								<input type="hidden" id="email_msgno" name="email_msgno" value="<?php echo $_SESSION['reply_email']['email_msgno']; ?>">
								<input type="hidden" id="reply" name="reply" value="reply">
								<input type="hidden" id="email_reply" name="email_reply" value="email_reply">
								<input type="hidden" id="email_id" name="email_id" value="<?php echo $_SESSION['reply_email']['id']; ?>">
								
								
								
								<!--<input type="button" id="reply_sent" onClick="send_reply_email();" value="Submit">-->
								<input type="button" id="reply_sent" onClick="send_reply_email()" value="Submit">
							</div>
						</div>
						
						
						
						<textarea id="message_body" class="summernote" name="message_body">
						
						
						<p></p>
						<p></p>
						
						<?php include('signature.php'); ?>
						
						   <?php echo '--------------------------------------------'; ?>
					    	<br/>
                              On <?php echo date('l, M d, Y' , strtotime($_SESSION['reply_email']['email_date'])); ?>  at <?php echo date('h:i A' , strtotime($_SESSION['reply_email']['email_date'])); ?> <?php  echo  htmlentities($_SESSION['reply_email']['email_reply_toaddress']); ?> wrote:
							   <br/>
						    <?php echo  removeStripslashes($_SESSION['reply_email']['email_body']); ?>
							
							
						
						</textarea>
						
		               	<ul class="email_replay_list_box">	
					   <?php 				
				              	$getAttchment = mysql_query("SELECT *  FROM `bcic_email_attach` WHERE email_id = ".$_SESSION['reply_email']['id']." AND mail_type = '".$_SESSION['reply_email']['mail_type']."'");
								$countmails = mysql_num_rows($getAttchment);      
						   
							 if($countmails > 0) {
									while($getAttchfile = mysql_fetch_assoc($getAttchment)) {
										
										//		  ../mail/images/mail_img/defult_img.png
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
									<!--  <a href="<?php echo  $_SERVER['DOCUMENT_ROOT']; ?>/mail/mail_attachments/<?php  echo $getAttchfile['email_folder']; ?>/<?php echo $getAttchfile['email_attach']; ?>"><img src="../mail/images/mail_img/defult_img.png"/><?php // echo $getAttchfile['email_attach']; ?></a></br/>-->
									  
						    <input type="hidden" id="is_attch" value="<?php echo $getAttchfile['email_attach']; ?>" name="is_attch[]">
						    <input type="hidden" id="email_folder" value="<?php echo $getAttchfile['email_folder']; ?>" name="email_folder[]">
							
							<?php  } }   ?>
					</ul>		
						
						
						
					
				</form>	
			</div>		
		</div>	
		<script>
				function resetErrors() {
					$('form input, form select').removeClass('inputTxtError');
					$('p.error').remove();
				} 
				
		

                   
				//});
			//});
			</script>