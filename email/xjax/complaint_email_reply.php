<style>
 #sent_new_msg_type {
    background-color: #fff;
    width: 100%;
    padding: 9px;
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    border-radius: 4px;
}
</style>

<?php  

 //echo '<pre>'; print_r($_SESSION['complaint_email_reply']['email_reply_to']);
 $client_name = get_sql("quote_new","name","where booking_id=".$_SESSION['complaint_email_reply']['job_id']);
 
?>
     
	 
        
            <div class="mail-box">
			    <form class="form-horizontal" method="post" id="reclen_new_message" enctype="multipart/form-data">
		            <div class="mail-body replay_body">	
					
						<div class="alert alert-info alert-dismissable" id="message_div" style="display:none;">
							<a class="close" data-dismiss="alert" aria-label="close">×</a>
							<span id="msg_show"></span>
						</div>			
						
                        <div class="form-group col-md-3">
						    <label class="col-sm-3 control-label">To:</label>
							
							<div class="col-sm-9">
							   <input type="text" class="text-left form-control" value="<?php echo $_SESSION['complaint_email_reply']['email_reply_to']; ?>" id="getemail" autocomplete="off" name="to_email" id="to_email">
							</div>
                        </div>

                        <div class="form-group col-md-3">
						    <label class="col-sm-3 control-label">Bcc:</label>

                            <div class="col-sm-9">
							    <input type="text" class="text-left form-control" autocomplete="off" value="" name="bcc_email" id="bcc_email">
							</div>
                        </div>
						
						<div class="form-group col-md-3">
						    <label class="col-sm-3 control-label">Cc:</label>

                            <div class="col-sm-9">
							    <input type="text" class="text-left form-control"  autocomplete="off" value="" name="cc_email" id="cc_email">
							</div>
                        </div>
                        
                        <div class="form-group col-md-3">
						    <label class="col-sm-3 control-label">BBC Managment:</label>

                            <div class="col-sm-9">
							     <input type="checkbox" class="text-left form-control" value=""onClick="CheckBBCManage();" autocomplete="off" name="bbc_manag" id="bbc_manag">
							</div>
                        </div>
						
						<div class="form-group col-md-12">
						    <label class="col-sm-1 control-label">Subject:</label>
                            <div class="col-sm-11">
							   <input type="text" name="bcic_subject" id="bcic_subject" autocomplete="off" class="text-left form-control" value="<?php echo 'Complaint Reply for '.$_SESSION['complaint_email_reply']['job_id'];  ?>">
						    </div>
                        </div>
						
						
					   <div class="form-group col-md-12 mail-chosse-file mail-chosse-file-new">
							<div class="mail-chosse-type" >
							  <input type="file" name="file[]" id="file"  multiple>
							</div>
							
							<div class="mail-submit-btn text-right tooltip-demo" >
								<input type="button" value="Submit" id="sent_submit" onClick="reclen_complaint_send_new_email();">
							</div>
						</div>
						
						<input type="hidden" id="sent_new_msg_type" name="sent_new_msg_type" value="<?php echo $_SESSION['complaint_email_reply']['mail_type']; ?>">
						<input type="hidden" id="email_msgno" name="email_msgno" value="<?php echo $_SESSION['complaint_email_reply']['email_msgno']; ?>">
						<input type="hidden" id="reclean_email_reply" name="reclean_email_reply" value="email_reply">
						<input type="hidden" id="email_id" name="email_id" value="<?php echo $_SESSION['complaint_email_reply']['id']; ?>">
                    </div>
		                <!---<div  class="summernote form-group all_message_body" id="message_body">
						    
                        </div>-->
						<textarea id="message_body" class="summernote" name="message_body">
							
							<p></p>
							<p></p>
							<p>	Hello <?php echo ucfirst($client_name); ?>, </p>
							<p>	We acknowledge receipt of your email and have forwarded the same to the concerned team who will respond to your email within a 24-48 hours timeframe.<p>
							  <br>
							<p></p>
							<p></p>
							<?php include('signature.php'); ?>		
							<p></p>
							<?php echo $_SESSION['complaint_email_reply']['email_body']; ?>
						</textarea>
						
							<ul class="email_replay_list_box">	
								   <?php 				
											$getAttchment1 = mysql_query("SELECT *  FROM `bcic_email_attach` WHERE email_id = ".$_SESSION['complaint_email_reply']['id']." AND mail_type = '".$_SESSION['complaint_email_reply']['mail_type']."'");
											$countmails1 = mysql_num_rows($getAttchment1);      
									   
										 if($countmails1 > 0) {
												while($getAttchfile = mysql_fetch_assoc($getAttchment1)) {
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
												  
										<input type="hidden" id="is_attch" value="<?php echo $getAttchfile['email_attach']; ?>" name="is_attch[]">
										<input type="hidden" id="email_folder" value="<?php echo $getAttchfile['email_folder']; ?>" name="email_folder[]">
							
							<?php  } }   ?>
					</ul>		
						
				</form>		
			</div>	
			
			
			<script>
		
				//});
			//});
			</script>
			
				<style>
                    #reclen_new_message {
                        margin-top: 58px;
                        margin-right: 0px;
                        margin-bottom: 0px;
                        margin-left: 0px;
                    }
		    	</style>