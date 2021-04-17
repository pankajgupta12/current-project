<div class="body_container">
		<div class="body_back">
			<span class="main_head" style="margin-bottom: -33px;">Add Application Notes</span>
				<div class="container">   
					  <div class="text_box staff_details" style="margin-top: 19px;width: 46%;">
						   <textarea name="appl_comments" id="appl_comments" class="textarea_box_notes" placeholder="Application Note Added by <?php echo  get_rs_value("admin","name",$_SESSION['admin']); ?>"></textarea>
							<span class="textarea_add_btn">
								<input id="appl_comments_button" name="comments_button" type="button" value="add" onclick="javascript:application_add_comment(document.getElementById('appl_comments'),'<?php echo  $_GET['appl_id']; ?>',1)" style="height:100%; width:100%">
							</span>
						</div>
						
						

						<div id="job_notes_div" style="float:  right;width: 50%;">
							<?php include('xjax/application_notes.php'); ?>
						</div>
				</div>
		</div>
</div>
<script>
	$("#appl_comments").keyup(function(event){
		if(event.keyCode == 13){
			$("#appl_comments_button").click();
		}
	});
</script>	