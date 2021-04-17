<?php  

       if(isset($_POST['submit'])) {
		   $tc_payment = mysql_real_escape_string($_POST['tc_payment']);

		   $bool = mysql_query("Update siteprefs set tc_payment = '".$tc_payment."' where id = 1");
		   if(isset($bool)) {
			   $message =  "1";
		   }else{
			   $message =  "2";
		   }
		}
		
		$getData =   mysql_fetch_assoc( mysql_query("SELECT tc_payment FROM `siteprefs` WHERE id = 1"));
		
		//print_r($getData);

?>
<div id="daily_view">

	    <form name="form1" method="post" action="" onsubmit="" enctype="multipart/form-data">
			<div class="job_wrapper">
				<div class="job_back_box">
				    <div    style="display: flex;">
						<span class="add_jobs_text">TC Payment SMS Status Show </span>
					</div>	

						 <?php  if(isset($message) && $message == 1) { ?><span style="float: right;color: green;margin-top: -35px;">TC Payment SMS Button Updated successfully.</span> <?php } ?>

						<ul class="dispatch_top_ul">
							<li> 					
								<label style="white-space:  nowrap;"><strong>TC Payment SMS </strong></label></br>
								<span><?php echo create_dd("tc_payment","system_dd","id","name","type=29","", $getData); ?></span>	 
							</li>
							<input type="submit" name="submit" class="job_submit" value="Update" style="margin-bottom: -8px;">
						</ul>	
				</div>
			</div>
	   </form>
</div>