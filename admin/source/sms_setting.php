<?php  
       if(isset($_POST['submit'])) {
		   $sms_setting = mysql_real_escape_string($_POST['sms_setting']);
		   
		   $bool = mysql_query("Update siteprefs set sms_setting = '".$sms_setting."' where id = 1");
		   if(isset($bool)) {
			   $message =  "1";
		   }else{
			   $message =  "2";
		   }
		}
		
		$getData =   mysql_fetch_assoc( mysql_query("SELECT sms_setting FROM `siteprefs` WHERE id = 1"));
		
?>

<div id="daily_view">
	
	    <form name="form1" method="post" action="" onsubmit="" enctype="multipart/form-data">

			<div class="job_wrapper">

				<div class="job_back_box">
				    <div    style="display: flex;">
						<span class="add_jobs_text">SMS Setting</span>
					</div>	

						 <?php  if(isset($message) && $message == 1) { ?><span style="float: right;color: green;margin-top: -35px;">SMS Setting Updated successfully.</span> <?php } ?>
						<ul class="dispatch_top_ul">
							<li> 					
								<label style="white-space:  nowrap;"><strong>SMS Setting</strong></label></br>
									
								<span><?php echo create_dd("sms_setting","system_dd","id","name","type=62","", $getData); ?></span>	 
							</li>
							
							<input type="submit" name="submit" class="job_submit" value="Update" style="margin-bottom: -8px;">
						</ul>	

				</div>

			</div>

	   </form>
</div>