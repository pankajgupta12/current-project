<?php
$Emailsdetails['all_staff'] = 2;
?>
<style>
 #sent_new_msg_type {
    background-color: #fff;
    width: 100%;
    padding: 9px;
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    border-radius: 4px;
}
 .compose_dropdown select{
    background-color: #fff;
    width: 100%;
    padding: 9px;
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    border-radius: 4px;
}

</style>
        
        
            <div class="mail-box">
			    <form class="form-horizontal" method="post" id="new_message" enctype="multipart/form-data">
		            <div class="mail-body replay_body">	
						<div class="alert alert-info alert-dismissable" id="message_div" style="display:none;">
							<a class="close" data-dismiss="alert" aria-label="close">×</a>
							<span id="msg_show"></span>
						</div>			
						
					    <div class="replay_text_heading">New Message from <?php  echo $_SESSION['sent_new_msg_type']; ?></div>
						
						
				    	<div class="form-group col-md-12">
						    <label class="col-sm-1 control-label">Mail Type:</label>
                            <div class="col-sm-2 compose_dropdown">
							   <?php echo create_dd("sent_new_msg_type","email_config","email_type","email_type","status = 0","", '');?>
						    </div>
						    
						    <div class="col-sm-2" style="margin-top: -22px; ">
                                <label> Job ID </label> <input type="text" class="text-left form-control" value="" autocomplete="off" name="job_id" id="job_id">
                            </div>
							
							<label class="col-sm-1 control-label">Template Type:</label>
                            <div class="col-sm-2 compose_dropdown">
							   <?php echo create_dd("temp_type","bcic_template","id","heading","status = 1","onchange=\"javascript:templateType(this.value);\"", '');?>
						    </div>
							
							<label class="col-sm-1 control-label">BBC Managment</label>
                            <div class="col-sm-1 compose_dropdown">
							 <input type="checkbox" class="text-left form-control" value=""onClick="CheckBBCManage();" autocomplete="off" name="bbc_manag" id="bbc_manag">
						    </div>
                        </div>
                        
						
                         <div class="form-group col-md-3">
						  <label class="col-sm-3 control-label">To:</label>
                            <div class="col-sm-9">
							   <input type="text" class="text-left form-control"  id="getemail" onkeyup="searchstaffemail(this.value,'50','getstaff_list' , 'select_staffname_email');" autocomplete="off" name="to_email" id="to_email">
							</div>
								<div class="clear"></div>
								<div class="searchList shatff_search_box" id="getstaff_list" style="display:none;"></div>
                        </div>

						<div class="form-group col-md-3">
						    <label class="col-sm-6 control-label">ALL Active Staff :</label>
                            <div class="col-sm-6 compose_dropdown">
							   <?php echo create_dd("all_staff","system_dd","id","name","type = 29","onchange=\"javascript:emailTypes(this.value);\"", $Emailsdetails);?>
						    </div>
                        </div>
						
						 <div class="form-group col-md-3" id="staff_type_id" style="display:none;">
						    <label class="col-sm-6 control-label">Staff Type :</label>
                            <div class="col-sm-6 compose_dropdown">
                                <select name="staff_type" class="formfields" id="staff_type">
                                     <option value="0">All</option>
                                     <option value="1">Bcic</option>
                                     <option value="2">Bbc</option>
                                </select>
							   <?php // echo create_dd("staff_type","system_dd","id","name","type = 41","", $Emailsdetails);?>
						    </div>
                        </div>
						
                        <div class="form-group col-md-3" id="bcc_staff">
						    <label class="col-sm-3 control-label">Bcc:</label>

                            <div class="col-sm-9">
							    <input type="text" onkeyup="searchstaffemail(this.value,'50','getstaff_list1' , 'select_staffname_email_1');"  class="text-left form-control" autocomplete="off" value="" name="bcc_email" id="bcc_email">
								
								<div class="clear"></div>
								<div class="searchList shatff_search_box" id="getstaff_list1" style="display:none;"></div>
								
							</div>
                        </div>
						
						<div class="form-group col-md-3">
						    <label class="col-sm-3 control-label">Cc:</label>

                            <div class="col-sm-9">
							    <input type="text" class="text-left form-control"  autocomplete="off" onkeyup="searchstaffemail(this.value,'50','getstaff_list2' , 'select_staffname_email_2');" value="" name="cc_email" id="cc_email">
								
								<div class="clear"></div>
								<div class="searchList shatff_search_box" id="getstaff_list2" style="display:none;"></div>
								
							</div>
                        </div>
						<div class="form-group col-md-12">
						    <label class="col-sm-1 control-label">Subject:</label>
                            <div class="col-sm-11">
							   <input type="text" name="bcic_subject" id="bcic_subject" autocomplete="off" class="text-left form-control" value="">
						    </div>
                        </div>
						
						
					   <div class="form-group col-md-12 mail-chosse-file mail-chosse-file-new">
							<div class="mail-chosse-type" >
							  <input type="file" name="file[]" id="file"  multiple>
							  
							</div>
							
							<div class="mail-submit-btn text-right tooltip-demo">
					
						
								<input type="button" value="Submit" id="sent_submit" onClick="send_new_email();">
								
							</div>
							
						</div>
						
						

                    </div>
		                <!---<div  class="summernote form-group all_message_body" id="message_body">
						    
                        </div>-->
						<textarea id="message_body" class="summernote" name="message_body">
							
							<p></p>
							
							<?php include('signature.php'); ?>		
						</textarea>
						
						
					
				</form>		
			</div>	
			
			
				<script>
			
			function emailTypes(id){
				
				if(id == 1) {
				 $('#bcc_staff').hide();
				 $('#staff_type_id').show();
				}else{
					 $('#bcc_staff').show();
					 $('#staff_type_id').hide();
				}
			}
			
		
			</script>