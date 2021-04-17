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

 $jobdetails = mysql_query("SELECT staff_id  FROM `job_details` WHERE job_id = ".$_SESSION['reclean_email']['job_id']." AND status != 2 ");
 
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
							
								<select class="inputstl" name="to_email[]" id="to_email" multiple="">
									<?php while($getstaff = mysql_fetch_assoc($jobdetails)) { 
                                     if($getstaff['staff_id'] != 0) {		
									 $email = get_rs_value("staff","email",$getstaff['staff_id']);		
									?>
										<option value="<?php echo $email; ?>"><?php echo $email; ?></option>
									 <?php } } ?>
								</select>
							
                            <!--<div class="col-sm-9">
							   <input type="text" class="text-left form-control"  id="getemail" onkeyup="searchstaffemail(this.value,'50','getstaff_list');" autocomplete="off" name="to_email" id="to_email">
							</div>-->
							<div class="clear"></div>
							<div class="searchList shatff_search_box" id="getstaff_list" style="display:none;"></div>
                        </div>

                        <div class="form-group col-md-3">
						    <label class="col-sm-3 control-label">Bcc:</label>

                            <div class="col-sm-9">
							    <input type="text" class="text-left form-control" onkeyup="searchstaffemail(this.value,'50','getstaff_list1' , 'select_staffname_email_1');" autocomplete="off" value="" name="bcc_email" id="bcc_email">
								
								<div class="clear"></div>
                                <div class="searchList shatff_search_box" id="getstaff_list1" style="display:none;"></div>
								
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
							   <input type="text" name="bcic_subject" id="bcic_subject" autocomplete="off" class="text-left form-control" value="<?php echo 'Re-Clean Advice for '.$_SESSION['reclean_email']['job_id'];  ?>">
						    </div>
                        </div>
						
						
					   <div class="form-group col-md-12 mail-chosse-file mail-chosse-file-new">
							<div class="mail-chosse-type" >
							  <input type="file" name="file[]" id="file"  multiple>
							</div>
							
							<div class="mail-submit-btn text-right tooltip-demo">
								<input type="button" value="Submit" id="sent_submit" onClick="reclean_send_new_email();">
							</div>
						</div>
						
						<input type="hidden" id="sent_new_msg_type" name="sent_new_msg_type" value="<?php echo $_SESSION['reclean_email']['mail_type']; ?>">
						<input type="hidden" id="email_msgno" name="email_msgno" value="<?php echo $_SESSION['reclean_email']['email_msgno']; ?>">
						<input type="hidden" id="reclean_email_reply" name="reclean_email_reply" value="email_reply">
						<input type="hidden" id="email_id" name="email_id" value="<?php echo $_SESSION['reclean_email']['id']; ?>">
                    </div>
		                <!---<div  class="summernote form-group all_message_body" id="message_body">
						    
                        </div>-->
						<textarea id="message_body" class="summernote" name="message_body">
							
							<p></p>
							<p></p>
							<?php include('reclean_details.php'); ?>		
							<p></p>
							<p></p>
							<?php include('signature.php'); ?>		
							<p></p>
							<?php echo $_SESSION['reclean_email']['email_body']; ?>
						</textarea>
						
						<br/><br/><br/><br/>
						
							<ul class="email_replay_list_box">	
								   <?php 				
											$getAttchment1 = mysql_query("SELECT *  FROM `bcic_email_attach` WHERE email_id = ".$_SESSION['reclean_email']['id']." AND mail_type = '".$_SESSION['reclean_email']['mail_type']."'");
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
			<style>
            #reclen_new_message {
                margin-top: 58px;
                margin-right: 0px;
                margin-bottom: 0px;
                margin-left: 0px;
            }
			</style>
			
			<script>
		
				//});
			//});
			</script>