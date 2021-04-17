<?php 
   
  	$review_id = $review_id;
	 $argx = "select * from review_notes where review_id  ='".mysql_real_escape_string($review_id)."'  ORDER BY id desc"; 
	//echo $argx; 
	$datax = mysql_query($argx);
	$countResult = mysql_num_rows($datax);
	//$getAppdata = mysql_fetch_assoc($datax); 
?> 
         
         
          
	
				<div class="bci_jobs_files" >
					    <?php  if($countResult > 0) {

                       while($data1 = mysql_fetch_assoc($datax)) {
						?>
						
					  	<div class="bci_points">
                                <p class="bci_jdetail"><strong><?php echo $data1['heading']; ?></strong><br><?php echo $data1['comment']; ?> </p>
                                <span class="bci_jname">By <?php echo $data1['staff_name']; ?> </span>
                                <span class="bci_jdate"><?php echo $data1['createdOn']; ?></span>
                         </div>
						
                       
						
					   <?php  } }else { ?>
					       <div class="bci_points">
						     <div class="main_images_box">
						 	    <p class="bci_jdetail"><br>No Comments... </p>
						     </div>     
						   </div>
					   <?php } ?>
					</div>
					
	<style>
	   .bci_points .bci_jdetail {
                display: block;
                margin: 0;
                padding: 0;
                font-family: "OpenSans";
                color: #242424;
                font-size: 12px;
                width: 100%;
                overflow: hidden;
                white-space: break-spaces;
       }
	   
	</style>
					