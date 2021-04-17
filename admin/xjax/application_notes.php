<?php 
   
    if($_GET['appl_id'] != '') {
       $applicationID = $_GET['appl_id'];
	}else {
		$applicationID = $applicationID;
	}
	 $argx = "select * from application_notes where application_id='".mysql_real_escape_string($applicationID)."'  ORDER BY id desc"; 
	//echo $argx; echo $a;	
	$datax = mysql_query($argx);
	$countResult = mysql_num_rows($datax);
	//$getAppdata = mysql_fetch_assoc($datax); 
	
	
	 
	  if($_GET['appl_id'] != '') {
	    
?> 
 
	
					<ul class="list_box_img all_notes">
					    <?php  if($countResult > 0) {

                       while($getAppdata = mysql_fetch_assoc($datax)) {
						?>
							<li>
								<div class="main_images_box">
								<!--<span class="popup_img"><img src="images/buttons/closed.gif"  alt=""/><img src="images/popup_img.png"></span>-->
								<div class="job_created_left">
									<span class="job_created_text"><?php echo $getAppdata['heading']; ?></span>
								 <span class="manish_text"><?php echo $getAppdata['staff_name']; ?><span class="right_date"><?php echo $getAppdata['date']; ?></span></span>
								 </div> 
								</div>
								 <span class="message_below_text"><?php echo $getAppdata['comment']; ?></span>	  
							</li>
					   <?php  } }else { ?>
					       <li>
						     <div class="main_images_box">
						 	   No Found.
						     </div>     
						   </li>
					   <?php } ?>
					</ul>
					
		<?php  }  else { ?>
		
		      <div class="bci_jobs_files">
		           <?php  if($countResult > 0) {

                       while($getAppdata = mysql_fetch_assoc($datax)) {
						?>
             	  <div class="bci_points">
                    <p class="bci_jdetail"><?php echo $getAppdata['heading']; ?><br><?php echo $getAppdata['comment']; ?></p>
                    <span class="bci_jname"><?php echo $getAppdata['staff_name']; ?></span>
                    <span class="bci_jdate"><?php echo $getAppdata['date']; ?></span>
                </div>	
             <?php  } }  ?>    
             </div>     
             
            <?php  } ?> 