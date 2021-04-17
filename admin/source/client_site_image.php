<!--LightBox--------->
	<link rel="stylesheet" href="source/popup/colorbox.css" />
	<script src="source/popup/jquery.colorbox.js"></script>
<!--LightBox--------->		

	<br>
	<br>
	
	<?php
	 //print_r($_GET);
		if($_GET['jobstatus'] == 'job'){ 
			$job_type_status = 1;
			$reclean_str = " AND job_type = 1 ";
			
		 }else{
			  $job_type_status = 2;
			  $reclean_str = " AND job_type = 2 ";
		 }	
		 
		 $imgtype = ucfirst($_GET['imgtype']);
		 $img_type = ucfirst($_GET['img_type']);
		 $img_type = ucfirst(str_replace('_' , ' ' ,$img_type));
	
	?>
	
	<div id="tab-5" class="loader" style="margin-top: -37px;">
	    <div class="tab5_main staffimages">
			    <ul class="tabs_5_ul_staff staff_upload_image" id="job_image_data" style="margin:  10px 0;">
				
				<h3 align="center"><?php  echo ucfirst($_GET['jobstatus']);  ?> Client Upload Images</h3>
				
					<div id="uploadImagedata">
					 <h4><?php  echo $img_type;  ?> Job Images upload</h4>
				     <?php
					 
					 
					  $staffsql = mysql_query("SELECT *  FROM `client_image_befor_after` where job_id ='".$_REQUEST['job_id']."' and status = 1 {$reclean_str} AND img_type = ".$imgtype."");
					  
					if(mysql_num_rows($staffsql) > 0) 
					{  
				            echo "<ul class='staffwork_image' style='margin: 14px;'>";
				         while($imagedata = mysql_fetch_assoc($staffsql)) 
					    {
							
							$i=1;
							//while($imagedata = mysql_fetch_array($getbeforeImage)) {

							$path =  getcwd();
							// $getSize = (getimagesize($imagedata['image_url']));
							if($imagedata['image_url'] !='') {
								
								?>
							
								<li id="imagefile" title="<?php  echo changeDateFormate($imagedata['createdOn'],'timestamp'); ?>">
									<a href="<?php if($imagedata['image_url'] != '') {  echo $imagedata['image_url'];  } else { echo  $imagedata['image_url'];  }  ?>" class="group1">
									 <img src="<?php if($imagedata['image_url'] != '') {  echo $imagedata['image_url'];  } elseif($imagedata['image_url'] != '') { echo  $imagedata['image_url'];  }  ?>" alt="<?php echo $imagedata['image_url']; ?>">
									</a>
									
									
								</li>
							
								<?php 
								 
							} 
								//$i++; } 
						 
							
				     	} 
						 echo "</ul>";
						
						?>
							 
						
					
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
				/* $(".group2").colorbox({rel:'group2' , width:'75%'});
				$(".group3").colorbox({rel:'group3' , width:'75%'}); */
				
			});
		</script>	
		