<!--LightBox--------->
	<link rel="stylesheet" href="source/popup/colorbox.css" />
	<script src="source/popup/jquery.colorbox.js"></script>
<!--LightBox--------->		

	<br>
	<br>
	
	<?php
	
		if($_GET['jobstatus'] == 'job'){ 
			$job_type_status = 1;
			$reclean_str = " AND reclean_id = 0 ";
			
		 }else{
			  $job_type_status = 2;
			  $reclean_str = " AND reclean_id != 0 ";
		 }	
		 
		 $imgtype = ucfirst($_GET['imgtype']);
		 $img_type = ucfirst($_GET['img_type']);
		 $img_type = ucfirst(str_replace('_' , ' ' ,$img_type));
	
	?>
	
	<div id="tab-5" class="loader" style="margin-top: -37px;">
	    <div class="tab5_main staffimages">
			    <ul class="tabs_5_ul_staff staff_upload_image" id="job_image_data" style="margin:  10px 0;">
				
				<h3 align="center"><?php  echo ucfirst($_GET['jobstatus']);  ?> Images</h3>
				
					<div id="uploadImagedata">
					 <h4><?php  echo $img_type;  ?> Work  Images upload</h4>
				     <?php
					//echo  "SELECT *  FROM `bcic_email_attach` WHERE `job_id` = ".$_REQUEST['job_id']."  AND img_type  = '".$imgtype."' and move_staff_img = 1 AND job_type = ".$job_type_status.""; 
					 
					 $getClientImg = mysql_query("SELECT *  FROM `bcic_email_attach` WHERE `job_id` = ".$_REQUEST['job_id']."  AND img_type  = '".$imgtype."' and move_staff_img = 1 AND job_type = ".$job_type_status."");
					 $countimg = mysql_num_rows($getClientImg);  
					   
					  $staffsql = mysql_query("SELECT DISTINCT(staff_id) as staffid  FROM `job_befor_after_image` where job_id ='".$_REQUEST['job_id']."' and image_status = ".$imgtype." {$reclean_str} AND job_type_status = ".$job_type_status."");
					  
					if(mysql_num_rows($staffsql) > 0 || $countimg > 0) 
					{  
				      while($getstaff_id = mysql_fetch_assoc($staffsql)) {
					
						$jobtype = get_sql("job_details","job_type"," where staff_id = ".$getstaff_id['staffid']." AND job_id=".$_REQUEST['job_id']." AND status != 2");	
						  
						   $getbeforeImage = mysql_query("SELECT * FROM `job_befor_after_image` where job_id ='".$_REQUEST['job_id']."' and image_status = ".$imgtype." {$reclean_str}   AND staff_id = '".$getstaff_id['staffid']."' AND job_type_status = ".$job_type_status."");
						
							echo '<h5>'.get_rs_value("staff","name",$getstaff_id['staffid']).'   ('.$jobtype.') Job Images ('.mysql_num_rows($getbeforeImage).')</h5>';
							
						if(mysql_num_rows($getbeforeImage)>0) { 
						
							echo "<ul class='staffwork_image' style='margin: 14px;'>";
							$i=1;
							while($imagedata = mysql_fetch_array($getbeforeImage)) {

							$path =  getcwd();
							
							if($imagedata['aws_url'] !='' && $imagedata['aws_status'] == 1) {
								
								?>
							
								<li id="imagefile" title="<?php  echo changeDateFormate($imagedata['created_at'],'timestamp'); ?>">
									<a href="<?php if($imagedata['aws_url'] != '') {  echo $imagedata['aws_url'];  } else { echo  $imagedata['aws_url'];  }  ?>" class="group1">
									 <img src="<?php if($imagedata['aws_url'] != '') {  echo $imagedata['aws_url'];  } elseif($imagedata['thum_aws_img'] != '') { echo  $imagedata['thum_aws_img'];  }  ?>" alt="<?php echo $imagedata['work_image']; ?>">
									</a>
									
									
								</li>
							
								<?php 
								 
							} else { 
							
							 $getSize = (getimagesize($imagedata['image_url']));
							 
							  if($imagedata['image_url'] !='' && !empty($getSize)) {
							 ?>
							 
							  <li id="imagefile" title="<?php  echo changeDateFormate($imagedata['created_at'],'timestamp'); ?>">
									<a href="<?php if($imagedata['thumb_img_url'] != '') {  echo $imagedata['thumb_img_url'];  } else { echo  $imagedata['image_url'];  }  ?>" class="group1">
									 <img src="<?php if($imagedata['image_url'] != '') {  echo $imagedata['image_url'];  } elseif($imagedata['thumb_img_url'] != '') { echo  $imagedata['thumb_img_url'];  }  ?>" alt="<?php echo $imagedata['work_image']; ?>">
									</a>
								</li>
							
							  <?php  } }
								$i++; } 
						  echo "</ul>";
							}else {
								echo '<div class="alert alert-danger">  No Image found.</div>';
							}
					} 
						 $siteUrl1  = Site_url; 
						echo "<ul class='staffwork_image' style='margin: 14px;'>";
						 while($getImg = mysql_fetch_assoc($getClientImg)) { 
						
						 $img = $siteUrl1 .'/mail/mail_attachments/'.$getImg['email_folder'].'/'.$getImg['email_attach'];
						
						?>
							 
							   <li id="imagefile" title="<?php  echo changeDateFormate($getImg['createdOn'],'timestamp'); ?>">
									<a href="<?php echo $img; ?>" class="group3">
									 <img src="<?php  echo  $img;  ?>" alt="<?php echo $getImg['email_attach']; ?>">
									</a>
								</li>
								
						 <?php } ?>
						</ul> 
					
					
					<?php  }else{ 
						echo '<div class="alert alert-danger">  No Image found.</div>';
					}
				
				
				
				
					 ?>
					</div> 
			
					<br/><br/>
					
				</ul>
			
			   
		</div>
    </div>
	 

        <script> 
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1' ,title:'<?php echo $img_type; ?> Images', width:'85%'});
				$(".group3").colorbox({rel:'group3' ,title:'Moved Images In <?php echo $img_type; ?>', width:'85%'});
				/* $(".group2").colorbox({rel:'group2' , width:'75%'});
				$(".group3").colorbox({rel:'group3' , width:'75%'}); */
				
			});
		</script>	
		