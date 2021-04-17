<?php  
   if($_SESSION['note_email_id'] != '' && $_SESSION['note_email_type'] != '') {
    $arg =  mysql_query("SELECT id,quote_id,job_id , staff_id, reclean_id, mail_type , email_msgno  FROM `bcic_email` WHERE `id` = ".$_SESSION['note_email_id']." AND `mail_type` = '".$_SESSION['note_email_type']."'");
   }
   
   $countemail = mysql_num_rows($arg);
   
   if($countemail > 0) {
	   $getNotes = mysql_fetch_assoc($arg);
?> 
             
					<div id="q_notes_content">
						<div id="quote_notes_div">
							<div class="alert alert-warning msgBox">
							 <span class="mgID text-left">ID :<span><?php echo $_SESSION['note_email_id']; ?></span></span>
								<span class="mgNo text-right">Mail Type: <span><?php echo ucfirst($_SESSION['note_email_type']); ?></span></span>
								<!--<span class="mgNo text-right">Meg No: <span>2</span></span>-->
							</div>
							
								<div class="offset">
									<textarea name="email_comments" id="email_comments" class="form-control" placeholder="Add emails Note Here" onkeypress="return check_press_enter_notes(event);" ></textarea>
								  
								   <input id="email_comments_button" name="email_comments_button" type="button" value="add" onclick="javascript:add_email_comment(document.getElementById('email_comments'),'<?php echo $getNotes['id']; ?>','<?php echo $getNotes['mail_type']; ?>','<?php echo $getNotes['email_msgno']; ?>')" style="display:none; height:100%; width:100%" />
								</div>   

						</div>
							
						<?php 
						$flag_notes = 0;
						  if(in_array($_SESSION['admin'] , array(1,3,12,17,37))){
						      $flag_notes = 1;
						  }
						
							$arg = "SELECT * FROM `email_notes` where email_id= ".$getNotes['id']." AND mail_type = '".$getNotes['mail_type']."'"; 
							
							if($flag_notes == 0) {
							  $arg .=  '  AND heading != comment';
							}
							
							//echo $arg;
							$getSql = mysql_query($arg);
							 $countNotes = mysql_num_rows($getSql);
							 
								if($countNotes > 0 ) {
								    
									echo '<div class="bci_jobs_files offset" id="quote_notes_comments_div">';		
									   while($getData = mysql_fetch_assoc($getSql)) { 

											echo ' <div class="bci_points">
											<p class="bci_jdetail"><strong>'.$getData['heading'].'</strong><br />'.$getData['comment'].'</p>
											<span class="bci_jname">By '.$getData['staff_name'].'</span>
											<span class="bci_jdate">'.date("h:i a dS M Y",strtotime($getData['date'])).'</span>
											</div>';       
										 } 
									echo '</div>';		 
								}else { ?>
								<div class="bci_points">
								   No Emails Notes.
							</div>									 
						<?php  } ?>
						   <!--bci_jobs_files-->
						</div>
						
					</div>
	
   <?php  } ?>			