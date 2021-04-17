<?php  

       if(isset($_POST['submit'])) {
		   $sms_for_notify = mysql_real_escape_string($_POST['sms_for_notify']);

		   $bool = mysql_query("Update siteprefs set sms_for_notify = '".$sms_for_notify."' where id = 1");
		   if(isset($bool)) {
			   $message =  "1";
		   }else{
			   $message =  "2";
		   }
		}
		
		$getData =   mysql_fetch_assoc( mysql_query("SELECT sms_for_notify FROM `siteprefs` WHERE id = 1"));
	
?>
<div id="daily_view">

	    <form name="form1" method="post" action="" onsubmit="" enctype="multipart/form-data">
			<div class="job_wrapper">
				<div class="job_back_box">
				    <div    style="display: flex;">
						<span class="add_jobs_text">SMS & Notification Status </span>
						<!--<span>(When Yes=>both are Open and You Can send Seprate SMS & No=>Show Only SMS button and Send both SMS &  Chat In One ) </span>-->
					</div>	

						<?php  if(isset($message) && $message == 1) { ?><span style="float: right;color: green;margin-top: -35px;">SMS & Notification Button Updated successfully.</span> <?php } ?>

						<ul class="dispatch_top_ul">
							<li> 					
								<label style="white-space:  nowrap;"><strong>SMS & Notification Status </strong></label></br>
								<span><?php echo create_dd("sms_for_notify","system_dd","id","name","type=29","", $getData); ?></span>	 
							</li>
							<input type="submit" name="submit" class="job_submit" value="Update" style="margin-bottom: -8px;">
						</ul>	
				</div>
			</div>
	    </form>
</div>