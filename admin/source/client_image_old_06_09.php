<!--LightBox--------->
	<link rel="stylesheet" href="source/popup/colorbox.css" />
	<script src="source/popup/jquery.colorbox.js"></script>
<!--LightBox--------->		


<div id="tab-5" class="loader" >
	        <div class="tab5_main">
			     <ul class="tabs_5_ul_staff" id="job_image_data" style="margin:  10px 0;">
				    <!--<h4 align="center">Client Image</h4>-->
					    <div id="uploadImagedata">
							<div id="uploadImagedata">
							<br/>
							 <h4>Client Image</h4>
							 <?php
								 $ClientImage = mysql_query("select bcic_email_id,mail_type from job_emails where job_id=".mysql_real_escape_string($_REQUEST['job_id'])." order by date desc");

								 
								 /* echo  "select bcic_email_id,mail_type from job_emails where job_id=".mysql_real_escape_string($_REQUEST['job_id'])." order by date desc"; */
								 
								 // echo count($ClientImage;
								if(mysql_num_rows($ClientImage)>0) { 
									echo "<ul class='staffwork_image' style='margin: 14px;'>";
									$i=1;
									while($imagedata = mysql_fetch_assoc($ClientImage)) { 
									//print_r($imagedata);
									//$path =  getcwd();
									if($imagedata['bcic_email_id'] !='' && $imagedata['bcic_email_id'] != '0') {
										
										//print_r($imagedata);
										
										$getImgSql = mysql_query("SELECT *  FROM `bcic_email_attach` WHERE `email_id` = ".$imagedata['bcic_email_id']."  AND mail_type  = '".$imagedata['mail_type']."' and image_status = 1  ORDER BY `image_status`  DESC");
										
										if(mysql_num_rows($getImgSql) >  0) {
											
											while($getImg = mysql_fetch_assoc($getImgSql)) {
												
											if($getImg['email_attach'] != '') {
											    
											    
                                            $getexte = end(explode('.',$getImg['email_attach']));
                                            if($getexte == 'pdf') {
                                                $img =  "source/popup/pdf.jpg";
                                                $class = '';
                                                $target = "target = '_blank'";
                                            }elseif($getexte == 'docx' || $getexte == 'doc'){
                                                $img =  "source/popup/Word-icon.png";
                                                $class = '';
                                                $target = "target = '_blank'";
                                            }else {
                                                $img = '../../mail/mail_attachments/'.$getImg['email_folder'].'/'.$getImg['email_attach'];
                                                $class = 'group1';
                                                $target = '';
                                            }
											    
									  ?>
									  
                                         <li id="imagefile"><a href="../../mail/mail_attachments/<?php echo $getImg['email_folder']; ?>/<?php echo $getImg['email_attach']; ?>" <?php  echo $target; ?> class="<?php echo $class; ?>"><img src="<?php echo $img; ?>" style="height: 50px;" alt="<?php echo $getImg['email_attach']; ?>"></a></li>
										 
										 
									    <!--<li id="imagefile">
										    <a  href="../../mail/mail_attachments/<?php echo $getImg['email_folder']; ?>/<?php echo $getImg['email_attach']; ?>" target="_blank" class="group1">
											 <img alt="image"  width="50px"  class="img-responsive" src="../../mail/images/mail_img/defult_img.png">
										    </a>
										</li>-->

											<?php } }  } } $i++; } 
							    	echo "</ul>";
								}
							 ?>
							</div> 
					    </div> 
				</ul>
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
	 
	</style>
    </div>
     <script> 
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1' , width:'75%'});
				
			});
		</script>	