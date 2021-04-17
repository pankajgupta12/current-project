<!--LightBox--------->
	<link rel="stylesheet" href="source/popup/colorbox.css" />
	<script src="source/popup/jquery.colorbox.js"></script>
<!--LightBox--------->		

<?php  
  $ClientImage = mysql_query("select bcic_email_id,mail_type from job_emails where job_id=".mysql_real_escape_string($_REQUEST['job_id'])." order by date desc");
?>
<div id="tab-5" class="loader" >
	        <div class="tab5_main">
			     <ul class="tabs_5_ul_staff" id="job_image_data" style="margin:  10px 0;">
				    <!--<h4 align="center">Client Image</h4>-->
					<span id="text_message_data"></span>
					    <div id="uploadImagedata">
							<div id="uploadImagedata">
							<br/>
							 <h4>Client Image</h4>
							  <?php  if(mysql_num_rows($ClientImage)>0) 
							{  ?>
							 
							 <span>Select All <input style="margin-top: 10px;width: 40px;height: 22px;"  id="checkAll" type="checkbox" name="select_all" ></span>
							 
							
							<span style="float: right;"> 
							   Move To =>
							  <input type="button" class="check_images_button" onClick="getClientImage(1 ,'<?php echo $_REQUEST['job_id']; ?>' , 'job befor' , 1);" value=" Job Befor " />
							  <input type="button" class="check_images_button" onClick="getClientImage(2,'<?php echo $_REQUEST['job_id']; ?>' ,'job after',1);" value=" Job After" />
							  <input type="button" class="check_images_button" onClick="getClientImage(3,'<?php echo $_REQUEST['job_id']; ?>' ,'job checklist', 1);" value=" Job CheckList" />
							  <input type="button" class="check_images_button"   onClick="getClientImage(4,'<?php echo $_REQUEST['job_id']; ?>' , 'job no guarantee', 1);" value=" Job No Guarantee" />
							  <input type="button" class="check_images_button" onClick="getClientImage(5,'<?php echo $_REQUEST['job_id']; ?>' , 'job upsell', 1);" value=" Job Upsell" />
							  
							  <input type="button" class="check_images_button" onClick="getClientImage(1 ,'<?php echo $_REQUEST['job_id']; ?>' , 're-clean befor', 2);" value="  Re-Clean Befor " />
							  <input type="button" class="check_images_button" onClick="getClientImage(2,'<?php echo $_REQUEST['job_id']; ?>' ,'re-clean after', 2);" value=" Re-Clean After" />
							  <input type="button" class="check_images_button" onClick="getClientImage(3,'<?php echo $_REQUEST['job_id']; ?>' ,'re-clean checklist', 2);" value="  Re-Clean CheckList" />
							  
							 </span> 
							  <br/>
							  <br/>
							 <?php
								

								 
								 /* echo  "select bcic_email_id,mail_type from job_emails where job_id=".mysql_real_escape_string($_REQUEST['job_id'])." order by date desc"; */
								 
								 // echo count($ClientImage;
								//if(mysql_num_rows($ClientImage)>0) { 
									echo "<ul class='staffwork_image' style='margin: 14px;'>";
									$i=1;
									while($imagedata = mysql_fetch_assoc($ClientImage)) { 
									//print_r($imagedata);
									//$path =  getcwd();
									if($imagedata['bcic_email_id'] !='' && $imagedata['bcic_email_id'] != '0') {
										
										//print_r($imagedata);
										
										$getImgSql = mysql_query("SELECT *  FROM `bcic_email_attach` WHERE `email_id` = ".$imagedata['bcic_email_id']."  AND mail_type  = '".$imagedata['mail_type']."' and image_status = 1 AND move_staff_img = 0 ORDER BY `image_status`  DESC");
										
										if(mysql_num_rows($getImgSql) >  0) {
											
											while($getImg = mysql_fetch_assoc($getImgSql)) {
												
											if($getImg['email_attach'] != '') {
											    
											    $siteUrl1  = Site_url;
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
                                                $img = $siteUrl1 .'/mail/mail_attachments/'.$getImg['email_folder'].'/'.$getImg['email_attach'];
                                                $class = 'group1';
                                                $target = '';
                                            }
											    
									  ?>
									  
                                         <li id="imagefile"><a href="<?php echo $siteUrl1; ?>/mail/mail_attachments/<?php echo $getImg['email_folder']; ?>/<?php echo $getImg['email_attach']; ?>" <?php  echo $target; ?> class="<?php echo $class; ?>"><img src="<?php echo $img; ?>"  alt="<?php echo $getImg['email_attach']; ?>"></a>
										 <input type="checkbox" name="client_emails[]" id="client_emails<?php echo $getImg['id']; ?>"  class="client_emails"   onClick="" value="<?php echo $getImg['id']; ?>">
										 </li>
										 
										 
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
		
	  .check_images_button{
		padding: 4px;
		background: #00b8d4;
		border: 1px solid #fff;
		color: #fff;
		cursor: pointer;
	   }
	.client_emails {
		width: 20px;
		height: 20px;
		background-color: #000 !important;
		border: 2px solid #000 !important;
		color: #000;
	}
	#imagefile img{
	  width: 85px !important;
      height: 85px !important;
	}
	 
	</style>
    </div>
     <script> 
		 
			$( document ).ready(function() {
			   $("#checkAll").click(function(){
				   $('input:checkbox').not(this).prop('checked', this.checked);
				});
			}); 
	 
	 
	function getClientImage(movetype ,jobid ,movein, jobtype) {
				var allimgid = [];
					$('.staffwork_image').find(':checkbox:checked').each(function(i){
					   allimgid[i] = $(this).val();
					});
			 var len = allimgid.length	
			if(len == 0) {
					 alert('Please select at least one image');
					 /* $(':checkbox:checked').each(function(i){
					   allimgid[i] = $(this).val('');
					}); */
					 return false;
			}else {
				var r = confirm("Are you sure do you want move  in "+movein+" imgaes");
                     if (r == true) {
					 var str = allimgid+'|'+movetype+'|'+jobid+'|'+jobtype;
					//  alert(str);
					 
					 send_data(str , 567,  'text_message_data');
					  console.log(str);		
				 }
		    }
	}
	  
		/* $(function(){
			$('#save_value').click(function(){
				var val = [];
				$(':checkbox:checked').each(function(i){
				   val[i] = $(this).val();
				});
			});
		}); */
	   
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1' ,title:'Client Images', width:'75%'});
				
			});
		</script>	