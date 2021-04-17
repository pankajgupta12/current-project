<ul class="cret_right_ul">
      <?php
	
	 /* $job_arg = "select * from jobs where status=1 and id in(select job_id from job_details where staff_id=0 and status!=2) limit 0,50";
	  $jobs_data = mysql_query($job_arg);
	  if(mysql_num_rows($jobs_data)>0){ 
	  		include("dispatch_side_not_assigned.php");
	  }*/
	
		include("dispatch_side_status.php");
	  
	  ?>
</ul>