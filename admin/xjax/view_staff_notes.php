<?php 
   
    if($_GET['id'] != '') {
       $staff_id = $_GET['id'];
	}else {
		$staff_id = $applicationID;
	}
	
	 $application_id = get_rs_value("staff","application_id",$staff_id);
	 
	 $argx = "select * from application_notes where 1 =1 ";
	 
	 
	 $argx .= " AND staff_id='".mysql_real_escape_string($staff_id)."'";
	 
	/*  if($application_id != 0 ) {
	   $argx .= " OR application_id = ".$application_id." "; 
	 } */
	  $argx .= " ORDER BY id desc";
	 
	//echo $argx; 
	$datax = mysql_query($argx);
	$countResult = mysql_num_rows($datax);
	//$getAppdata = mysql_fetch_assoc($datax); 
	
	
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