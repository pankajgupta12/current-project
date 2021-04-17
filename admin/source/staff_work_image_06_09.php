<!--LightBox--------->
	<link rel="stylesheet" href="source/popup/colorbox.css" />
	<script src="source/popup/jquery.colorbox.js"></script>
<!--LightBox--------->		

<br/><br/>
	<div style="margin: 0px 117px 5px;">
				<input type="button" value="Job Image" id="job_image" class="staff_button_over" onclick="stafImage(1);" style="float:left; margin-right:10px;">
				<?php $jobStatus = getJob_Status($_REQUEST['job_id']);  ?>
				<input type="button" value="Re-clean Image" id="reclean_image"  class="staff_button" onclick="stafImage(2);" style="float:left; margin-right:10px;" >
	</div>
	<br>
	<br>
	
	<div id="tab-5" class="loader" style="margin-top: -37px;">
	    <div class="tab5_main">
			    <ul class="tabs_5_ul_staff staff_upload_image" id="job_image_data" style="margin:  10px 0;">
				
				<h3 align="center">Job Images</h3>
				
					<div id="uploadImagedata">
					 <h4>Before Work  Images upload</h4>
				     <?php
					   
					  $staffsql = mysql_query("SELECT DISTINCT(staff_id) as staffid  FROM `job_befor_after_image` where job_id ='".$_REQUEST['job_id']."' and image_status = 1 AND reclean_id = 0 AND job_type_status = 1");
					  
					if(mysql_num_rows($staffsql) > 0) {  
				     while($getstaff_id = mysql_fetch_assoc($staffsql)) {
					
					$jobtype = get_sql("job_details","job_type"," where staff_id = ".$getstaff_id['staffid']." AND job_id=".$_REQUEST['job_id']." AND status != 2");	
					
					  //echo '<h5>'.get_rs_value("staff","name",$getstaff_id['staffid']).'   ('.$jobtype.') Job Images</h5>'; 
					  
                       $getbeforeImage = mysql_query("SELECT * FROM `job_befor_after_image` where job_id ='".$_REQUEST['job_id']."' and image_status = 1 AND reclean_id = 0 AND staff_id = '".$getstaff_id['staffid']."' AND job_type_status = 1");
					
						echo '<h5>'.get_rs_value("staff","name",$getstaff_id['staffid']).'   ('.$jobtype.') Job Images ('.mysql_num_rows($getbeforeImage).')</h5>';
					    
					if(mysql_num_rows($getbeforeImage)>0) { 
					
					    echo "<ul class='staffwork_image' style='margin: 14px;'>";
					    $i=1;
						while($imagedata = mysql_fetch_array($getbeforeImage)) { 
						
						$path =  getcwd();
						
						
						$getSize = (getimagesize($imagedata['image_url']));
						$getSizeaws_url = (getimagesize($imagedata['aws_url']));
						
						if($imagedata['image_url'] !='' && !empty($getSize) || !empty($getSizeaws_url)) {
						    
						    ?>
						
						    <li id="imagefile"><a href="<?php if($imagedata['aws_url'] != '') {  echo $imagedata['aws_url'];  }else { echo  $imagedata['image_url'];  }  ?>" class="group1"><img src="<?php if($imagedata['aws_url'] != '') {  echo $imagedata['aws_url'];  }elseif($imagedata['thumb_img_url'] != '') { echo  $imagedata['thumb_img_url'];  }else { echo $imagedata['image_url'];  }  ?><?php // if($imagedata['thumb_img_url'] != '') { echo $imagedata['thumb_img_url']; }else { echo $imagedata['image_url']; } ?>" alt="<?php echo $imagedata['work_image']; ?>"></a></li>
						
					        <?php 
						    
						} 
					        $i++; } 
					  echo "</ul>";
				    }else {
						echo '<div class="alert alert-danger">  No Image found.</div>';
					}
					} }else{
						echo '<div class="alert alert-danger">  No Image found.</div>';
					}
				
					 ?>
					</div> 
			
					<br/><br/>
					<div id="uploadImagedata1">
						<h4>After Work  Images upload</h4>
							<?php
							
							$staffsql_after = mysql_query("SELECT DISTINCT(staff_id) as staffid  FROM `job_befor_after_image` where job_id ='".$_REQUEST['job_id']."' and image_status = 2 AND reclean_id = 0 AND job_type_status = 1");
						if(mysql_num_rows($staffsql_after) > 0) {  	
							
							while($getstaff_id_data = mysql_fetch_assoc($staffsql_after)) {
								
								$jobtype1 = get_sql("job_details","job_type"," where staff_id = ".$getstaff_id_data['staffid']." AND job_id=".$_REQUEST['job_id']." AND status != 2");	
								
							   //echo '<h5>'.get_rs_value("staff","name",$getstaff_id_data['staffid']).'  ('.$jobtype1.') Job Images </h5>'; 	
								
							   $getafterImage = mysql_query("SELECT * FROM `job_befor_after_image` where job_id ='".$_REQUEST['job_id']."' and image_status = 2 AND reclean_id = 0  AND staff_id = '".$getstaff_id_data['staffid']."' AND job_type_status = 1");
							   
							   echo '<h5>'.get_rs_value("staff","name",$getstaff_id_data['staffid']).'  ('.$jobtype1.') Job Images ('.mysql_num_rows($getafterImage).')</h5>';
							   
							     if(mysql_num_rows($getafterImage)>0) {
								 echo "<ul class='staffwork_image' style='margin: 14px;'>";   
							    $k=1;
								 while($imagedataafter = mysql_fetch_array($getafterImage)) { 
								 //print_r($imagedata);
								$path =  getcwd();
								 $getSize = (getimagesize($imagedataafter['image_url']));
								 $getSizeaws_url1 = (getimagesize($imagedataafter['aws_url']));
								 
								if($imagedataafter['image_url'] != '' && !empty($getSize) || $getSizeaws_url1 != '') {
								    
								   
								
								?>
								
								  <li id="imagefile" ><a class="group2" href="<?php if($imagedataafter['aws_url'] != '') {  echo $imagedataafter['aws_url'];  }else { echo  $imagedataafter['image_url'];  }  ?>"><img src="<?php if($imagedataafter['aws_url'] != '') {  echo $imagedataafter['aws_url'];  }elseif($imagedata['thumb_img_url'] != '') { echo  $imagedataafter['thumb_img_url'];  }else { echo $imagedataafter['image_url'];  }  ?>" alt="<?php echo $imagedataafter['work_image']; ?>"></a></li>
							    <?php 
								     
								 } 
								 $k++; } 
							      echo "</ul>";
								}else {
								echo '<div class="alert alert-danger"> No Images found.</div>';
								}
							}
							}else{
						    echo '<div class="alert alert-danger">  No Image found.</div>';
					    }
							 ?>
					</div> 
					
					<div id="uploadImagedata">
					 <h4>Check List Images upload</h4>
				     <?php
					   
					  $staffsql = mysql_query("SELECT DISTINCT(staff_id) as staffid  FROM `job_befor_after_image` where job_id ='".$_REQUEST['job_id']."' and image_status = 3 AND reclean_id = 0 AND job_type_status = 1");
					  
					if(mysql_num_rows($staffsql) > 0) {  
				     while($getstaff_id = mysql_fetch_assoc($staffsql)) {
					
					$jobtype = get_sql("job_details","job_type"," where staff_id = ".$getstaff_id['staffid']." AND job_id=".$_REQUEST['job_id']." AND status != 2");	
					
					  //echo '<h5>'.get_rs_value("staff","name",$getstaff_id['staffid']).'   ('.$jobtype.') Job Images</h5>'; 
					  
                       $getbeforeImage = mysql_query("SELECT * FROM `job_befor_after_image` where job_id ='".$_REQUEST['job_id']."' and image_status = 3 AND reclean_id = 0 AND staff_id = '".$getstaff_id['staffid']."' AND job_type_status = 1");
					
						echo '<h5>'.get_rs_value("staff","name",$getstaff_id['staffid']).'   ('.$jobtype.') Job Images ('.mysql_num_rows($getbeforeImage).')</h5>';
					    
					if(mysql_num_rows($getbeforeImage)>0) { 
					
					    echo "<ul class='staffwork_image' style='margin: 14px;'>";
					    $i=1;
						while($imagedata = mysql_fetch_array($getbeforeImage)) { 
						
						$path =  getcwd();
						$getSize = (getimagesize($imagedata['image_url']));
						 $getSizeaws_url = (getimagesize($imagedata['aws_url']));
						 
						if($imagedata['image_url'] !='' && !empty($getSize) || $getSizeaws_url !='') {
						    ?>
						
						    <li id="imagefile"><a href="<?php if($imagedata['aws_url'] != '') {  echo $imagedata['aws_url'];  }else { echo  $imagedata['image_url'];  }  ?>" class="group3"><img src="<?php if($imagedata['aws_url'] != '') {  echo $imagedata['aws_url'];  }elseif($imagedata['thumb_img_url'] != '') { echo  $imagedata['thumb_img_url'];  }else { echo $imagedata['image_url'];  }  ?>" alt="<?php echo $imagedata['work_image']; ?>"></a></li>
						
					        <?php 
						    
					    	}
						$i++; } 
					  echo "</ul>";
				    }else {
						echo '<div class="alert alert-danger">  No Image found.</div>';
					}
					} }else{
						echo '<div class="alert alert-danger">  No Image found.</div>';
					}
				
					 ?>
					</div> 
					
				</ul>
			
			    <ul class="tabs_5_ul_staff"  style="display:none;" id="reclean_image_data">
				<h4 align="center">Re-clean Images</h4>
					<div id="uploadImagedata">
					 <h5>Before Work  Images upload</h5>
				     <?php
					 
					   $staffsql_re = mysql_query("SELECT DISTINCT(staff_id) as staffid  FROM `job_befor_after_image` where job_id ='".$_REQUEST['job_id']."' and image_status = 1 AND reclean_id != 0 AND job_type_status = 2");
					 
                    if(mysql_num_rows($staffsql_re) > 0) {  					 
					 
					  while($getstaff_id = mysql_fetch_assoc($staffsql_re)) {
					
					   $jobtype = get_sql("job_details","job_type"," where staff_id = ".$getstaff_id['staffid']." AND job_id=".$_REQUEST['job_id']." AND status != 2");	
					
					  //echo '<h5>'.get_rs_value("staff","name",$getstaff_id['staffid']).'   ('.$jobtype.') Job Images</h5>'; 
					 
                       $getbeforeImage = mysql_query("SELECT * FROM `job_befor_after_image` where job_id ='".$_REQUEST['job_id']."' and image_status = 1 AND reclean_id != 0 AND  staff_id = '".$getstaff_id['staffid']."' AND job_type_status = 2");
					    
						echo '<h5>'.get_rs_value("staff","name",$getstaff_id['staffid']).'   ('.$jobtype.') Job Images ('.mysql_num_rows($getbeforeImage).')</h5>';
						
					 if(mysql_num_rows($getbeforeImage)>0) { 
					 echo "<ul class='staffwork_image' style='margin: 14px;'>";
					  $i=1;
						 while($imagedata = mysql_fetch_array($getbeforeImage)) { 
						 //print_r($imagedata);
						$path =  getcwd();
						 $getSize1 = (getimagesize($imagedata['image_url']));
						  $getSizeaws_url2 = (getimagesize($imagedata['aws_url']));
						if($imagedata['image_url'] != '' && !empty($getSize1) || $getSizeaws_url2 != '') {
						
						?>
						
						  <li id="imagefile"><a href="<?php if($imagedata['aws_url'] != '') {  echo $imagedata['aws_url'];  }else { echo  $imagedata['image_url'];  }  ?>" class="group1"><img src="<?php if($imagedata['aws_url'] != '') {  echo $imagedata['aws_url'];  }elseif($imagedata['thumb_img_url'] != '') { echo  $imagedata['thumb_img_url'];  }else { echo $imagedata['image_url'];  }  ?>"  alt="<?php echo $imagedata['work_image']; ?>"></a></li>
						
					 <?php } 
					 $i++; } 
					  echo "</ul>";
				    }else {
						echo '<div class="alert alert-danger">  No Image found.</div>';
					}
				}
				}else{
						    echo '<div class="alert alert-danger">  No Image found.</div>';
					    }
					 ?>
					</div> 
					<br/><br/>
					<div id="uploadImagedata1">
						<h5>After Work  Images upload</h5>
							<?php
							
					$staffsql_re_af = mysql_query("SELECT DISTINCT(staff_id) as staffid  FROM `job_befor_after_image` where job_id ='".$_REQUEST['job_id']."' and image_status = 2 AND reclean_id != 0 AND job_type_status = 2");
					
					//if(mysql_num_rows($staffsql_re) > 0) {
                    if(mysql_num_rows($staffsql_re_af) > 0) {						
					 
					   while($getstaff_id = mysql_fetch_assoc($staffsql_re_af)) {
					
					     $jobtype = get_sql("job_details","job_type"," where staff_id = ".$getstaff_id['staffid']." AND job_id=".$_REQUEST['job_id']." AND status != 2");	
					
					  //echo '<h5>'.get_rs_value("staff","name",$getstaff_id['staffid']).'   ('.$jobtype.') Job Images</h5>'; 
							
							
							$getafterImage = mysql_query("SELECT * FROM `job_befor_after_image` where job_id ='".$_REQUEST['job_id']."' and image_status = 2 AND staff_id = ".$getstaff_id['staffid']."  AND reclean_id != 0 AND job_type_status = 2");
							
							echo '<h5>'.get_rs_value("staff","name",$getstaff_id['staffid']).'   ('.$jobtype.') Job Images ('.mysql_num_rows($getafterImage).')</h5>';
							
							    if(mysql_num_rows($getafterImage)>0) {
								 echo "<ul class='staffwork_image' style='margin: 14px;'>";   
							    $k=1;
								 while($imagedataafter = mysql_fetch_array($getafterImage)) { 
								 //print_r($imagedata);
								$path =  getcwd();
								 $getSize1 = (getimagesize($imagedataafter['image_url']));
								 $getSizeaws_url23 = (getimagesize($imagedataafter['aws_url']));
								if($imagedataafter['image_url'] !='' && !empty($getSize1) || $getSizeaws_url23 !='') {
								?>
								
								  <li id="imagefile" ><a class="group2" href="<?php if($imagedataafter['aws_url'] != '') {  echo $imagedataafter['aws_url'];  }else { echo  $imagedataafter['image_url'];  }  ?>"><img src="<?php if($imagedataafter['aws_url'] != '') {  echo $imagedataafter['aws_url'];  }elseif($imagedataafter['thumb_img_url'] != '') { echo  $imagedataafter['thumb_img_url'];  }else { echo $imagedataafter['image_url'];  }  ?>" alt="<?php echo $imagedataafter['work_image']; ?>"></a></li>
							    <?php 
								     
								 }
								 $k++; } 
							      echo "</ul>";
								}else {
								echo '<div class="alert alert-danger"> No Images found.</div>';
								}
					}
					}else{
						    echo '<div class="alert alert-danger">  No Image found.</div>';
					    }
							 ?>
					</div> 
					
					<div id="uploadImagedata">
					 <h4>Check List Images upload</h4>
				     <?php
					   
					  $staffsql = mysql_query("SELECT DISTINCT(staff_id) as staffid  FROM `job_befor_after_image` where job_id ='".$_REQUEST['job_id']."' and image_status = 3 AND reclean_id != 0 AND job_type_status = 1");
					  
					if(mysql_num_rows($staffsql) > 0) {  
				     while($getstaff_id = mysql_fetch_assoc($staffsql)) {
					
					$jobtype = get_sql("job_details","job_type"," where staff_id = ".$getstaff_id['staffid']." AND job_id=".$_REQUEST['job_id']." AND status != 2");	
					
					  //echo '<h5>'.get_rs_value("staff","name",$getstaff_id['staffid']).'   ('.$jobtype.') Job Images</h5>'; 
					  
                       $getbeforeImage = mysql_query("SELECT * FROM `job_befor_after_image` where job_id ='".$_REQUEST['job_id']."' and image_status = 3 AND reclean_id != 0 AND staff_id = '".$getstaff_id['staffid']."' AND job_type_status = 1");
					
						echo '<h5>'.get_rs_value("staff","name",$getstaff_id['staffid']).'   ('.$jobtype.') Job Images ('.mysql_num_rows($getbeforeImage).')</h5>';
					    
					if(mysql_num_rows($getbeforeImage)>0) { 
					
					    echo "<ul class='staffwork_image' style='margin: 14px;'>";
					    $i=1;
						while($imagedata = mysql_fetch_array($getbeforeImage)) { 
						
						$path =  getcwd();
						$getSize = (getimagesize($imagedata['image_url']));
						$getSizeaws_url = (getimagesize($imagedata['aws_url']));
						if($imagedata['image_url'] !='' && !empty($getSize) || $getSizeaws_url != '') {
						    ?>
						
						    <li id="imagefile"><a href="<?php if($imagedata['aws_url'] != '') {  echo $imagedata['aws_url'];  }else { echo  $imagedata['image_url'];  }  ?>" class="group3"><img src="<?php if($imagedata['aws_url'] != '') {  echo $imagedata['aws_url'];  }elseif($imagedata['thumb_img_url'] != '') { echo  $imagedata['thumb_img_url'];  }else { echo $imagedata['image_url'];  }  ?>" alt="<?php echo $imagedata['work_image']; ?>"></a></li>
						
					        <?php 
						    
						}
					$i++; } 
					  echo "</ul>";
				    }else {
						echo '<div class="alert alert-danger">  No Image found.</div>';
					}
					} }else{
						echo '<div class="alert alert-danger">  No Image found.</div>';
					}
				
					 ?>
					</div> 
					
				</ul>
		</div>
    </div>
	
	
	

	<style>
	 .staffwork_image li {
           
		   display: inline-block;
            padding: 0;
            position: relative;
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin-right: 0;
            object-fit: cover;
	  }
		.alert-danger {
		color: #a94442;
		background-color: #f2dede;
		border-color: #ebccd1;
		}
		.alert {
		padding: 10px;
		margin-top: 9px;
		margin-bottom: 20px;
		border: 1px solid transparent;
		border-radius: 4px;
		}
		
        ul.staffwork_image {
        display: flex;
        flex-wrap: wrap;
        }
        
        ul.staffwork_image li {
        display: flex;
        height: 150px;
        overflow: hidden;
        width: 150px;
        margin: 6px;
        border-radius: 5px;
        border: 3px solid #FFF;
        box-shadow: 0 2px 9px 0 rgba(0,0,0,0.1);
        }
        ul.staffwork_image li img {
        width: 100%;
        object-fit: cover;
        height: 150px;
        }
	 
	</style>
        <script> 
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1' , width:'75%'});
				$(".group2").colorbox({rel:'group2' , width:'75%'});
				$(".group3").colorbox({rel:'group3' , width:'75%'});
				
			});
		</script>	
		