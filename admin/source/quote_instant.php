<?php  
       if(isset($_POST['submit'])) {
		   $quote_instant = mysql_real_escape_string($_POST['instant_quote']);
		   
		   $bool = mysql_query("Update siteprefs set instant_quote = '".$quote_instant."' where id = 1");
		   if(isset($bool)) {
			   $message =  "1";
		   }else{
			   $message =  "2";
		   }
		}
		
		$getData =   mysql_fetch_assoc( mysql_query("SELECT instant_quote FROM `siteprefs` WHERE id = 1"));
		
?>

<div id="daily_view">
	
	    <form name="form1" method="post" action="" onsubmit="" enctype="multipart/form-data">

			<div class="job_wrapper">

				<div class="job_back_box">
				    <div    style="display: flex;">
						<span class="add_jobs_text">Quote Instant Update</span>
					</div>	

						 <?php  if(isset($message) && $message == 1) { ?><span style="float: right;color: green;margin-top: -35px;">Quote Instant Updated successfully.</span> <?php } ?>
						<ul class="dispatch_top_ul">
							<li> 					
								<label style="white-space:  nowrap;"><strong>Quote instant Active/Deactive</strong></label></br>
									
								<span><?php echo create_dd("instant_quote","system_dd","id","name","type=57","", $getData); ?></span>	 
							</li>
							
							<input type="submit" name="submit" class="job_submit" value="Update" style="margin-bottom: -8px;">
						</ul>	

				</div>

			</div>

	   </form>
</div>