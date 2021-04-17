<?php  
       if(isset($_POST['submit'])) {
		   $send_contact_sms = mysql_real_escape_string($_POST['send_contact_sms']);
		   
		   $bool = mysql_query("Update siteprefs set send_contact_sms = '".$send_contact_sms."' , Contactsms_updated = '".date('Y-m-d H:i:s')."' where id = 1");
		   if(isset($bool)) {
			   $message =  "1";
		   }else{
			   $message =  "2";
		   }
		}
		
		$getData =   mysql_fetch_assoc( mysql_query("SELECT send_contact_sms FROM `siteprefs` WHERE id = 1"));
		
		//print_r($getData); 
		
?>

<div id="daily_view">
	
	    <form name="form1" method="post" action="" onsubmit="" enctype="multipart/form-data">

			<div class="job_wrapper">

				<div class="job_back_box">
				    <div    style="display: flex;">
						<span class="add_jobs_text">Contact SMS Setting</span>
					</div>	

						 <?php  if(isset($message) && $message == 1) { ?><span style="float: right;color: green;margin-top: -35px;">SMS Contact Updated successfully.</span> <?php } ?>
						<ul class="dispatch_top_ul">
							<li> 					
								<label style="white-space:  nowrap;"><strong>SMS Setting</strong></label></br>
									
								<span><?php echo create_dd("send_contact_sms","system_dd","id","name","type=67","", $getData); ?></span>	 
							</li>
							
							<input type="submit" name="submit" class="job_submit" value="Update" style="margin-bottom: -8px;">
						</ul>	

				</div>

			</div>

	   </form>
</div>